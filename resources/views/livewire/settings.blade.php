<div>
    <x-form wire:submit="save">
        <x-input label="Select the lockfile in the lol directory." wire:model="lockFilePath" readonly>
            <x-slot:append>
                <x-button wire:click="selectLockFilePath" label="Select lockfile" icon="o-folder-open" class="btn-primary rounded-s-none" />
            </x-slot:append>
        </x-input>

        <x-slot:actions>
            <x-button label="Cancel" class="btn-error" wire:click="close"/>
            <x-button label="Save" class="btn-success" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>