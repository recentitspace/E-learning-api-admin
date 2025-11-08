<?php

namespace Modules\LMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'chapter_id' => 'required',
            'topic_type' => 'required',
            'title' => 'required',
            'duration' => 'required',
            'description' => Request()->topic_type == 'supplement' ? 'required' : '',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
