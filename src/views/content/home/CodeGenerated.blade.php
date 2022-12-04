<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Check your code">
        <x-slot name="form">
            <p class="text-base-content text-opacity-40">Scan this code using goole authenticator </p>
            <p class="text-base-content text-opacity-40">Or other
                <a class="btn btn-sm" href="https://www.google.com/search?q=2fas" target="_blank" >2FAS</a>
            Aplication</p>
            <x-castle::form.form action="{{ route('castle.check') }}">
                <div class="px-5 py-7">
                    <x-castle::form.text name="code" label="Type the code here" />
                    <x-castle::form.submit name="Check Code" />
                </div>
            </x-castle::form.form>
        </x-slot>

        <x-slot name="links">
            <div class="card row-span-3 shadow-lg compact bg-base-100 p-3">
                <figure>{!! $generatedCode['qr_code'] !!}</figure>
                <div class="flex-row items-center space-x-4 card-body">
                    <div>
                        <h2 class="card-title">You Autenticaton QRCode</h2>
                        <p class="text-base-content text-opacity-40">If you can't use QRCode you can use the screct <strong>{{ $generatedCode['secret'] }}</strong>
                        </p>
                        <strong>This Code will show only one time.</strong>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-castle::auth.authconteiner>

</x-castle::layout.login>
