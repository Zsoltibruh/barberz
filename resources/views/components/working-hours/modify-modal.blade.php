@props(['workingHour'])
<x-modals.template name="modify-{{ $workingHour->id }}" class="md:w-96" heading="Modify working hour"
    text="Modifying your working hour will cancel every affected appointment and send an email to every customer">
    <form wire:submit="modify" class="space-y-6">
        <flux:heading size="lg">
            {{ __($workingHour->weekday) }}
        </flux:heading>

        <flux:input wire:model="form.start" type="time" format="H:i" :label="__('Start')" />
        <flux:input wire:model="form.end" type="time" format="H:i" :label="__('End')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>
    </form>
</x-modals.template>
