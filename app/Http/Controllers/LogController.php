<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class LogController extends Controller
{
    public function store(Request $request)
    {
        $level = $request->get('level') ?? 3;
        $topic = $request->get('topic') ?? 'no topic given';
        $message = $request->get('message') ?? '';

        $payload = $request->all();

        // Special handling for uptime kuma
        if (isset($payload['heartbeat'])) {
            $topic = 'UptimeKuma';
            $message = $payload['msg'];
            $payload = ['message' => $message];
        }

        Log::create([
            'user_id' => auth()->user()->id,
            'level' => $level,
            'topic' => $topic,
            'payload' => Arr::except($payload, ['topic', 'level']),
        ]);

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => env('VAPID_SUBJECT'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ]);

        if (filled(auth()->user()->pushTokens)) {
            foreach (auth()->user()->pushTokens as $token) {
                $webPush->sendOneNotification(
                    Subscription::create([
                        'endpoint' => $token->endpoint,
                        'publicKey' => $token->key,
                        'authToken' => $token->auth,
                    ]),
                    json_encode([
                        'title' => $topic,
                        'body' => $message,
                    ])
                );
            }
        }
    }

    public function index()
    {
        return view('log.index', [
            'logs' => Log::query()->orderBy('created_at', 'desc')->paginate(50),
        ]);
    }
}
