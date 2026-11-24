@props(['heading', 'subheading'])

<div class="relative mb-6 w-full">
    <flux:heading level="1" size="2xl">
        {{ __($heading) }}
    </flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __($subheading) }}
    </flux:subheading>
    <flux:separator variant="subtle" />
</div>
