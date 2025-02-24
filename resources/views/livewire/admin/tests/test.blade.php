<?php
include_once 'test.php'; ?>

@section('title', __('Test'))
<div class="container mx-auto">

    <x-header title="{{ __('Test') }}" separator progress-indicator />

    <div class="mt-3">
        {{  $state }}
        <hr>
        <x-shop.promotion />
    </div>
</div>
