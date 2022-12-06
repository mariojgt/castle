<x-castle::layout.login>
    <x-castle::auth.authconteiner title="authenticator Autentication Required">
        <x-slot name="form">
            <x-castle::form.form action="{{ route('castle.validate') }}">
                <div class="px-5 py-7">
                    <x-castle::form.text name="code" label="Type you code" />
                    <x-castle::form.submit name="Autenticate" />
                </div>
            </x-castle::form.form>



            <label for="my-modal-2" class="btn btn-block btn-primary modal-button">Backup Code</label>
            <input type="checkbox" id="my-modal-2" class="modal-toggle">
            <div class="modal">
                <div class="modal-box">
                    <p>If You have lost your authenticator please type you backup code in here, if the code is
                        successfully 2 step verification will be disable</p>
                    <x-castle::form.form action="{{ route('castle.unlock.backup.code') }}">
                        <div class="px-5 py-7">
                            <x-castle::form.text name="code" label="Type you bakup code" />
                            <x-castle::form.submit name="Unlock" />
                        </div>
                    </x-castle::form.form>

                    <div class="modal-action">
                        <label for="my-modal-2" class="btn">Close</label>
                    </div>
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
