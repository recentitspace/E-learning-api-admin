<?php

namespace Modules\LMS\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BundleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'title' => Request()->form_key == 'basic' ? 'required|string' : '',
            'category_id' => Request()->form_key == 'basic' ? 'required' : '',
            'instructor_id' => Request()->form_key == 'basic' ? 'required' : '',
            'details' => Request()->form_key == 'basic' ? 'required' : '',
            'levels' => Request()->form_key == 'basic' ? 'required' : '',
            'currency' => Request()->form_key == 'pricing' ? 'required' : '',
            'video_src_type' => Request()->form_key == 'media' ? 'required' : '',
            'thumbnail' => Request()->form_key == 'media' ? (isset(Request()->bundle_id) ? (isset(Request()->thumbnail) ? 'required|image|mimes:jpg,jpeg,png,bmp,tiff,webp,svg' : '') : 'required|image|mimes:jpg,jpeg,png,bmp,tiff,webp,svg') : '',

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
                    'data' => $validator->errors(),
                ]
            )
        );
    }
}
