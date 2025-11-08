@if ($blog->comments && $blog->comments->count() > 0)
    <article>
        <h2 class="area-title xl:text-3xl mb-5"> {{ translate('Comment') . ' ' . $blog?->comments?->count() ?? 0 }}</h2>
        <ul class="flex flex-col gap-5">
            <x-theme::comments.user-comment-list :comments="$blog->comments" />
        </ul>
    </article>
@endif
@auth
    <article>
        <h2 class="area-title xl:text-3xl mb-5"> {{ translate('Leave a Comment') }} </h2>
        <form class="form" action="{{ route('blog.comment') }}" method="POST">
            @csrf
            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
            <input type="hidden" name="reply_id" id="replyId">
            <input type="hidden" name="user_id" value="{{ authCheck()->id }}">

            <div class="relative">
                <textarea id="instructor-education" rows="10" name="comment" class="form-input rounded-2xl h-auto peer"
                    placeholder=""></textarea>
                <label for="instructor-education" class="form-label floating-form-label">
                    {{ translate('Write your message') }}
                </label>
            </div>
            <span class="text-danger error-text comment_err"></span>
            <div class="mt-5 flex gap-2">
                <button type="submit" class="btn b-solid btn-primary-solid !rounded-full comment-button">
                    {{ translate('Submit Now') }}
                </button>
                <button type="button" class="cancel-button btn b-solid btn-danger-solid !rounded-full">
                    {{ translate('Cancel') }}
                </button>
            </div>
        </form>
    </article>
@endauth
<!-- LEAVE A COMMENT -->
