<div class="px-4 sm:w-8/12 mx-auto py-4">
    <div class="flex items-center justify-between">
        <a href="{{route('home') }}"
           class="no-underline text-black flex gap-4 items-center "
        >
            <img src="/img/cat-small.png" class="block w-12  sm:w-12 aspect-square"/>
            <h1 class="font-light text-xl">{{ config('app.name') }}</h1>
        </a>


        <a href="{{ route('user.profile') }}">
            <x-heroicon-m-cog-6-tooth class="w-6 h-6"/>
        </a>
    </div>
</div>
