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

new #[Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination, ManageOrders;

    public int $perPage = 10;
    public bool $paginationOrders = true;

    public function deleteOrder(Order $order): void
    {
        $order->delete();
        $this->success(__('Order deleted successfully.'));
    }

    public function with(): array
    {
        // On utilise un service pour récupérer les commandes
        // en fonction des paramètres de recherche et de tri
        // et des paramètres de pagination
        $orders = (new orderService($this))->req()->paginate($this->perPage);

        // On ajoute un index pretty pour chaque commande
        // pour afficher un numéro de commande + lisible & + pro
        $orders->setCollection($this->setPrettyOrdersIndexes($orders->getCollection()));

        // On renvoie les en-têtes de la table des commandes
        // et la liste des commandes
        return ['headersOrders' => $this->headersOrders(), 'orders' => $orders];
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
