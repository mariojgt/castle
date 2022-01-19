<x-Castle::layout.login>
    <x-Castle::auth.authconteiner title="Castle {{ $version }}">
        <x-slot name="form">
            <x-Castle::form.form action="{{ route('castle.email.generate') }}">
                <p class="text-base-content text-opacity-40">Type your email so can be verify</p>
                <div class="px-5 py-7">
                    <x-Castle::form.email name="email" label="Your Email" />
                    <x-Castle::form.submit name="Verify" />
                </div>
            </x-Castle::form.form>
        </x-slot>

        <x-slot name="links">
            <div class="grid grid-cols-2 gap-1">
                <div class="text-center sm:text-center whitespace-nowrap">
                    {{--
                    <x-Castle::form.link route="{{ route('forgot-password') }}" name="Forgot Password" /> --}}
                </div>
                <div class="text-center sm:text-center whitespace-nowrap">
                    {{--
                    <x-Castle::form.link route="{{ route('register') }}" name="Register" /> --}}
                </div>
            </div>
        </x-slot>
    </x-Castle::auth.authconteiner>

</x-Castle::layout.login>
