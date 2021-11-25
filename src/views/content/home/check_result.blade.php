<x-Castle::layout.login>
    <x-Castle::auth.authconteiner title="Check your code">
        <x-slot name="form">
            @if ($verification)
            <div class="alert col-span-1 xl:col-span-2 bg-base-100">
                <div class="flex-1"><label class="mx-3">Congratulations code is correct.</label></div>
                <div class="flex-none"> <a href="{{ route('castle.try') }}" class="btn btn-sm btn-primary">Try
                        Middlewhere</a></div>
            </div>
            @else
            <div class="alert col-span-1 xl:col-span-2 bg-base-100">
                <div class="flex-1"><label class="mx-3">Sorry but your code is wrong, try again</label></div>
                <x-Castle::form.form action="{{ route('castle.check') }}">
                    <div class="px-5 py-7">
                        <x-Castle::form.text name="code" label="Type the code here" />
                        <x-Castle::form.submit name="Check Code" />
                    </div>
                </x-Castle::form.form>
            </div>
            @endif
        </x-slot>

        <x-slot name="links">

        </x-slot>
    </x-Castle::auth.authconteiner>

</x-Castle::layout.login>
