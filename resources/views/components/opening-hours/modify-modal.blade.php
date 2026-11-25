@props(['openingHour'])

<x-modals.template name="modify-{{ $openingHour->id }}" class="md:w-96" :heading="$openingHour->weekday"
    text="Changing and opening hour will affect every barber and will delete the affected working hours">
    <form wire:submit="modify" class="space-y-6">
        <flux:heading size="lg">
            {{ __($openingHour->weekday) }}
        </flux:heading>

        <flux:input wire:model="form.opening" type="time" :label="__('Opening')" />

        <flux:input wire:model="form.closing" type="time" :label="__('Closing')" />

        <flux:switch wire:model="form.closed" type="bool" :label="__('Closed')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>
    </form>
</x-modals.template>
