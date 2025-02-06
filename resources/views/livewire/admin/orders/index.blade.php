<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Order;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ManageOrders;
use App\Http\Tools\IndexesPrettier;

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
	{   //2fix sort by customsers (User)
		$orders = [
            'orders' => Order::with('user', 'state', 'addresses')
                ->when($this->sortBy['column'] === 'user',
                    function ($query) {
                        $query->orderBy(function ($query) {
                            $query
                                ->selectRaw(
                                    'COALESCE(
                                (SELECT company FROM order_addresses WHERE order_addresses.order_id = orders.id LIMIT 1),
                                (SELECT CONCAT(users.name, " ", users.firstname)
                                FROM users
                                WHERE users.id = orders.user_id)
                            )',
                                )
                                ->limit(1);
                        }, $this->sortBy['direction']);
                    },
                    function ($query) {
                        $query->orderBy(...array_values($this->sortBy));
                    },
                )
                ->when($this->search, function (Builder $q) {
                    $q->where('reference', 'like', "%{$this->search}%")
                        ->orWhereRelation('addresses', 'company', 'like', "%{$this->search}%")
                        ->orWhereRelation('user', 'name', 'like', "%{$this->search}%")
                        ->orWhereRelation('user', 'firstname', 'like', "%{$this->search}%")
                        ->orWhere('total', 'like', "%{$this->search}%")
                        ->orWhere('invoice_id', 'like', "%{$this->search}%");
                })
                ->paginate($this->perPage),
            'headersOrders' => $this->headersOrders(),
        ];

        $newCollection = $this->setPrettyOrdersIndexes($orders['orders']->getCollection());
        $orders['orders']->setCollection($newCollection);
        return $orders;
    }
}; ?>

<div>
    <x-header title="{{ __('Orders') }}" separator progress-indicator>
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
