<ul class="p-2 mb-2">
    @isset($address->name)
        <li class="font-bold">{{ "$address->civility $address->name $address->firstname" }}</li>
    @endif
    @if ($address->company)
        <li class="font-bold">{{ $address->company }}</li>
    @endif
        <li>{{ $address->address }}</li>
    @if ($address->addressbis)
        <li>{{ $address->addressbis }}</li>
    @endif
    @if ($address->bp)
        <li>{{ $address->bp }}</li>
    @endif
    <li>{{ "$address->postal $address->city" }}</li>
    <li class="font-bold">{{ $address->country->name }}</li>
    <li><x-icon name="o-phone" /><em>{{ $address->phone }}</em></li>
</ul>