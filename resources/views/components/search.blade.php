@props(['target'])

<div class="flex flex-col gap-2">
    <flux:input wire:model.live.blur="search" type="search" icon="magnifying-glass"
        :placeholder="__('Search '.$target.
            '...')" clearable />
    {{ $slot }}
</div>

<flux:separator />
