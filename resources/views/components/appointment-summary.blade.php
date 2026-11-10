@props(['appointment'])

<flux:card>
    <flux:heading size="lg"> {{ $appointment->date }} </flux:heading>

    <flux:card.body>
        <flux:card.heading> {{ $appointment->barber->name }} </flux:card.heading>
        <flux:card.subheading>
            {{ $appointment->service->name }} - {{ $appointment->service->price }} Ft
        </flux:card.subheading>
        <flux:card.subheading>
            {{ $appointment->status->label() }}
        </flux:card.subheading>
    </flux:card.body>

    {{ $slot }}
</flux:card>
