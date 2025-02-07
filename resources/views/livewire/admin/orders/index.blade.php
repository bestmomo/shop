<?php

use App\Models\Order;
use Mary\Traits\Toast;
use App\Traits\ManageOrders;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Services\OrderService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Database\Eloquent\Builder;

new #[Layout('components.layouts.admin')]
class extends Component {
    use Toast, WithPagination, ManageOrders;

    public int $perPage = 10;
    public string $search = '';
    public bool $paginationOrders = true;
    // private $orderService;

    // public function __construct(OrderService $orderService)
    // {
    //     $this->orderService = $orderService;
    // }

    public function deleteOrder(Order $order): void
    {
        $order->delete();
        $this->success(__('Order deleted successfully.'));
    }

    public function with(): array
    {
        $usedDbSystem = config('database.default', 'mysql');
        $adaptedReq = 'sqlite' === $usedDbSystem ? "users.name || ' ' || users.firstname" : "CONCAT(users.name, ' ', users.firstname)";
        // Debugbar::addMessage($adaptedReq);
        $orders = [
            'orders' => Order::with('user', 'state', 'addresses')
                ->when(
                    'user' === $this->sortBy['column'],
                    function ($query) use ($adaptedReq) {
                        $query->orderBy(function ($query) use ($adaptedReq) {
                            $query
                                ->selectRaw(
                                    'COALESCE(
                                        (SELECT company FROM order_addresses WHERE order_addresses.order_id = orders.id LIMIT 1),
                                        (SELECT ' . $adaptedReq . ' FROM users
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
                // Debugbar::info($orders['orders']->first());
                // Debugbar::info($orders['orders']->first()->user);
        $newCollection = $this->setPrettyOrdersIndexes($orders['orders']->getCollection());
        $orders['orders']->setCollection($newCollection);

        $orders2 = new orderService($this->sortBy);
        // Debugbar::info($orders2);
        return $orders;
    }
}; ?>

@section('title', __('Orders'))
<div>
    <x-header title="{{ __('Orders') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    @include('livewire.admin.orders.table')

</div>
