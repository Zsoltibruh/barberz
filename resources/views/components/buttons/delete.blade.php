@props(['text' => 'Delete', 'click'])

<flux:button variant="danger" wire:click="{{ $click }}">
    {{ __($text) }}
</flux:button>
