@if (!empty($questionScore) && $questionScore['status'] == 1)
    <!-- STATUS -->
    <div class="aleart a-outline aleart-success-outline mt-4">
        <div class="flex items-center gap-2.5">
            <i class="ri-checkbox-circle-line"></i>
            <span class="font-bold">{{ translate('Correct') }}.</span>
        </div>
    </div>
@else
    <div class="aleart a-outline aleart-danger-outline !block mt-4">
        <div class="flex items-center gap-2.5">
            <i class="ri-close-circle-line"></i>
            <span class="font-bold"> {{ translate('Incorrect') }} .</span> {{ translate('Correct answer is') }}...
        </div>
        <ul class="mt-2 list-decimal list-inside [&>:not(:first-child)]:mt-1.5">
            @foreach ($answers as $key => $answer)
                @if (!empty($answer))
                    <li> {{ $answer }}
                    </li>
                @endif
            @endforeach

        </ul>
    </div>
@endif
