<?php

namespace App\Traits;

trait ManageState 
{
    public string $name;
    public string $slug;
    public string $color = 'blue';
    public string $indice = '0';
    
    public function with(): array
    {
        return [
            'colors' => [
                [ 'name' => __('Blue'), 'id' => 'blue' ],
                [ 'name' => __('Red'), 'id' => 'red' ],
                [ 'name' => __('Green'), 'id' => 'green' ],
                [ 'name' => __('Gray'), 'id' => 'gray' ],
            ],
        ];
    }

    protected function validateStateData(array $additionalData = []): array
    {
        $stateId = property_exists($this, 'state') && isset($this->state->id) 
            ? ',' . $this->state->id 
            : '';

        $rules = [
            'name' => "required|string|max:100|unique:states,name{$stateId}",
            'slug' => "required|string|max:50|unique:states,slug{$stateId}|regex:/^[a-z0-9-]+$/",
            'color' => 'required|string|max:20|in:blue,red,green,gray',
            'indice' => 'required|numeric|min:0|max:20',
        ];

        return $this->validate(array_merge($rules, $additionalData));
    }
}