<x-modals.template name="create" class="md:w-4xl" heading="Hire new barber"
    text="Hire a new barber to your barbershop. A randomly generated password will be sent to their email">
    <form wire:submit="create" class="space-y-6">
        <flux:heading size="lg">
            {{ __('Hire new barber') }}
        </flux:heading>

        <flux:input wire:model="form.firstName" :label="__('First name')" />
        <flux:input wire:model="form.lastName" :label="__('Last name')" />

        <flux:input wire:model="form.email" type="email" :label="__('Email')" />
        <flux:input wire:model="form.phone" :label="__('Phone')" />

        <x-modals.footer>
            <x-buttons.save />
        </x-modals.footer>
    </form>
</x-modals.template>
