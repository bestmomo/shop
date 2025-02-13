<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Product;
use Mary\Traits\Toast;
use App\Traits\ManageProduct;
use Livewire\WithFileUploads;

new 
#[Title('Product edition')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, ManageProduct, WithFileUploads;
    
    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->promotion = $product->promotion_price != null;
        $this->fill($this->product);
    }

    public function save(): void
    {
        $data = $this->validateProductData();

        if ($this->image instanceof TemporaryUploadedFile) {
            $path = basename($this->image->store('photos', 'public'));
            $data['image'] = $path;
        }

        if(!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        $this->product->update($data);

        $this->success(__('Product updated successfully.'), redirectTo: '/admin/products');
    }
  
}; ?>

<div>
    <x-header title="{!! __('Catalog') !!}" separator progress-indicator>
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Edit a product') !!}">
        @include('livewire.admin.products.form')
    </x-card>
</div>
