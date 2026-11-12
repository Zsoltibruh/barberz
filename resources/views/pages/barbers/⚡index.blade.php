<?php

use App\Enums\Role;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination, WithoutUrlPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $service = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function barbers()
    {
        return User::role(Role::Barber)
            ->with('barberServices')
            ->when($this->search, function ($query) {
                $ids = User::search($this->search)->keys();
                $query->whereIn('id', $ids);
            })
            ->when($this->service, function ($query) {
                $query->whereHas('barberServices', function ($query) {
                    $query->where('name', $this->service);
                });
            })
            ->orderBy('last_name', 'asc')
            ->paginate(config('app.pagination'));
    }

    #[Computed]
    public function services()
    {
        return Service::whereHas('barbers')->get();
    }
};
?>

<section class="flex flex-col gap-2">
    <div class="relative mb-6 w-full">
        <flux:heading level="1" size="2xl">
            {{ __('Barbers') }}
        </flux:heading>
        <flux:separator variant="subtle" />
    </div>

    <x:search target="barbers">
        <flux:select wire:model.live="service" :placeholder="__('Choose service...')">
            <flux:select.option value="">{{ __('Any service') }}</flux:select.option>
            @foreach ($this->services as $service)
                <flux:select.option> {{ $service->name }} </flux:select.option>
            @endforeach
        </flux:select>
    </x:search>

    <div class="w-full flex flex-wrap gap-4">
        @foreach ($this->barbers as $barber)
            <x:barber-summary :barber="$barber" />
        @endforeach
    </div>

    {{ $this->barbers->links() }}
</section>
