<x-Castle::layout.login>
    <x-Castle::auth.authconteiner title="Check your code">
        <x-slot name="form">
            <p class="text-base-content text-opacity-40">Scan this code using goole autenticator </p>
            <p class="text-base-content text-opacity-40">Or other
                <a class="btn btn-sm" href="https://www.google.com/search?q=2fas+mobile+app&client=firefox-b-d&sxsrf=AOaemvKOgnEfJCJurkfJVcCGYIMkmZ2Z-Q%3A1638969663722&ei=P7GwYdu7K7PB8gKXr5WYBA&oq=2FAS+mobil&gs_lcp=Cgdnd3Mtd2l6EAMYATIFCCEQoAEyBQghEKABOgcIIxCwAxAnOgcIABBHELADOgQIIxAnOgQIABBDOgUIABCABDoGCAAQFhAeOggIABAWEAoQHkoECEEYAFClBFjMF2D7IGgCcAJ4AIABhwGIAYUFkgEDNi4xmAEAoAEByAEKwAEB&sclient=gws-wiz&shem=ssmd" target="_blank" >2FAS</a>
            Aplication</p>
            <x-Castle::form.form action="{{ route('castle.check') }}">
                <div class="px-5 py-7">
                    <x-Castle::form.text name="code" label="Type the code here" />
                    <x-Castle::form.submit name="Check Code" />
                </div>
            </x-Castle::form.form>
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
    </x-Castle::auth.authconteiner>

</x-Castle::layout.login>
