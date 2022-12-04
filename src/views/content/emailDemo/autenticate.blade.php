<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Autenticate">
        <x-slot name="form">
            <div class="card shadow-lg compact side bg-base-100">
                <div class="flex-row items-center space-x-4 card-body">
                    <div class="flex-1">
                        <h2 class="card-title">Congratulations</h2>
                        <p class="text-base-content text-opacity-40">At this point you are already autenticate</p>
                        <p class="text-base-content text-opacity-40">More information please check out the docs</p>
                    </div>
                    <div class="flex-0"><button class="btn btn-sm">Docs</button></div>
                    <div class="flex-0"><a href="{{ route('castle.logout') }}" class="btn btn-sm">Logout</a></div>
                </div>
            </div>
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
