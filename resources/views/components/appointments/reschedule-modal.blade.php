@props(['id'])

<x-modals.template name="reschedule-{{ $id }}" class="md:w-4xl" heading="Modify appointment"
    text="After modifying you will be sent an email">
    <form wire:submit="reschedule" class="space-y-6">
        <flux:heading size="lg">{{ __('Modify appointment') }}</flux:heading>

        <flux:input wire:model="form.date" type="date" :min="now()->format('Y-m-d')" :label="__('Date')" />
        <flux:input wire:model="form.time" type="time" step="900" :label="__('Time')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>
    </form>
</x-modals.template>
