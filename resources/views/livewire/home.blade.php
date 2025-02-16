<div>
    <x-menu class="border border-dashed">
        @if ($leagueConnected)
            <x-avatar :image="$summonerIconUrl" placeholder="Unknown" class="!w-24">
                <x-slot:title class="text-3xl pl-2">
                    {{ $summonerName ?? "-" }}
                </x-slot:title>

                <x-slot:subtitle class="text-gray-500 flex flex-col gap-1 mt-2 pl-2">
                    <x-icon name="c-bolt" :label="$playerStatus" />
                    {{-- <x-icon name="o-chat-bubble-left" label="45 comments" /> --}}
                </x-slot:subtitle>
            </x-avatar>
        @else
            <x-alert title="Disconnected" description="Make sure League of Legends is open and adjust the directory in settings if necessary." icon="o-exclamation-triangle" class="alert-error">
                <x-slot:actions>
                    <x-button icon-right="m-arrow-path" class="btn-success btn-sm" wire:click="reconnect" spinner />
                </x-slot:actions>
            </x-alert>
        @endif
        <x-menu-separator />
        <x-menu-item title="Settings" icon="s-cog-8-tooth" wire:click="open('settings')" />
        <x-menu-item title="Quit" icon="s-power" wire:click="quit('settings')" />
    </x-menu>
</div>