<?php

namespace Modules\LMS\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user wants to force JSON response
     */
    public function wantsJson(): bool
    {
        return true; // Always return JSON
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'title' => Request()->form_key == 'basic' ? 'required|string' : '',
            'category_id' => Request()->form_key == 'basic' ? 'required' : '',
            'short_description' => Request()->form_key == 'basic' ? 'required' : '',
            'description' => Request()->form_key == 'basic' ? 'required' : '',
            'duration' => Request()->form_key == 'basic' ? 'required' : '',
            'time_zone_id' => Request()->form_key == 'basic' ? 'required' : '',
            'video_src_type' => Request()->form_key == 'basic' ? 'required' : '',
            'subject_id' => Request()->form_key == 'basic' ? 'required' : '',

            'thumbnail' => Request()->form_key == 'basic' ? (isset(Request()->course_id) ? (isset(Request()->thumbnail) ? 'required' : '') : 'required') : '',


            // 'demo_url' =>  Request()->form_key == "basic" ? 'required' : "",
            'levels' => Request()->form_key == 'basic' ? 'required|array' : '',
            'instructors' => Request()->form_key == 'basic' ? 'required|array' : '',
            'languages' => Request()->form_key == 'basic' ? 'required|array' : '',
            'preview_image' => Request()->form_key == 'media' ? (isset(Request()->course_id) ? '' : 'required|array') : '',
            'price' => Request()->form_key == 'pricing' ? 'required' : '',
            'discounted_price' => Request()->form_key == 'pricing' ? (Request()->discount_flag == 'on' ? 'required' : '') : '',
            'currency' => Request()->form_key == 'pricing' ? 'required'  : '',
            'course_id' => Request()->form_key == 'noticeboard' || Request()->form_key == 'additional_information' || Request()->form_key == 'setting' || Request()->form_key == 'pricing' || Request()->form_key == 'media' ? 'required' : '',

        ];
    }

    public function messages()
    {

        return [
            'course_id.required' => 'Create Basic Information First',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'data' => $validator->errors(),
                    'errors' => $validator->errors(),
                ],
                422
            )
        );
    }
}
