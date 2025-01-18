<?php

use App\Models\Shop;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Barryvdh\DomPDF\Facade\Pdf;

new #[Title('Rgpd')]
class extends Component {

	public function getPdf()
	{
		$user = Auth()->user();

		$user->load('addresses', 'orders', 'orders.state', 'orders.products');

		$shop = Shop::firstOrFail();

		$pdf = Pdf::loadView('livewire.account.rgpd.pdf', compact('user', 'shop'));

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->stream();
            },
            'rgpd.pdf'
        );
	}

}; ?>

<div>
	<x-card class="flex justify-center items-center mt-6" title="{{ __('RGPD') }}" shadow separator progress-indicator>
		<x-accordion wire:model="group" class="w-full sm:min-w-[50vw]">
			<x-collapse name="group1" class="bg-base-200">
				<x-slot:heading>@lang('Access to my informations')</x-slot:heading>
				<x-slot:content class="text-center">
					<p>@lang('You can access your personal information stored in our database. Just click on the button below to download a PDF document containing all your data.')</p>
					<br>
					<x-button label="{{ __('Get my information') }}" wire:click="getPdf" class="w-full btn-primary" />
				</x-slot:content>
			</x-collapse>
			<x-collapse name="group2" class="bg-base-200">
				<x-slot:heading>@lang('Correction of mistakes')</x-slot:heading>
				<x-slot:content class="text-center">
					<p>@lang('You can modify all personal information accessible from your account page: identity, addresses. For any other rectification, please contact us by sending an e-mail to the address below. We will reply as soon as possible.')</p>
					<br>
					<a href="mailto:{{ $shop->email }}" class="text-blue-600">{{ $shop->email }}</a>					
				</x-slot:content>
			</x-collapse>
		</x-accordion>
    </x-card>
</div>
