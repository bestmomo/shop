<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Page;
use Mary\Traits\Toast;

new 
#[Title('Pages')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast;
    
    public array $sortBy = [
        'column' => 'title',
        'direction' => 'asc',
    ];

    public function headers(): array
    {
        return [
            ['key' => 'title', 'label' => __('Title')],
            ['key' => 'slug', 'label' => __('Slug')],
        ];
    }

    public function deletePage(Page $page): void
    {
        $page->delete();
        $this->success(__('Page deleted successfully.'));
    }

    public function with(): array
	{
		return [
            'pages' => Page::orderBy(...array_values($this->sortBy))->get(),			
			'headers' => $this->headers(),
		];
	}
   
}; ?>

<div>
    <x-header title="{{ __('Pages') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
            <x-button 
                icon="o-plus" 
                label="{!! __('Create a new page') !!}" 
                link="/admin/pages/create" 
                spinner 
                class="btn-primary" 
            />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table 
            striped 
            :headers="$headers" 
            :rows="$pages" 
            :sort-by="$sortBy" 
            link="/admin/pages/{id}/edit"
        >
            @scope('actions', $page)
                <x-popover>
                    <x-slot:trigger>
                        <x-button 
                            icon="o-trash" 
                            wire:click="deletePage({{ $page->id }})" 
                            wire:confirm="{{ __('Are you sure you want to delete this page?') }}" 
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
