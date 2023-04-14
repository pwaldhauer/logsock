<x-pwablui::layout>
    <div class="bg-white rounded-lg">
        @foreach($logs as $log)

            <div class="flex  flex-wrap px-4 py-3 items-center odd:bg-gray-50">

                <div class="w-6/12 mb-2 sm:mb-0 sm:w-20 order-1">
                    <x-pwablui::pill>
                        {{$log->levelLabel() }}
                    </x-pwablui::pill>
                </div>

                <div class="ml-auto text-sm text-gray-400 order-2 sm:order-3">
                    @if($log->created_at->diff(now())->days < 1)
                        {{$log->created_at->diffForHumans() }}
                    @else
                        {{$log->created_at->format('d.m.Y H:i:s') }}
                    @endif
                </div>

                <div class="w-full sm:w-auto order-3 sm:order-2">
                    <div class="font-bold">
                        {{$log->topic }}
                    </div>
                    @if(!empty($log->payload['message']))
                        <div class="text-sm text-gray-500">
                            {{$log->payload['message'] }}
                        </div>
                    @endif

                </div>

            </div>

        @endforeach
    </div>

</x-pwablui::layout>
