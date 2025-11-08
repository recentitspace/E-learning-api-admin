<div class="bg-primary-50 rounded-none lg:rounded-xl">
    <div class="flex-center-between p-6">
        <h6 class="area-title text-xl !leading-none">
            {{ translate('News Post') }}
        </h6>
    </div>
    <x-theme::cards.blog-card-two :latestBlogs=$latestBlogs />
</div>
