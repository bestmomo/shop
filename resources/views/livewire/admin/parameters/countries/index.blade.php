<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\{ Country, Range };
use Mary\Traits\Toast;
use Livewire\WithPagination;

new 
#[Title('Countries')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, WithPagination;
    
    public string $name;
    public string $tax;
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function headers(): array
	{
		return [['key' => 'name', 'label' => __('Name')], ['key' => 'tax', 'label' => __('VAT')]];
	}

    public function save(): void
    {
        $data = $this->validate([
            'name' => 'required|string|max:100|unique:countries,name',
            'tax' => 'required|numeric|between:0,0.4',
        ]);

        $country = Country::create($data);

        $ranges = Range::all();
        foreach($ranges as $range) {
            $range->countries()->attach($country, ['price' => 0]);
        }

        $this->success(__('Country created successfully.'));
    }

    public function deleteCountry(Country $country): void
    {
        $country->delete(); 
        $this->success(__('Country deleted successfully.'));
    }

    public function with(): array
	{
		return [
			'countries' => Country::orderBy(...array_values($this->sortBy))->paginate(10),
			'headers' => $this->headers(),
		];
	}
    
}; ?>

<div>
    <x-header title="{{ __('Countries') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-table striped :headers="$headers" :rows="$countries" :sort-by="$sortBy" link="/admin/countries/{id}/edit" with-pagination >
            @scope('actions', $country)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deleteCountry({{ $country->id }})"
                            wire:confirm="{{ __('Are you sure to delete this country?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
    <x-card title="{!! __('Create a new country') !!}">
        @include('livewire.admin.parameters.countries.form')
    </x-card>
</div>
