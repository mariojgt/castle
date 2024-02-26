<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Check your code" >
        <x-slot name="logo">
            <div class="flex items-center justify-center p-6 w-full bg-base-200">
                {!! $generatedCode['qr_code'] !!}
            </div>
            <p class="font-bold text-center text-lg bg-info text-neutral">Scan this code using a authenticator </p>
        </x-slot>
        <x-slot name="form">
            <div class="flex flex-col gap-2 text-center bg-base-100 rounded-lg p-5 mb-2">
                <h2 class="text-xl">You Autenticaton QRCode</h2>
                <p class="font-bold">If you can't use QRCode you can use the screct <strong class="text-primary" >{{ $generatedCode['secret'] }}</strong>
                </p>
                <strong>This Code will show only once.</strong>
            </div>
            <x-castle::form.form action="{{ route('castle.check') }}">
                <div class="p-2">
                    <x-castle::form.text name="code" label="Type the code here" />
                    <x-castle::form.submit name="Check Code" />
                </div>
            </x-castle::form.form>
            <p class="text-base-content font-bold text-center">Read more about
                <a class="btn btn-sm btn-primary" href="https://www.google.com/search?q=2fas" target="_blank" >2FAS</a>
            Aplication</p>
        </x-slot>

    </x-castle::auth.authconteiner>

</x-castle::layout.login>
