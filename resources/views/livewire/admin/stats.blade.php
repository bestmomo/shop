<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\{Order, Product, User};
use Carbon\Carbon;

new #[Title('Statistics')] #[Layout('components.layouts.admin')] class extends Component
{
    public bool $openGlance = true;
    public bool $openOrders = false;
    public bool $openProducts = false;
    public array $ordersChart = [];
    public array $productsChart = [];
    public int $selectedYear;
    public array $years = [];

    public function mount(): void
    {
        $this->selectedYear = date('Y');
        $olderYear = Order::whereRelation('state', 'indice', '>', 3)->oldest()->first()->created_at->format('Y');
        $this->years = [];
        for ($year = now()->format('Y'); $year >= $olderYear; $year--) {
            $this->years[] = ['id' => $year, 'name' => $year];
        }
        $this->updatedSelectedYear();
    }

    public function updatedSelectedYear()
    {
        $this->orders = Order::whereYear('created_at', $this->selectedYear)
            ->whereRelation('state', 'indice', '>', 3)
            ->with('products')
            ->get();

        $this->ordersChart = $this->getOrdersChart();
        $this->productsChart = $this->getProductsChart();
    }

    public function getOrdersChart(): array
    {
        $sortedOrders = $this->orders->sortBy('created_at');
        $groupedOrders = $sortedOrders->groupBy(fn ($order) => $order->created_at->format('M'));
        $labels = $groupedOrders->keys()->map(fn($month) => Carbon::createFromFormat('M', $month)->translatedFormat('F'));

        return [
            'type' => 'bar',
            'data' => [
                'labels' => $labels->values(),
                'datasets' => [
                    [
                        'label' => __('Sales revenue'),
                        'data' => $groupedOrders->map(fn ($group) => $group->sum('total'))->values(),
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1,
                    ]
                ]
            ]
        ];
    }

    public function getProductsChart(): array
    {
        $productSales = $this->orders
            ->flatMap(function ($order) {
                return $order->products;
            })
            ->groupBy('name')
            ->map(function ($items) {
                return [
                    'product' => $items->first()->name,
                    'total_quantity' => $items->sum('quantity')
                ];
            })
            ->sortByDesc('total_quantity')
            ->take(10);

        return [
            'type' => 'pie',
            'data' => [
                'labels' => $productSales->pluck('product'),
                'datasets' => [
                    [
                        'label' => __('Quantity Sold'),
                        'data' => $productSales->pluck('total_quantity'),
                    ]
                ]
            ]
        ];
    }

    public function with(): array
    {
        return [
            'ordersCount' => $this->orders->count(),
            'averageBasket' => $this->orders->avg('total'),
            'salesRevenue' => $this->orders->sum('total'),
        ];
    }

}; ?>

<div>    
    <x-header title="{{ __('Statistics') }}" separator progress-indicator>
        <x-slot:actions>
            <x-select wire:model="selectedYear" :options="$years" wire:change="$refresh" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-collapse wire:model="openGlance" class="shadow-md">
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex flex-wrap gap-4">
            <div class="flex-grow">
                <x-stat title="{{ __('Successful orders') }}" description="" value="{{ $ordersCount }}"
                    icon="s-shopping-bag" class="shadow-hover" />
            </div>
            <div class="flex-grow">
                <x-stat title="{{ __('Average basket') }}" description="" value="{{ number_format($averageBasket, 2, ',', ' ') . ' €' }}" value2="{{ $averageBasket }}"
                    icon="s-shopping-cart" class="shadow-hover" />
            </div>
            <div class="flex-grow">
                <x-stat title="{!! __('Sales revenue') !!}" description="" value="{{ number_format($salesRevenue, 2, ',', ' ') . ' €' }}" value2="{{ $salesRevenue }}"
                    icon="s-currency-euro" class="shadow-hover" />
            </div>
        </x-slot:content>
    </x-collapse><br>
    <x-collapse wire:model="openOrders" class="shadow-md">
        <x-slot:heading>
            @lang('Sales revenue')
        </x-slot:heading>
        <x-slot:content>
            <x-chart wire:model="ordersChart" class="w-full" />
        </x-slot:content>        
    </x-collapse><br>
    <x-collapse wire:model="openProducts" class="shadow-md">
        <x-slot:heading>
            @lang('Most Sold Products')
        </x-slot:heading>
        <x-slot:content class="flex justify-center">
            <div class="max-w-md w-full">
                <x-chart wire:model="productsChart" class="w-full" />
            </div>
        </x-slot:content>   
    </x-collapse>
</div>
