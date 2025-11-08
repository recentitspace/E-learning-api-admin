<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one
        pageTitle="Contact" 
        pageRoute="{{ route('contact.page') }}" 
        pageName="Contact" 
    />
    <!-- START CONTACT OVERVIEW -->
    <div class="container">
        <div class="grid grid-cols-12 gap-4 xl:gap-7">
            <x-theme::contact-form.contact-information />
        </div>
    </div>
    <!-- END CONTACT OVERVIEW -->
    <!-- START CONTACT FORM -->
    <div class="bg-primary-50 mt-16 sm:mt-24 lg:mt-[120px] -mb-16 sm:-mb-24 lg:-mb-[120px] relative overflow-hidden">
        <div class="container">
            <div class="grid grid-cols-2">
                <div class="col-span-full lg:col-auto bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
                    <h5 class="area-title">{{ translate('Free Consultation') }}</h5>
                    <x-theme::contact-form.form class="mt-10 lg:max-w-screen-sm lg:pr-[10%] rtl:lg:pr-0 rtl:lg:pl-[10%]" formType="support" />
                </div>
                <div class="col-span-full lg:col-auto bg-primary-50 lg:absolute lg:w-1/2 lg:h-full lg:top-0 lg:bottom-0 lg:!right-0 rtl:lg:!right-auto rtl:lg:!left-0 hidden lg:block">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3074160.585504608!2d72.1067713!3d41.1975765!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1731426205694!5m2!1sen!2sbd"
                        width="100%" height="100%" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTACT FORM -->
</x-frontend-layout>
