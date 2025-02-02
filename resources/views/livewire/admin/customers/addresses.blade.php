<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Address;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

new 
#[Title('Addresses')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, WithPagination;

    public int $perPage = 10;
    public string $search = '';

    public array $sortBy = [
        'column' => 'name',
        'direction' => 'asc',
    ];

    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => __('Name')], 
            ['key' => 'firstname', 'label' => __('Firstname')],            
            ['key' => 'company', 'label' => __('Company name')],
            ['key' => 'address', 'label' => __('Address')],
            ['key' => 'postal', 'label' => __('Postcode')],
            ['key' => 'city', 'label' => __('City')],
            ['key' => 'country', 'label' => __('Country')],
        ];
    }

    public function with(): array
    {
        return [
            'addresses' => Address::with('country')
                ->when($this->sortBy['column'] === 'country', function (Builder $query) {
                    $query->join('countries', 'addresses.country_id', '=', 'countries.id')
                        ->orderBy('countries.name', $this->sortBy['direction']);
                }, function (Builder $query) {
                    $query->orderBy($this->sortBy['column'], $this->sortBy['direction']);
                })
                ->when($this->search, function (Builder $query) {
                    $query->where('addresses.name', 'like', "%{$this->search}%")
                        ->orWhere('company', 'like', "%{$this->search}%")
                        ->orWhere('address', 'like', "%{$this->search}%")
                        ->orWhere('city', 'like', "%{$this->search}%");
                })
                ->paginate($this->perPage),
            'headers' => $this->headers(),
        ];
    }
   
}; ?>

<div>
    <x-header title="{{ __('Addresses') }}" separator progress-indicator >
        <x-slot:actions>
            <x-input 
                placeholder="{{ __('Search...') }}" 
                wire:model.live.debounce="search" 
                clearable
                icon="o-magnifying-glass" 
            />
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table 
            striped 
            :headers="$headers" 
            :rows="$addresses" 
            :sort-by="$sortBy" 
            per-page="perPage"
            with-pagination
        >
            @scope('cell_country', $address)
                {{ $address->country->name }}
            @endscope
        </x-table>
    </x-card>
</div>
