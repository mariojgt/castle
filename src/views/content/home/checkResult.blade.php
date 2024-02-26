<x-castle::layout.login>
    <x-castle::auth.authconteiner title="Check your code">
        <x-slot name="form">
            @if ($verification)
                <div class="alert col-span-1 xl:col-span-2 bg-success">
                    <div class="flex-1 text-black font-bold"><label class="mx-3">Congratulations code is correct.</label></div>
                    <div class="flex-none">
                        <label for="my-modal-2" class="btn btn-sm btn-info modal-button">Try middleware</label>
                        <input type="checkbox" id="my-modal-2" class="modal-toggle">
                        <div class="modal">
                            <div class="modal-box">
                                <p>In Order to proper test the middleware you need to have the user login using the
                                    normal auth middleware, you can also change the guards in the castle.php config
                                    file.</p>
                                <div class="modal-action">
                                    <a href="{{ route('castle.try') }}" class="btn btn-primary">Try middleware</a>
                                    <label for="my-modal-2" class="btn">Close</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div role="alert" class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Sorry but your code is wrong, try again</span>
                </div>
                <x-castle::form.form action="{{ route('castle.check') }}">
                    <x-castle::form.text name="code" requied="true" label="Type the code here" required="true" />
                    <x-castle::form.submit name="Check Code" />
                </x-castle::form.form>
            @endif
        </x-slot>
    </x-castle::auth.authconteiner>

</x-castle::layout.login>
