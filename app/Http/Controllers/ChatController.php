<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OpenAIController extends Controller
{
    public function sendChatRequest(Request $request)
    {
        $userInput = $request->input('user_input');
        $apiKey = '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'; // Ganti dengan kunci API Anda

        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo-0613',  // Sesuaikan dengan model yang ingin Anda gunakan
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $userInput],
                ],
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return response()->json($data);
    }
}
