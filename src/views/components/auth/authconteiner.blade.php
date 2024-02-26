<div class="flex items-center min-h-screen p-6 aniamted-bg">
    <div
        class="
          flex-1
          max-w-7xl
          mx-auto
          overflow-hidden
          bg-base-300
          rounded-lg
          shadow-xl
          glass-border
        ">
        <div class="flex flex-col overflow-y-auto md:flex-row">
            <div class="h-50 md:h-auto md:w-1/2">
                @if(empty($logo))
                    <x-castle::core.logo full="true" />
                @else
                    {!! $logo !!}
                @endif
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <div class="flex flex-col">
                        <div>
                            <h1 class="my-4 text-4xl font-bold card-title">
                                {{ $title ?? 'add a title' }}
                            </h1>
                        </div>
                        <div>
                            {{ $form }}
                        </div>
                        <div>
                            {{ $slot }}
                        </div>
                        @if (!empty($links))
                            <div class="justify-end space-x-2 card-actions">
                                {{ $links }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
