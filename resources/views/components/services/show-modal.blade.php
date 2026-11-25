@props(['service'])

<x-modals.template name="show-{{ $service->id }}" class="md:w-4xl" :heading="$service->name"
    text="A list of every barber that offers this service">

    <x-offering-table :rows="$service->barbers->map(
        fn($barber) => [
            'name' => $barber->name,
            'duration' => $service->duration_minutes,
            'price' => $service->price,
            'currency' => $service->currency,
        ],
    )" />

    <x-modals.footer />
</x-modals.template>
