<x-modals.template name="create" class="md:w-4xl" heading="Add new service"
    text="Add a new service that your barbers can offer">
    <form wire:submit="create" class="space-y-6">

        <flux:input wire:model="form.name" type="input" :label="__('Name')" />

        <flux:input wire:model="form.durationMinutes" type="number" :label="__('Duration (minutes)')" />

        <flux:input wire:model="form.price" type="number" :label="__('Price')" />
        <flux:input wire:model="form.currency" disabled variant="filled" :label="__('Currency')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>
    </form>
</x-modals.template>
