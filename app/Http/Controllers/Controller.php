<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Return a JSON success response.
     *
     * @param string $message
     * @param string $url
     * @return JsonResponse
     */
    public function jsonSuccess(string $message, string $url): JsonResponse
    {
        toastr()->success(translate($message));
        return response()->json(['status' => 'success', 'url' => $url]);
    }
}
