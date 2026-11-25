@props(['heading', 'text'])

<div>
    <flux:heading size="lg"> {{ __($heading) }} </flux:heading>
    <flux:text class="mt-2">
        {{ __($text) }}
    </flux:text>
</div>
