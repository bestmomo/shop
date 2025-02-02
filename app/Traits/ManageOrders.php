<?php

namespace App\Traits;

trait ManageOrders 
{
    public array $sortBy = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];
    
    public function headersOrders(): array
    {
        return [
            ['key' => 'id', 'label' => __('Id')],
            ['key' => 'reference', 'label' => __('Reference')], 
            ['key' => 'user', 'label' => __('Customer'), 'sortable' => false],            
            ['key' => 'total', 'label' => __('Total price')],
            ['key' => 'created_at', 'label' => __('Date')],
            ['key' => 'state', 'label' => __('Etat'), 'sortable' => false],
            ['key' => 'invoice_id', 'label' => __('Invoice')],
        ];
    }

}