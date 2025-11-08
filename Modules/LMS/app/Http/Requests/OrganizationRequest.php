<?php

namespace Modules\LMS\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrganizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
            'name' => Request()->form_key == 'basic' ? 'required' : '',
            'phone' => Request()->form_key == 'basic' ? 'required|unique:organizations,phone,'.Request()->organization_id : '',
            'profile_image' => Request()->form_key == 'media' ? (isset(Request()->profile_image) ? 'required|image|mimes:jpg,jpeg,png,bmp,tiff,webp,svg' : '') : '',
            'profile_cover' => Request()->form_key == 'media' ? (isset(Request()->profile_cover) ? 'required|image|mimes:jpg,jpeg,png,bmp,tiff,webp,svg' : '') : '',
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
