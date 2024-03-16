<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function sendChatRequest(Request $request)
    {
        $userInput = $request->input('user_input');
        $apiKey = 'AIzaSyBeikCNyjgNjgoDpW0d_8ICM1dW2b2hjnw'; // Ganti dengan kunci API Anda dari Gemini

        $client = new Client();

        $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=AIzaSyBeikCNyjgNjgoDpW0d_8ICM1dW2b2hjnw', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json' => [
                'model' => 'gemini-1.0-pro',  // Ganti dengan nama model yang ingin Anda gunakan
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
