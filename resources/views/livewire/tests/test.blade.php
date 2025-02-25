<?php
include_once 'test.php'; ?>

@section('title', __('Test'))
<div class="">

    <x-header title="{{ __('Test') }}" separator progress-indicator />

    <div class="mt-6">

        Ready.

        <hr class='my-6'>

        @livewire('mktg.shop.promotion', ['target' => 'back'])

        <hr class='my-6'>

        @livewire('mktg.shop.promotion')

    </div>

</div>
