@props(['barber'])

<flux:card body="inset" size="lg" class="min-w-md">
    <flux:card.body>
        <flux:card.bleed>
            <img src="/img/forest.png" :alt="__('Photo of {{ $barber->name }}')" class="block w-full object-cover">
        </flux:card.bleed>
    </flux:card.body>
    <flux:card.footer>
        <flux:card.heading level="3" size="lg">{{ $barber->name }}</flux:card.heading>
        <flux:card.subheading> {{ $barber->status->label() }} </flux:card.subheading>
        <flux:card.subheading> {{ __('Services') }}: haircuts, beard trimming </flux:card.subheading>
        <flux:card.actions>
            <flux:button variant="primary" color="blue" :href="route('appointments.create', ['barber' => $barber])"
                wire:navigate>
                {{ __('Book appointment') }}
            </flux:button>
        </flux:card.actions>
    </flux:card.footer>
</flux:card>
