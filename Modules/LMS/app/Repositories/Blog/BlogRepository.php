<?php

namespace Modules\LMS\Repositories\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\LMS\Models\Blog\Blog;
use Modules\LMS\Models\BlogComment;
use Modules\LMS\Repositories\BaseRepository;

class BlogRepository extends BaseRepository
{
    protected static $model = Blog::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['image', 'blog_categoryId', '_token', 'locale'],
        'update' => ['image', 'blog_categoryId', '_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|string',
            'blog_categoryId' => 'required|array',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
            'description' => 'required',
        ],
        'update' => [
            'title' => 'required|string',
            'blog_categoryId' => 'required|array',
            'description' => 'required',
        ],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        if ($request->hasFile('image')) {
            $image = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/blogs');
            $request->merge(['thumbnail' => $image]);
        }

        // Add slug and user/admin ID based on current authentication
        $request->merge([
            'slug' => Str::slug($request->title),
            'admin_id' => Auth::guard('admin')->id() ?: null,
            'user_id' => authCheck()?->user()->id ?? null,
        ]);

        // Save the blog
        $blogResponse = parent::save($request->all());
        $blog = $blogResponse['data'] ?? null;

        // Attach categories if save was successful
        if ($blogResponse['status'] == 'success' && $blog) {
            $blog->blogCategories()->attach($request->input('blog_categoryId'));
            $data = self::translateData($request->all());
            self::translate($blog, $data, locale: $request->locale ?? app()->getLocale());
        }

        return $blogResponse;
    }

    /**
     * @param  int  $id
     * @param  Request  $data
     * @return {array}
     */
    public static function update($id, $request): array
    {
        $blogResponse = parent::first(value: $id);
        $blog = $blogResponse['data'] ?? null;

        if (! $blog) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        // Update validation rules if a new image is uploaded
        if ($request->hasFile('image')) {
            static::$rules['update'] = [
                'image' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
                'title' => 'required|string',
                'blog_categoryId' => 'required|array',
                'description' => 'required',
            ];

            $image = parent::upload($request, fieldname: 'image', file: $blog?->thumbnail, folder: 'lms/blogs');
            $request->merge(['thumbnail' => $image]);
        }

        $data = self::translateData($request->all());
        $defaultLanguage = app()->getLocale();
        self::translate(blog: $blog,  data: $data, locale: $request->locale);

        if ($request->locale &&  $defaultLanguage !== $request->locale) {
            return [
                'status' => 'success',
                'data' => $blog,
            ];
        }

        // Add slug to request
        $request->merge(['slug' => Str::slug($request->title)]);

        // Update blog and sync categories if successful
        $blog = parent::update($id, $request->all());
        if ($blog['status'] === 'success') {
            $blog['data']->blogCategories()->sync($request->input('blog_categoryId'));
        }

        return $blog;
    }

    /**
     * delete
     *
     * @param  $id  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $response = parent::first($id, withTrashed: true);
        $blog = $response['data'] ?? null;
        if ($blog && $response['status'] == 'success') {
            $isDeleteAble = true;
            if (static::isSoftDeleteEnable() && ! $blog->trashed()) {
                $isDeleteAble = false;
            }

            if ($isDeleteAble) {
                parent::fileDelete(folder: 'lms/blogs', file: $blog->thumbnail);
            }

            return parent::delete(id: $id);
        }

        return $response;
    }

    /**
     *  statusChange
     */
    public function statusChange($id): array
    {
        $blog = parent::first($id);
        $blog = $blog['data'];
        $blog->status = ! $blog->status;
        $blog->update();

        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully')
        ];
    }

    /**
     * blogList
     *
     * @param  mixed  $request  searching query
     * @return object
     */
    public function blogList($request)
    {
        $blogs = static::$model::query();


        // Apply search filter if `search_key` is provided
        if ($request->filled('search_key')) {
            $search_key = $request->search_key;
            $blogs->where('title', 'LIKE', "%{$search_key}%");
        }

        // Apply category filter if `category` is provided
        if ($request->filled('category')) {
            $category = $request->category;
            $blogs->whereHas('blogCategories', function ($query) use ($category) {
                $query->whereIn('blog_category_id', (array) $category);
            });
        }



        // Fetch the results with necessary relations and status filter
        return $blogs->with('adminAuthor', 'author', 'translations')
            ->where('status', 1)
            ->latest()
            ->paginate(6);
    }

    /**
     *  blogDetail
     *
     * @param  string  $slug
     * @return object
     */
    public function blogDetail($slug)
    {
        $blog = static::$model::with('blogCategories', 'author', 'adminAuthor', 'comments.replies', 'comments.user', 'translations')
            ->where(['slug' => $slug, 'status' => 1])
            ->first();

        $blog->update([
            'view' => $blog->view += 1
        ]);

        return $blog;
    }

    /**
     * commentStore
     *
     * @param  mixed  $request
     */
    public function commentStore($request): array
    {

        // Define validation rules
        static::$rules['save'] = [
            'comment' => 'required|string',
            'blog_id' => 'required|integer',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), static::$rules['save']);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray(),
            ];
        }

        // Set up data for creating or updating the comment
        $data = [
            'user_id' => authCheck()->id,
            'blog_id' => $request->blog_id,
            'reply_id' => $request->reply_id,
            'comment' => $request->comment,
        ];

        // Create or update the comment
        $blogComment = BlogComment::updateOrCreate(['id' => $request->id ?? null], $data);

        // Return the appropriate response based on the result
        return [
            'status' => $blogComment ? 'success' : 'error',
            'message' => $blogComment ? translate('Thank you for your comment.') : translate('Something wrong!'),
        ];
    }

    public static function translateData(array $data)
    {
        $data = [
            'title' => $data['title'],
            'description' => $data['description'],
        ];

        return $data;
    }

    public static function translate($blog, $data, $locale)
    {
        $blog->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
