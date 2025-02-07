<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\State;
use Mary\Traits\Toast;

new 
#[Title('States')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast;
    
    public array $sortBy = [
        'column' => 'name',
        'direction' => 'asc',
    ];

    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'slug', 'label' => __('Slug')],
            ['key' => 'color', 'label' => __('Color')],
            ['key' => 'indice', 'label' => __('Index')],
        ];
    }

    public function deleteState(State $state): void
    {
        $state->delete();
        $this->success(__('State deleted successfully.'));
    }

    public function with(): array
	{
		return [
            'states' => State::orderBy(...array_values($this->sortBy))->get(),			
			'headers' => $this->headers(),
		];
	}
   
}; ?>

<div>
    <x-header title="{{ __('Order status') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
            <x-button 
                icon="o-plus" 
                label="{!! __('Create a new state') !!}" 
                link="/admin/states/create" 
                spinner 
                class="btn-primary" 
            />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table 
            striped 
            :headers="$headers" 
            :rows="$states" 
            :sort-by="$sortBy" 
            link="/admin/states/{id}/edit"
        >
            @scope('cell_color', $state)
                <x-badge value="   " class="px-6 py-2 bg-{{ $state->color }}-400" />
            @endscope

            @scope('actions', $state)
                <x-popover>
                    <x-slot:trigger>
                        <x-button 
                            icon="o-trash" 
                            wire:click="deleteState({{ $state->id }})" 
                            wire:confirm="{{ __('Are you sure you want to delete this state?') }}" 
                            spinner 
                            class="text-red-500 btn-ghost btn-sm" 
                        />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
</div>