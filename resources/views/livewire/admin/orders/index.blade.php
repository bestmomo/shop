<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Order;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ManageOrders;

new 
#[Title('Orders')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, WithPagination, ManageOrders;

    public int $perPage = 10;
    public string $search = '';
    public bool $paginationOrders = true;

    public function deleteOrder(Order $order): void
    {
        $order->delete();
        $this->success(__('Order deleted successfully.'));
    }

    public function with(): array
	{
		return [
            'orders' => Order::with('user', 'state', 'addresses')
                ->orderBy(...array_values($this->sortBy))
                ->when($this->search, function (Builder $q)
                {
                    $q->where('reference', 'like', "%{$this->search}%")
                        ->orWhereRelation('addresses', 'company', 'like', "%{$this->search}%")
                        ->orWhereRelation('state', 'name', 'like', "%{$this->search}%");
                })
                ->paginate($this->perPage),
			'headersOrders' => $this->headersOrders(),
		];
	}
   
}; ?>

<div>
    <x-header title="{{ __('Orders') }}" separator progress-indicator >
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

    @include('livewire.admin.orders.table')

</div>
