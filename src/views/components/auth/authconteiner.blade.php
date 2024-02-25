<!-- component -->
{{-- <img class="mb-3 mx-auto" style="height: 150px;" src="https://www.fatcow.com/images/free-logos/World-Wide01.jpg"
    alt=""> --}}

<div class="flex items-center min-h-screen p-6 bg-base-200">
    <div
        class="
          flex-1
          max-w-7xl
          mx-auto
          overflow-hidden
          bg-base-300
          rounded-lg
          shadow-xl
        ">
        <div class="flex flex-col overflow-y-auto md:flex-row">
            <div class="h-50 md:h-auto md:w-1/2">
                {{-- Logo go here --}}
                <x-castle::core.logo full="true" />
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <div class="flex items-center justify-center flex-col">
                        <div>
                            <h1
                                class="
                        my-4 text-4xl font-bold card-title
                            ">
                                {{ $title ?? 'add a title' }}
                            </h1>
                        </div>
                        <div>
                            {{ $form }}
                        </div>
                        <div>
                            {{ $slot }}
                        </div>
                        <div class="justify-end space-x-2 card-actions">
                            {{ $links }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
