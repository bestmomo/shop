<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Page;
use Mary\Traits\Toast;
use App\Traits\ManagePage;

new 
#[Title('Page edition')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, ManagePage;
    
    public Page $page;

    public function mount(Page $page): void
    {
        $this->page = $page;
        $this->fill($this->page);
    }

    public function save(): void
    {
        $data = $this->validatePageData();

        $this->page->update($data);

        $this->success(__('Page updated successfully.'), redirectTo: '/admin/pages');
    }
  
}; ?>

<div>
    <x-header title="{!! __('Pages') !!}" separator progress-indicator>
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Edit a page') !!}">
        @include('livewire.admin.parameters.pages.form')
    </x-card>
</div>
