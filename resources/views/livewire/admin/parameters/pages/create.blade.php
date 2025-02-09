<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Page;
use Mary\Traits\Toast;
use App\Traits\ManagePage;

new 
#[Title('Page creation')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, ManagePage;

    public function save(): void
    {
        $data = $this->validatePageData();

        Page::create($data);

        $this->success(__('Page created successfully.'), redirectTo: '/admin/pages');
    }
   
}; ?>

<div>
    <x-header title="{!! __('Pages') !!}" separator progress-indicator >
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Create a new page') !!}">
        @include('livewire.admin.parameters.pages.form')
    </x-card>
</div>
