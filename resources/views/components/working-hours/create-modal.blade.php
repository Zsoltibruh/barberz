<x-modals.template name="create" class="md:w-4xl" heading="Add new working hour"
    text="You can only add one working hour for each day">
    <form wire:submit="create" class="space-y-6">
        <flux:heading size="lg">
            {{ __('Add new working hour') }}
        </flux:heading>

        <flux:select wire:model="form.weekday" :placeholder="__('Weekday')">
            <flux:select.option value="monday"> {{ __('monday') }} </flux:select.option>
            <flux:select.option value="tuesday"> {{ __('tuesday') }} </flux:select.option>
            <flux:select.option value="wednesday"> {{ __('wednesday') }} </flux:select.option>
            <flux:select.option value="thursday"> {{ __('thursday') }} </flux:select.option>
            <flux:select.option value="friday"> {{ __('friday') }} </flux:select.option>
        </flux:select>

        <flux:input wire:model="form.start" type="time" :label="__('Start')" />
        <flux:input wire:model="form.end" type="time" :label="__('End')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>
    </form>
</x-modals.template>
