<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Castle {{ $version }}">
        <x-slot name="form">
            <x-castle::form.form action="{{ route('castle.email.generate') }}">
                <p class="text-base-content text-opacity-40">Type your email so can be verify</p>
                <div class="px-5 py-7">
                    <x-castle::form.email name="email" label="Your Email" />
                    <x-castle::form.submit name="Verify" />
                </div>
            </x-castle::form.form>
        </x-slot>

        <x-slot name="links">
            <div class="grid grid-cols-2 gap-1">
                <div class="text-center sm:text-center whitespace-nowrap">
                    {{--
                    <x-castle::form.link route="{{ route('forgot-password') }}" name="Forgot Password" /> --}}
                </div>
                <div class="text-center sm:text-center whitespace-nowrap">
                    {{--
                    <x-castle::form.link route="{{ route('register') }}" name="Register" /> --}}
                </div>
            </div>
        </x-slot>
    </x-castle::auth.authconteiner>

</x-castle::layout.login>
