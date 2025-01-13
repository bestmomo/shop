<?php

use App\Models\Footer;
use Livewire\Volt\Component;

new class() extends Component {

};
?>

<footer class="p-10 text-white bg-cyan-700 footer">
    <nav>
      <a href="{{ route('pages', ['page' => 'livraisons']) }}" class="link link-hover">@lang('Shipping')</a>
      <a href="{{ route('pages', ['page' => 'mentions-legales']) }}" class="link link-hover">@lang('Legal informations')</a>
      <a href="{{ route('pages', ['page' => 'conditions-generales-de-vente']) }}" class="link link-hover">@lang('Terms and conditions of sale')</a>
    </nav>
    <nav>
        <a href="{{ route('pages', ['page' => 'politique-de-confidentialite']) }}" class="link link-hover">@lang('Privacy policy')
        <a href="{{ route('pages', ['page' => 'respect-environnement']) }}" class="link link-hover">@lang('Environmental protection')</a>
        <a href="{{ route('pages', ['page' => 'mandat-administratif']) }}" class="link link-hover">@lang('Administrative mandate')</a>
    </nav>
    <nav>
      <h6 class="footer-title">@lang('Social medias')</h6>
      <div class="grid grid-flow-col gap-4">
        <a href="{{ $shop->facebook }}" target="_blank">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current">
            <path
              d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
          </svg>
        </a>
      </div>
    </nav>
</footer>
