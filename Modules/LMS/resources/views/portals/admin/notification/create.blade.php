<x-dashboard-layout>
    <x-slot:title>
        @if (isset($notification))
            {{ translate('Edit Notification') }}
        @else
            {{ translate('Create Notification') }}
        @endif
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($notification) ? 'Edit' : 'Create' }}"
        back-url="{{ route('notification.index') }}" page-to="Notification" />
    <form
        action="{{ isset($notification) ? route('notification.update', $notification->id) : route('notification.store') }}"
        method="POST" class="form" enctype="multipart/form-data">
        @if (isset($notification))
            @method('put')
        @endif
        @csrf
        <div class="card">
            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                <div class="col-span-full xl:col-auto leading-none">
                    <label class="text-gray-500 dark:text-dark-text font-medium pb-2.5 inline-block">
                        {{ translate('Title') }}
                    </label>
                    <input type="text" name="title" placeholder="{{ translate('Enter Title') }}" class="form-input"
                        value="{{ $notification->title ?? '' }}">
                    <span class="text-danger error-text title_err"></span>
                </div>
                <div class="col-span-full xl:col-auto leading-none">
                    <label for="notification" class="text-gray-500 dark:text-dark-text font-medium pb-2.5 inline-block">
                        {{ translate('Template Name') }}
                    </label>
                    <input type="text" name="template_name" id="notification"
                        placeholder="{{ translate('Template Name') }}" class="form-input"
                        value="{{ $notification->template_name ?? '' }}">
                    <span class="text-danger error-text template_name_err"></span>
                </div>
                <div class="col-span-full leading-none">
                    <label for="description" class="text-gray-500 dark:text-dark-text font-medium pb-2.5 inline-block">
                        {{ translate('Content') }}
                    </label>
                    <textarea name="description" class="summernote">{!! clean($notification->description ?? '') !!}</textarea>
                    <span class="text-danger error-text description_err"></span>
                    <p class="mt-4 card-description">
                        {{ translate('You can use the following dynamic values') }}:
                        <span class="font-bold"> [discount_amount], [discount_code], [user_name], [time_date],
                            [user_role], [course_title], [organization_name], [user.name], [course_status], and [status]
                        </span>.
                    </p>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($notification) ? translate('Update') : translate('Submit') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
