@props(['rows'])

<flux:table>
    <flux:table.columns>
        <flux:table.column> {{ __('Name') }} </flux:table.column>
        <flux:table.column> {{ __('Duration') }} </flux:table.column>
        <flux:table.column> {{ __('Price') }} </flux:table.column>
        <flux:table.column> {{ __('Currency') }} </flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @forelse ($rows as $row)
            <flux:table.row>
                <flux:table.cell> {{ $row['name'] }} </flux:table.cell>
                <flux:table.cell> {{ $row['duration'] }} m </flux:table.cell>
                <flux:table.cell variant="strong"> {{ $row['price'] }} </flux:table.cell>
                <flux:table.cell> {{ $row['currency'] }} </flux:table.cell>
            </flux:table.row>
        @empty
            <flux:table.row>
                <flux:table.cell colspan="4">{{ __('Nothing to show yet.') }}</flux:table.cell>
            </flux:table.row>
        @endforelse
    </flux:table.rows>
</flux:table>
