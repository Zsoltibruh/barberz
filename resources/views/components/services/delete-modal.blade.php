@props(['service'])

<x-modals.confirm name="delete-{{ $service->id }}" class="md:w-4xl" heading="Delete service"
    text="Deleting this service will remove it from every barber that offers it" click="delete">
    <flux:card>
        <flux:card.body>
            <flux:heading>
                {{ $service->name }}
            </flux:heading>
            <flux:subheading>
                {{ __('Barbers that offer this service') }}
            </flux:subheading>
            <x-offering-table :rows="$service->barbers->map(
                fn($barber) => [
                    'name' => $barber->name,
                    'duration' => $service->duration_minutes,
                    'price' => $service->price,
                    'currency' => $service->currency,
                ],
            )" />
        </flux:card.body>
    </flux:card>
</x-modals.confirm>
