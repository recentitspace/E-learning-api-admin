<?php

namespace Modules\LMS\Repositories;

use Modules\LMS\Models\PaymentMethod;

class PaymentMethodRepository extends BaseRepository
{
    protected static $model = PaymentMethod::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token',  'image'],
        'update' => ['_token', '_method', 'image', 'key'],
    ];

    protected static $rules = [
        // 'save' => [
        //     'method_name' => 'required',
        //     // 'secret_key' => 'required',
        //     // 'publishable_key' => 'required',
        //     // 'image' => 'required|image|mimes:jpg,png,svg,webp',
        // ],
        // 'update' => [
        //     'method_name' => 'required',
        //     'secret_key' => 'required',
        //     'publishable_key' => 'required',
        // ],
    ];

    /**
     *  save
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        // Check if the request has an 'image' file
        if ($request->hasFile('image')) {
            // Upload the image and store the path in the specified folder
            $logo = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/payments');
            // Add the uploaded logo path to the request data
            $request->merge(['logo' => $logo]);
        }
        $request->merge([
            'keys' => $request->key[0]
        ]);
        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        // Check if the request has an 'image' file and upload if present
        if ($request->hasFile('image')) {
            $logo = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/payments');
            $request->merge(['logo' => $logo]);
        }

        $request->merge([
            'keys' => $request->key[0]
        ]);
        return parent::update($id, $request->all());
    }

    /**
     *  statusChange
     *
     * @param int int
     * @return array
     */
    public function statusChange($id)
    {
        // Retrieve the language record by ID
        $paymenthod = parent::first($id)['data'];

        // Toggle the status of the paymenthod
        $paymenthod->status = !$paymenthod->status;
        $paymenthod->update();

        // Return a success response
        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.')
        ];
    }
}
