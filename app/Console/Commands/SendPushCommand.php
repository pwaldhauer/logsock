<?php

namespace App\Console\Commands;

use App\Models\PushToken;
use Illuminate\Console\Command;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class SendPushCommand extends Command
{
    protected $signature = 'send:push';

    protected $description = 'Send a test notification to every registered push token.';

    public function handle(): void
    {

        $auth = [
            'VAPID' => [
                'subject' => env('VAPID_SUBJECT'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        foreach (PushToken::all() as $token) {
            $report = $webPush->sendOneNotification(
                Subscription::create([
                    'endpoint' => $token->endpoint,
                    'publicKey' => $token->key,
                    'authToken' => $token->auth,
                ]),
                json_encode([
                    'title' => 'Hello Logsock',
                    'body' => 'Wichtiger Body!',
                ])
            );

            var_dump($report);
        }

    }
}
