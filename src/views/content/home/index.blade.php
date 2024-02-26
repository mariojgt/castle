<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Castle {{ $version }}">
        <x-slot name="form">
            <x-castle::form.form action="{{ route('castle.generate') }}">
                <p class="text-base-content font-bold">Generate Code, Please enter your email</p>
                <div class="mt-2">
                    <x-castle::form.text name="email" label="Your Email" type="email" required="true" />
                    <x-castle::form.submit name="Generate Code" />
                </div>
            </x-castle::form.form>
        </x-slot>
    </x-castle::auth.authconteiner>

</x-castle::layout.login>
