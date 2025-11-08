<?php

namespace Modules\LMS\Http\Controllers\Openai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\AI\Chatgpt\ChatgptRepository;

class OpenaiController extends Controller
{
    public function __construct(protected ChatgptRepository $chatgpt) {}


    public function generate(Request $request)
    {
        $response = $this->chatgpt->generate($request);
        return response()->json($response);
    }
}
