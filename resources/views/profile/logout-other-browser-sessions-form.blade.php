<x-action-section>
    <x-slot name="title">
        {{ __('Relace prohlížeče') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Spravujte a odhlašte své aktivní relace na jiných prohlížečích a zařízeních.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Pokud je to nutné, můžete se odhlásit ze všech ostatních relací prohlížeče na všech svých zařízeních. Některé z vašich posledních relací jsou uvedeny níže, ale tento seznam nemusí být úplný. Pokud máte pocit, že byl váš účet ohrožen, měli byste si také změnit heslo.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                <!-- Ostatní relace prohlížeče -->
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="ms-3">
                            <div class="text-sm text-gray-600">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Neznámé') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Neznámé') }}
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('Toto zařízení') }}</span>
                                    @else
                                        {{ __('Poslední aktivita') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-5">
            <x-button wire:click="confirmLogout" wire:loading.attr="disabled">
                {{ __('Odhlásit ostatní relace prohlížeče') }}
            </x-button>

            <x-action-message class="ms-3" on="loggedOut">
                {{ __('Hotovo.') }}
            </x-action-message>
        </div>

        <!-- Potvrzení odhlášení z ostatních zařízení -->
        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                {{ __('Odhlásit ostatní relace prohlížeče') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Pro potvrzení, že se chcete odhlásit ze všech ostatních relací prohlížeče na všech svých zařízeních, zadejte své heslo.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                             autocomplete="current-password"
                             placeholder="{{ __('Heslo') }}"
                             x-ref="password"
                             wire:model="password"
                             wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                    {{ __('Zrušit') }}
                </x-secondary-button>

                <x-button class="ms-3"
                          wire:click="logoutOtherBrowserSessions"
                          wire:loading.attr="disabled">
                    {{ __('Odhlásit ostatní relace prohlížeče') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
