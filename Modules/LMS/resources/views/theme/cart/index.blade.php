<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one 
        pageTitle="Shopping Cart" 
        pageRoute="{{ route('cart.page') }}"
        pageName="Shopping Cart" 
    />
    <div class="container">
        @if (isset($data['cartCourses']['courses']) && !empty($data['cartCourses']['courses']))
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-full lg:col-span-8">
                    <div class="overflow-x-auto">
                        <x-theme::carts.cart-list :cartCourses="$data['cartCourses']['courses']" />
                    </div>
                </div>
                <x-theme::carts.cart-sidebar :data="$data" />
            </div>
        @else
            <x-theme::cards.empty 
                title="Ready to Learn?"
                description="Your cart is waiting to be filled with knowledge! Discover new courses and kickstart your education."
                btn="true" 
                btnAction="{{ route('course.list') }}" 
                btntext="Learning Continue" 
            />
        @endif
    </div>
</x-frontend-layout>
