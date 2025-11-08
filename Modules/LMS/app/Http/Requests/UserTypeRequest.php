<?php

namespace Modules\LMS\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        if (Request()->form_key == 'basic' && Request()->type == 'instructor') {
            $phone = 'required|unique:instructors,phone,' . Request()->id;
            $phone = 'required';
        } elseif (Request()->form_key == 'basic' && Request()->type == 'organization') {
            $phone = 'required|unique:organizations,phone,' . Request()->id;
        }

        if (Request()->form_key == 'extra' && Request()->type == 'instructor') {
            $gender = 'required';
        }
        return [
            //
            'first_name' => Request()->form_key == 'basic' && Request()->type == 'instructor' ? 'required' : '',
            'name' => Request()->form_key == 'basic' && Request()->type == 'organization' ? 'required' : '',
            'phone' => $phone ?? '',
            'gender' => $gender ?? '',
            'last_name' => Request()->form_key == 'basic' && Request()->type == 'instructor' ? 'required' : '',
            'profile_image' => Request()->form_key == 'media' ? (isset(Request()->profile_image) ? 'required|image|mimes:jpg,jpeg,png,bmp,tiff,webp,svg' : '') : '',
            'profile_cover' => Request()->form_key == 'media' ? (isset(Request()->profile_cover) ? 'required|image|mimes:jpg,jpeg,png,bmp,tiff,webp,svg' : '') : '',
            'password' => Request()->form_key == 'basic' ? (isset(Request()->password) ?  'required|min:6|max:12|confirmed' : '') : '',
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
