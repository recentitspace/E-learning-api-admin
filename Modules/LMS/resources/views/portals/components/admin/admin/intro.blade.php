<div class="col-span-full 2xl:col-span-full card p-0">
    <div class="grid grid-cols-12 items-center px-5 sm:px-12 py-11 relative overflow-hidden h-full">
        <div class="col-span-full md:col-span-7 self-center inline-flex flex-col 2xl:block">
            <p class="!leading-none text-sm lg:text-base text-gray-900">
                {{ translate('Today is') }}
                {{ customDateFormate(now(), 'd M Y') }}
            </p>
            <h1 class="text-2xl sm:text-4xl text-heading dark:text-white leading-[1.23] font-semibold mt-3">
                <span class="flex-center justify-start">
                    <span class="shrink-0">{{ translate('Welcome Back') }}.</span>
                    <span class="select-none hidden md:inline-block animate-hand-wave origin-[70%_70%]">👋</span><br>
                </span>
                {{ $name }}
            </h1>
        </div>
        <!-- Graphical Elements -->
        <ul>
            <li class="absolute -top-[30px] left-1/2 animate-spin-slow">
                <img src="{{ asset('lms/assets/images/element/graphical-element-1.svg') }}" alt="element">
            </li>
            <li class="absolute -bottom-[24px] left-1/4 animate-spin-slow">
                <img src="{{ asset('lms/assets/images/element/graphical-element-2.svg') }}" alt="element">
            </li>
        </ul>
    </div>
</div>
