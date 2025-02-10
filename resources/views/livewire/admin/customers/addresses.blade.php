<?php

use Mary\Traits\Toast;
use App\Models\Address;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Database\Eloquent\Builder;

new #[Layout('components.layouts.admin')]
class extends Component {
    use Toast, WithPagination;

    public int $perPage = 10;
    public string $search = '';

    public array $sortBy = [
        'column' => 'name',
        'direction' => 'asc',
    ];

    public function headers(): array
    {
        return [['key' => 'name', 'label' => __('Name')], ['key' => 'firstname', 'label' => __('Firstname')], ['key' => 'company', 'label' => __('Company name')], ['key' => 'address', 'label' => __('Address')], ['key' => 'postal', 'label' => __('Postcode')], ['key' => 'city', 'label' => __('City')], ['key' => 'country', 'label' => __('Country')]];
    }

    public function with(): array
    {
        return [
            'addresses' => Address::with('country')
                ->when(
                    $this->sortBy['column'] === 'country',
                    function (Builder $query) {
                        $query->join('countries as country_sort', 'addresses.country_id', '=', 'country_sort.id')->orderBy('country_sort.name', $this->sortBy['direction']);
                    },
                    function (Builder $query) {
                        $query->orderBy($this->sortBy['column'], $this->sortBy['direction']);
                    },
                )
                ->when($this->search, function (Builder $query) {
                    $query
                        ->join('countries as country_search', 'addresses.country_id', '=', 'country_search.id') // Joignez la table countries
                        ->where(function ($query) {
                            $query
                                ->where('addresses.company', 'like', "%{$this->search}%")
                                ->orWhere('addresses.name', 'like', "%{$this->search}%")
                                ->orWhere('addresses.firstname', 'like', "%{$this->search}%")
                                ->orWhere('addresses.address', 'like', "%{$this->search}%")
                                ->orWhere('addresses.addressbis', 'like', "%{$this->search}%")
                                ->orWhere('addresses.postal', 'like', "%{$this->search}%")
                                ->orWhereIn('addresses.postal', [$this->search])
                                ->orWhere('addresses.city', 'like', "%{$this->search}%")
                                ->orWhere('country_search.name', 'like', "%{$this->search}%");
                        });
                })
                ->paginate($this->perPage),
            'headers' => $this->headers(),
        ];
    }
}; ?>

@section('title', __('Addresses'))
<div>
    <x-header title="{{ __('Addresses') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$addresses" :sort-by="$sortBy" per-page="perPage" with-pagination>
            @scope('cell_country', $address)
                {{ $address->country->name }}
            @endscope
        </x-table>
    </x-card>
</div>
