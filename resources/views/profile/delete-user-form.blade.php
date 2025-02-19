<x-action-section>
    <x-slot name="title">
        {{ __('Smazat účet') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Trvale smažte svůj účet.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Jakmile bude váš účet smazán, všechna jeho data a zdroje budou trvale odstraněny. Před smazáním účtu si stáhněte všechna data, která si chcete ponechat.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Smazat účet') }}
            </x-danger-button>
        </div>

        <!-- Potvrzovací dialog pro smazání účtu -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Smazat účet') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Opravdu chcete smazat svůj účet? Jakmile bude váš účet smazán, všechna jeho data a zdroje budou trvale odstraněny. Pro potvrzení prosím zadejte své heslo.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                             autocomplete="current-password"
                             placeholder="{{ __('Heslo') }}"
                             x-ref="password"
                             wire:model="password"
                             wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Zrušit') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Smazat účet') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
