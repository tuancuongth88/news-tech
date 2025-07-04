<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        dd(getRainLevelDescription(0.4));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $request['message']
                ]
            ],
            'temperature' => 0,
            'max_tokens' => 2048,
        ]);
        return response()->json(json_decode($response));
    }
}
