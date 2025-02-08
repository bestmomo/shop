<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\{ Country, Range };
use Mary\Traits\Toast;
use Illuminate\Support\Collection;

new #[Title('Ranges')] #[Layout('components.layouts.admin')] class extends Component
{
    use Toast;

    public array $ranges;

    public function headers(): array
	{
		return [['key' => 'max', 'label' => __('Maximum weight')], ];
	}

    public function mount(): void
    {
        $this->ranges = Range::all()->toArray();
    }

    public function updateRangeMax($index, $value): void
    {
        // Vérification si la valeur est numérique
        if (!is_numeric($value)) {
            $this->resetRangeMaxToOriginal($index);
            $this->error(__('The value must be a valid number.'));
            return;
        }

        $max = (float) $value;

        // Charger la plage actuelle
        $range = Range::find($this->ranges[$index]['id']);
        if (!$range) {
            $this->error(__('Range not found.'));
            return;
        }

        // Vérifier les plages adjacentes
        $previousRange = Range::where('max', '<', $range->max)->orderBy('max', 'desc')->first();
        $nextRange = Range::where('max', '>', $range->max)->orderBy('max', 'asc')->first();

        if ($previousRange && $max <= $previousRange->max) {
            $this->resetRangeMaxToOriginal($index);
            $this->error(__('The new range must be greater than the previous range (:previous)', ['previous' => $previousRange->max]));
            return;
        }

        if ($nextRange && $max >= $nextRange->max) {
            $this->resetRangeMaxToOriginal($index);
            $this->error(__('The new range must be less than the next range (:next)', ['next' => $nextRange->max]));
            return;
        }

        // Mise à jour en base de données
        $range->update(['max' => $max]);

        // Mise à jour locale pour refléter le format arrondi
        $this->ranges[$index]['max'] = number_format($max, 2);

        $this->success(__('Range updated successfully.'));
    }

    // Fonction pour réinitialiser la valeur initiale
    protected function resetRangeMaxToOriginal($index): void
    {
        $originalValue = Range::find($this->ranges[$index]['id'])->max;
        $this->ranges[$index]['max'] = number_format($originalValue, 2);
    }

    public function deleteRange($id): void
    {
        $range = Range::find($this->ranges[$id]['id']);
        $range->delete();

        $this->ranges = Range::all()->toArray();
        $this->success(__('Range deleted successfully.'));
    }

    public function createRange(): void
    {
        $lastRange = Range::orderBy('max', 'desc')->first();
        $newMax = $lastRange ? $lastRange->max + 1 : 1;

        $range = Range::create(['max' => $newMax]);

        $countries = Country::all();
        foreach($countries as $country) {
            $range->countries()->attach($country, ['price' => 0]);
        }

        $this->ranges = Range::all()->toArray();

        $this->success(__('New range added successfully'));
    }

    public function with(): array
	{
		return [
			'headers' => $this->headers(),
		];
	} 

}; ?>

<div>
    <x-header title="{{ __('Weight ranges') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
            <x-button 
                icon="o-plus" 
                label="{{ __('Add Range') }}" 
                wire:click="createRange" 
                spinner 
                class="btn-primary" 
            />
        </x-slot:actions>
    </x-header>
    <x-alert title="{!! __('If you delete a range, the corresponding values in the country-specific shipping rates will also be deleted. We strongly advise you to make these changes in maintenance mode!') !!}" class="alert-warning" dismissible /><br>
    <x-card>
        <x-table striped :headers="$headers" :rows="$ranges" >
            @scope('cell_max', $range)
                <x-input 
                    label="{{ __('Range') }} {{ $loop->index + 1 }}"
                    suffix="kg"
                    type="number"
                    step="0.1" 
                    wire:model="ranges.{{ $loop->index }}.max"
                    wire:keydown.enter="updateRangeMax({{ $loop->index }}, $event.target.value)"
                    wire:blur="updateRangeMax({{ $loop->index }}, $event.target.value)"
                />
            @endscope
            @scope('actions', $range)
                @if($loop->last)
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-trash" wire:click="deleteRange({{ $loop->index }})"
                                wire:confirm="{{ __('Are you sure to delete this range?') }}" spinner
                                class="text-red-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Delete')
                        </x-slot:content>
                    </x-popover>
                @endif
            @endscope
        </x-table>
    </x-card>
</div>
