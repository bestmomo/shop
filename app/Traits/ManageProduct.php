<?php

namespace App\Traits;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait ManageProduct
{
    public string $name = '';
    public TemporaryUploadedFile|string|null $image = null;
    public string $description = '';
    public float $price = 0;
    public float $weight = 0;
    public int $quantity = 0;
    public int $quantity_alert = 0;
    public bool $active = false;
    public bool $promotion = false;
    public ?float $promotion_price = null;
    public ?string $promotion_start_date = null;
    public ?string $promotion_end_date = null;

    protected function validateProductData(array $additionalData = []): array
    {
        $rules = [
            'name' => 'required|max:255',
            'image' => $this->image instanceof TemporaryUploadedFile ? 'image|mimes:jpeg,png,jpg,gif' : 'required',
            'description' => 'required|string|max:65535',
            'price' => 'required|numeric|min:0|regex:/^(\d+(?:[\.\,]\d{1,2})?)$/',
            'weight' => 'required|numeric|min:0|regex:/^(\d+(?:[\.\,]\d{1,3})?)$/',
            'quantity' => 'required|numeric|min:0',
            'quantity_alert' => 'required|numeric|min:-1|lte:quantity',
            'active' => 'required|boolean',
            'promotion_price' => 'required_if:promotion,true|nullable|numeric|min:0|regex:/^(\d+(?:[\.\,]\d{1,2})?)$/|lt:price',
            'promotion_start_date' => 'required_if:promotion,true|nullable|date',
            'promotion_end_date' => 'required_if:promotion,true|nullable|date|after:promotion_start_date',
        ];

        return $this->validate(array_merge($rules, $additionalData));
    }
}
