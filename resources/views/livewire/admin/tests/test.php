<?php


use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;

new
#[Layout('components.layouts.admin')]
class extends Component {

	public function mount()
	{
		//
	}

	public function with(): array
	{

		return ['state' => 'Ready'];
	}
};
