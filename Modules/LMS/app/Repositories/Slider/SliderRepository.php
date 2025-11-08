<?php


namespace Modules\LMS\Repositories\Slider;

use Illuminate\Http\Request;
use Modules\LMS\Models\Slider\Slider;
use Modules\LMS\Repositories\BaseRepository;

class SliderRepository extends BaseRepository
{
    protected static $model = Slider::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [

        'save' => ['_token', '_method', 'slider_image', 'locale'],
        'update' => ['_token', '_method', 'slider_image', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|unique:sliders,title',
            'slider_image' => 'required',
            // 'hero_id'  => 'required',
        ],

    ];

    /**
     *
     * @param  Request $request 
     */
    public static function save($request): array
    {
        if ($request->hasFile('slider_image'))
            static::$rules['save']['slider_image'] = 'required|image|mimes:webp,jpeg,jpg,png,svg';
        $sliderImg = parent::upload($request, 'slider_image', '', folder: 'lms/sliders'); {
            $request->merge(['image' => $sliderImg]);
        }
        $request->merge(['buttons' => $request->buttons[0], 'status' => $request->status == "on" ? 1 : 0]);

        $response = parent::save($request->all());
        $slider = $response['data'] ?? null;
        if ($response['status'] === 'success' && $slider) {
            
            $data = self::translateData($request->all());
            self::translate($slider, $data, locale: $request->locale ?? app()->getLocale());
        }
        return $response;
    }

    /**
     * @param  int  $id
     * @param  Request $request 
     */
    public static function update($id, $request): array
    {

        $response = parent::first($id);
        $slider = $response['data'];

        // Define the base validation rules for updating
        static::$rules['update'] = [
            'title' => 'required|unique:sliders,title,' . $id,
            // 'hero_id' => 'required',
        ];

        // Check if the request contains a file for 'slider_image'
        if ($request->hasFile('slider_image')) {
            // Add specific validation rules for the file
            static::$rules['update']['slider_image'] = 'required|image|mimes:webp,jpeg,jpg,png,svg';

            // Handle the file upload
            $sliderImg = parent::upload($request, 'slider_image', $slider->image ?? '', folder: 'lms/sliders');

            // Update the request data with the new file path
            $request->merge(['image' => $sliderImg ?? $slider->image]);
        }
        $request->merge(['buttons' => $request->buttons[0], 'status' => $request->status == "on" ? 1 : 0]);
        // Perform the update with validated data
        $data = self::translateData($request->all());

        $defaultLanguage = app()->getLocale();

        self::translate(slider: $slider,  data: $data, locale: $request->locale);

        if ($request->locale &&  $defaultLanguage !== $request->locale) {
            return [
                'status' => 'success',
            ];
        }

        $response = parent::update($id, $request->all());

        return $response;
    }



    /**
     * Change the status of a icon by ID.
     *
     * @param  int  $id
     * @return array
     */
    public static function statusChange($id): array
    {
        $response = parent::first($id);
        $icon = $response['data'];
        // Check if language is found
        if (!$response['status']) {
            return [
                'status' => 'error',
                'message' => 'Language not found.'
            ];
        }

        // Toggle status and save
        $icon->status = !$icon->status;
        $icon->update();
        return [
            'status' => 'success',
            'message' => 'Status changed successfully.'
        ];
    }

    public static function translateData(array $data)
    {
        $data = [
            'title' => $data['title'],
            'highlight_text' => $data['highlight_text'],
            'sub_title' => $data['sub_title'],
            'buttons' => $data['buttons'],
            'description' => $data['description']
        ];

        return $data;
    }

    public static function translate($slider, $data, $locale)
    {
        $slider->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
