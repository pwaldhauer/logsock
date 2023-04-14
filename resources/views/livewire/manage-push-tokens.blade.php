<x-card class="p-4">
    <x-slot name="title">
        Manage Push Tokens
    </x-slot>

    @foreach(auth()->user()->pushTokens as $token)
        <li class="flex py-4">
            <div>
                <div>{{ $token->tokenNiceName }}</div>
            <div class="text-sm text-gray-500">Token created at {{ $token->created_at }}</div>
            </div>

            <x-pwablui::form.button
                class="ml-auto"
                type="secondary"
                size="small"
                wire:click.prevent="deleteToken({{ $token->id }})"
            >
                Remove token
            </x-pwablui::form.button>
        </li>
    @endforeach


    <x-pwablui::form.button
        x-data="webPush({publicKey: '{{ env('VAPID_PUBLIC_KEY') }}'})"
        x-on:click.prevent="subscribe()"
    >
        Subscribe for Notifications
    </x-pwablui::form.button>
</x-card>
