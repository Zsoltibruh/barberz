@props(['barber'])

<x-modals.template name="services-{{ $barber->id }}" class="md:w-4xl" heading="Services"
    text="A list of every service this barber offers">
    <x-offering-table :rows="$barber->barberServices->map(
        fn($service) => [
            'name' => $service->name,
            'duration' => $service->duration_minutes,
            'price' => $service->price,
            'currency' => $service->currency,
        ],
    )" />
    <x-modals.footer />
</x-modals.template>
