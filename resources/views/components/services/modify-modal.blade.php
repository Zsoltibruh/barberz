@props(['service'])

<x-modals.template name="modify-{{ $service->id }}" class="md:w-96" heading="Modify service"
    text="Each barber that offers this service will have only the service's name change, everything else is configured by them, except if they chose the default values.">
    <form wire:submit="modify" class="space-y-6">

        <flux:input wire:model="form.name" type="input" :label="__('Name')" />

        <flux:input wire:model="form.durationMinutes" type="number" :label="__('Duration (minutes)')" />

        <flux:input wire:model="form.price" type="number" :label="__('Price')" />
        <flux:input wire:model="form.currency" disabled variant="filled" :label="__('Currency')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>

    </form>
</x-modals.template>
