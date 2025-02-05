<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title};
use App\Models\Product;
use Mary\Traits\Toast;
use App\Traits\ManageProduct;

new     
#[Title('Product creation')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, ManageProduct, WithFileUploads;
    
    public function save(): void
    {
        $data = $this->validateProductData();

        $path = basename($this->image->store('photos', 'public'));
        $data['image'] = $path;

        Product::create($data);

        $this->success(__('Product created successfully.'), redirectTo: '/admin/products');
    }
   
}; ?>

<div>
    <x-header title="{!! __('Catalog') !!}" separator progress-indicator >
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Create a new product') !!}">
        @include('livewire.admin.products.form')
    </x-card>
</div>
