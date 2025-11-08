<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="skill">
        @csrf
        <input type="hidden" name="id" value="{{ authCheck()?->userable?->id }}">
        <input type="hidden" name="user_id" value="{{ authCheck()?->id }}">
        <div class="card">

            <div class="form-label block"> {{ translate('Enter your Previous skill') }} .</div>
            <span>
                @if (count(authCheck()->skills) > 0)
                    @php
                        $skills = [];
                    @endphp
                    @foreach (authCheck()->skills as $skill)
                        @php
                            array_push($skills, $skill->id);
                        @endphp
                        <span class="tm-tag" id="vlgLk_{{ $skill->id }}"><span>{{ $skill->name }}</span>
                            <a href="#" data-id="{{ $skill->id }}" class="tm-tag-remove skill-remove"
                                id="vlgLk_Remover_{{ $skill->id }}" tagidtoremove="{{ $skill->id }}">x</a>
                        </span>
                    @endforeach
                    <input type="hidden" id="exitingSkills" name="exitingSkills" value="{{ implode(',', $skills) }}" />
                @endif
            </span>
            <input type="text" name="skills" placeholder="{{ translate('Enter Your Skill') }}"
                class="typeahead tm-input form-input" />
            <label class="form-label m-0 text-gray-900"> {{ translate('Please press') }}
                <code>[{{ translate('Enter') }}]</code>
                {{ translate('after writing your skill keyword') }}.</label>
        </div>
        <div class="card flex justify-end gap-4">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline"> {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }} </button>
        </div>
    </form>
</div>
