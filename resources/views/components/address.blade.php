<ul class="p-2 mb-2">

    @if ($address->company)
        <li class="font-bold">{{ $address->company }}</li>
    @endif

    @isset($address->name)
        <li>{{ "$address->civility. $address->name $address->firstname" }}</li>
    @endif


        <li>{{ $address->address }}</li>

    @if ($address->addressbis)
        <li>{{ $address->addressbis }}</li>
    @endif

    @if ($address->bp)
        <li>{{ $address->bp }}</li>
    @endif

    <li>{{ $address->postal .' '. strtoupper($address->city) }}</li>
<hr>
    <li class="font-bold uppercase text-right">{{ $address->country->name }}</li>

    <li><x-icon name="o-phone" class="text-green-400"/><em>{{ $address->phone }}</em></li>
</ul>
