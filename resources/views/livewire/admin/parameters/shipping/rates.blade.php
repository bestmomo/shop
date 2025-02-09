<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\{ Country, Range, Colissimo };
use Mary\Traits\Toast;
use Illuminate\Support\Collection;

new #[Title('Rates')] #[Layout('components.layouts.admin')] class extends Component
{
    use Toast;
    public array $countries;

    public function mount(): void
    {
        $this->countries = Country::with('ranges')->get()->toArray();
    }

    public function save(): void
    {
        // Validation
        $rules = [];
        foreach ($this->countries as $countryIndex => $country) {
            foreach ($country['ranges'] as $rangeIndex => $range) {
                $rules["countries.$countryIndex.ranges.$rangeIndex.pivot.price"] = 'required|numeric';
            }
        }

        $this->validate($rules);

        // Sauvegarde des données
        foreach ($this->countries as $countryData) {
            $country = Country::find($countryData['id']);

            foreach ($countryData['ranges'] as $rangeData) {
                $country->ranges()->updateExistingPivot($rangeData['id'], [
                    'price' => $rangeData['pivot']['price'],
                ]);
            }
        }

        $this->success(__('Rates saved successfully.'));
    }
    
    public function updated($property, $value): void
    {
        $segments = explode('.', $property);
        $countryIndex = $segments[1];
        $rangeIndex = $segments[3];
        $this->countries[$countryIndex]['ranges'][$rangeIndex]['pivot']['price'] = number_format((float) $value, 2, '.', '');
    }

    public function with(): array
	{
		return [
            'ranges' => Range::all(),
		];
	} 
    
}; ?>

<div>
    <x-header title="{{ __('Postal rate management') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit="save">
            <table class="min-w-full rounded-lg border border-gray-300 shadow-md border-collapse">
                <thead class="text-gray-700 bg-gray-200">
                    <tr>
                        <th class="p-2 text-left border border-gray-300">Pays</th>
                        @foreach ($ranges as $range)
                            <th class="p-2 text-center border border-gray-300">≤ {{ $range->max }} Kg</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($countries as $countryIndex => $country)
                        <tr class="hover:bg-gray-100">
                            <td class="p-2 font-medium text-left border border-gray-300">{{ $country['name'] }}</td>
                            @foreach ($country['ranges'] as $rangeIndex => $range)
                                <td class="p-2 text-center border border-gray-300">
                                    <x-input 
                                        wire:model="countries.{{ $countryIndex }}.ranges.{{ $rangeIndex }}.pivot.price"
                                        class="w-full text-center"
                                        required
                                    />
                                </td>
                            @endforeach
                        </tr>
                    @endforeach                
                </tbody>
            </table>                   
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
