<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Check your code">
        <x-slot name="form">
            <p class="text-base-content text-opacity-40">Enter the code that you have recived.</p>
            <x-castle::form.form action="{{ route('castle.email.check') }}">
                <div class="px-5 py-7">
                    <x-castle::form.text name="code" label="Type the code here" />
                    <x-castle::form.submit name="Check Code" />
                </div>
            </x-castle::form.form>
        </x-slot>

        <x-slot name="links">
            <div class="card row-span-3 shadow-lg compact bg-base-100 p-3">
                <div class="flex-row items-center space-x-4 card-body">
                    <div>
                        <h2 class="card-title">Email Code Vefirication</h2>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-castle::auth.authconteiner>

</x-castle::layout.login>
