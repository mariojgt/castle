<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Email Code">
        <x-slot name="form">
            @if ($response)
            <div class="alert col-span-1 xl:col-span-2 bg-base-100">
                <div class="flex-1"><label class="mx-3">Congratulations code is correct.</label></div>
                <div class="flex-none">

                    <label for="my-modal-2" class="btn btn-sm btn-primary modal-button">Try middleware</label>
                    <input type="checkbox" id="my-modal-2" class="modal-toggle">
                    <div class="modal">
                        <div class="modal-box">
                            <p>{{ $message }}</p>
                            <div class="modal-action">
                                <a href="{{ route('castle.try') }}" class="btn btn-primary">Try middleware</a>
                                <label for="my-modal-2" class="btn">Close</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert col-span-1 xl:col-span-2 bg-base-100">
                <div class="flex-1"><label class="mx-3">{{ $message }}</label></div>
                <x-castle::form.form action="{{ route('castle.check') }}">
                    <div class="px-5 py-7">
                        <x-castle::form.text name="code" label="Type the code here" />
                        <x-castle::form.submit name="Check Code" />
                    </div>
                </x-castle::form.form>
            </div>
            @endif
        </x-slot>

        <x-slot name="links">

        </x-slot>
    </x-castle::auth.authconteiner>

</x-castle::layout.login>
