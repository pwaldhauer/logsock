<?php

namespace App\Http\Livewire;

use App\Models\PushToken;
use Livewire\Component;

class ManagePushTokens extends Component
{
    public function saveSubscription($params)
    {
        PushToken::create([
            ...$params,
            'user_id' => auth()->user()->id,
        ]);
    }

    public function deleteToken($id)
    {
        $token = auth()->user()->pushTokens()->findOrFail($id);
        $token->delete();
    }

    public function render()
    {
        return view('livewire.manage-push-tokens');
    }
}
