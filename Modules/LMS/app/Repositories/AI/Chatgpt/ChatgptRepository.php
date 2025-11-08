<?php

namespace Modules\LMS\Repositories\AI\Chatgpt;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Modules\LMS\Models\ServiceType;
use Illuminate\Support\Facades\Validator;

class ChatgptRepository
{
    protected  $client;
    protected  $apiKey;
    protected  $model = "gpt-4o-mini";

    public function __construct()
    {
        $setting =  get_theme_option('ai_setting') ?? [];
        $this->client = new Client(['base_uri' => 'https://api.openai.com/v1/']);
        $this->apiKey =   $setting['secret_key'] ?? '';
        $this->model =   $setting['ai_modal'] ?? '';
    }
    /**
     * Method generate
     *
     * @param Request $request
     *
     */
    public function generate(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors(),
            ];
        }
        $serviceType = ServiceType::where('id', $request->service_type_id)->first();
        $prompt = $request->keyword;
        $language = $request->language ?? 'english';
        $maxToken = $request->max_token ?? $serviceType->length ?? 100;
        $adjustedPrompt = "Respond in {$language}: {$prompt}";
        return $this->response(prompt: $adjustedPrompt, maxTokens: $maxToken);
    }
    /**
     * generateText
     *
     * @param string $prompt
     * @param int $maxTokens 
     *
     */
    public function response(string $prompt, int $maxTokens = 100)
    {
        try {
            $response = $this->client->post('chat/completions', [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => $maxTokens,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return [
                'status' => 'success',
                'data' => $data['choices'][0]['message']['content'] ?? 'No response generated.',
                'ai_type' => true
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' =>  translate('You exceeded your current quota, please check your plan and billing details and credential')
            ];
        }
    }
}
