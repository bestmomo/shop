<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait ManagePage 
{
    public string $title = '';
    public string $slug = '';
    public string $text = '';

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }
    
    protected function validatePageData(array $additionalData = []): array
    {
        $pageId = property_exists($this, 'page') && isset($this->page->id) 
            ? ',' . $this->page->id 
            : '';

        $rules = [
            'title' => "required|string|max:100|unique:pages,title{$pageId}",
            'slug' => "required|string|max:50|unique:pages,slug{$pageId}|regex:/^[a-z0-9-]+$/",
            'text' => 'required|string|max:65535',
        ];

        return $this->validate(array_merge($rules, $additionalData));
    }
}