<?php

use Livewire\Volt\Component;
use App\Models\Page;

new class extends Component {

    public Page $page;
    
    public function mount(Page $page): void
    {
        $this->page = $page;
    }

}; ?>

<div class="container mx-auto">
    <x-card title="{!! $this->page->title !!}" class="w-full shadow-md shadow-gray-500" shadow separator >
        {!! $this->page->text !!}
    </x-card>
</div>
