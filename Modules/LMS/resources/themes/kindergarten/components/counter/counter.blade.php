@php
    $counter = get_theme_option(key: 'counter') ?? [];
    $satisfiedStudents = ($counter['satisfied_student'] ?? 0) / 1000 ;
    $satisfiedCounterData = $satisfiedStudents < 1 ? $satisfiedStudents * 1000 : $satisfiedStudents;
@endphp

<div class="mx-3 mt-16 sm:mt-24 lg:mt-[120px] relative z-[1]">
    <div class="bg-primary lg:bg-[url('{{ asset('lms/frontend/assets/images/counter/counter-bg.png') }}')] bg-no-repeat bg-cover max-w-[1600px] mx-auto py-[60px] rounded-[20px]">
        <div class="container">
            <div class="grid grid-cols-13 gap-x-4 xl:gap-x-7 gap-y-7 items-center">
                <div class="col-span-full lg:col-span-4">
                    <h2 class="area-title !text-white">
                        {{ translate( 'By the Numbers of' ) }}
                        <span class="title-highlight-two !text-secondary">{{ translate('Our Impact') }}</span>
                    </h2>
                </div>
                <div class="col-span-full sm:col-span-4 lg:col-span-3">
                    <div class="flex-center flex-col gap-3.5 text-center py-8 bg-white/10 rounded-xl border-2 border-dashed border-white/20 relative before:absolute before:size-full before:inset-0 before:border-2 before:border-dashed before:border-white/20 before:rounded-xl before:rotate-[-5deg] hover:before:rotate-0 before:duration-300">
                        <h6 class="area-title !text-white leading-none"><span class="lms-counter" data-value="{{ $satisfiedCounterData }}">{{ $satisfiedCounterData }}</span>{{$satisfiedStudents < 1 ? '+' : translate('k+') }}</h6>
                        <div class="text-white/70 text-lg font-bold leading-none">{{ translate( 'Satisfied students' ) }}</div>
                    </div>
                </div>
                <div class="col-span-full sm:col-span-4 lg:col-span-3">
                    <div class="flex-center flex-col gap-3.5 text-center py-8 bg-white/10 rounded-xl border-2 border-dashed border-white/20 relative before:absolute before:size-full before:inset-0 before:border-2 before:border-dashed before:border-white/20 before:rounded-xl before:rotate-[-5deg] hover:before:rotate-0 before:duration-300">
                        <h6 class="area-title !text-white leading-none"><span class="lms-counter" data-value="{{ $counter['expert_tutor'] ?? 0 }}">{{ $counter['expert_tutor'] ?? 0 }}</span>+</h6>
                        <div class="text-white/70 text-lg font-bold leading-none">{{ translate( 'Best Instructors' ) }}</div>
                    </div>
                </div>
                <div class="col-span-full sm:col-span-4 lg:col-span-3">
                    <div class="flex-center flex-col gap-3.5 text-center py-8 bg-white/10 rounded-xl border-2 border-dashed border-white/20 relative before:absolute before:size-full before:inset-0 before:border-2 before:border-dashed before:border-white/20 before:rounded-xl before:rotate-[-5deg] hover:before:rotate-0 before:duration-300">
                        <h6 class="area-title !text-white leading-none"><span class="lms-counter" data-value="{{ $counter['total_experience'] ?? 0 }}">{{ $counter['total_experience'] ?? 0 }}</span>+</h6>
                        <div class="text-white/70 text-lg font-bold leading-none">{{ translate( 'Years of experience' ) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>