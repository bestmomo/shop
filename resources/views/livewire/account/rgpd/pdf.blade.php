<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  </head>
  <body>
    <h2>{{ $shop->name }}</h2>
    <p>{{ $user->name }} {{ $user->firstname }}</p>
    <p>{{ \Carbon\Carbon::now() }}</p>
    <h3>@lang('General informations')</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">@lang('Name')</th>
          <th scope="col">@lang('FirstName')</th>
          <th scope="col">@lang('Email')</th>
          <th scope="col">@lang('Account creation date')</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->firstname }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at->calendar() }}</td>
        </tr>
      </tbody>
    </table>
    <h3>@lang('Addresses')</h3>
    @foreach($user->addresses as $address)
      <table class="table table-bordered table-striped table-sm">
        <tbody>
          @isset($address->name)
            <tr>
              <td><strong>@lang('Name')</strong></td>
              <td>{{ "$address->civility $address->name $address->firstname" }}</td>
            </tr>
          @endisset
          @if($address->company)
            <tr>
              <td><strong>@lang('Company name')</strong></td>
              <td>{{ $address->company }}</td>
            </tr>          
          @endif 
          <tr>
            <td><strong>@lang('Address')</strong></td>
            <td>{{ $address->address }}</td>
          </tr>
          @if($address->addressbis)
            <tr>
              <td><strong>@lang('Address complement')</strong></td>
              <td>{{ $address->addressbis }}</td>
            </tr>     
          @endif
          @if($address->bp)
            <tr>
              <td><strong>@lang('Postcode')</strong></td>
              <td>{{ $address->bp }}</td>
            </tr>
          @endif
          <tr>
            <td><strong>@lang('City')</strong></td>
            <td>{{ "$address->postal $address->city" }}</td>
          </tr>
          <tr>
            <td><strong>@lang('Country')</strong></td>
            <td>{{ $address->country->name }}</td>
          </tr>
          <tr>
            <td><strong>@lang('Phone number')</strong></td>
            <td>{{ $address->phone }}</td>
          </tr>
        </tbody>
      </table>
      <hr>
    @endforeach
    <h3>@lang('Orders')</h3>
    @foreach($user->orders as $order)
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <tr>
            <th>@lang('Reference')</th>
            <th>@lang('Date')</th>
            <th>@lang('Total incl. VAT')</th>
            <th>@lang('Payment method')</th>
            <th>@lang('State')</th>
          </tr>
        </thead>    
        <tbody>        
          <tr>
            <td>{{ $order->reference }}</td>
            <td>{{ $order->created_at->calendar() }}</td>
            <td>{{ number_format($order->total + $order->shipping, 2, ',', ' ') }} €</td>
            <td>{{ $order->payment_text }}</td>
            <td>{{ $order->state->name }}</td>
          </tr>
        </tbody>
      </table>
      <h5>@lang('Details of the order')</h5>
      <table class="table table-bordered table-striped table-sm">
        @foreach ($order->products as $item)
          <tr>
            <td>{{ $item->name }} ({{ $item->quantity }} @if($item->quantity > 1) items) @else item) @endif</td>
            <td>{{ number_format($item->total_price_gross, 2, ',', ' ') }} €</td>
          </tr>
        @endforeach
        <tr>
          <td>@lang('Colissimo delivery')</td>
          <td>{{ number_format($order->shipping, 2, ',', ' ') }} €</td>
        </tr>
        <tr>
          <td>@lang('VAT to ') {{ $order->tax * 100 }} %</td>
          <td>{{ number_format($order->total / (1 + $order->tax) * $order->tax, 2, ',', ' ') }} €</td>
        </tr>
        <tr>
          <td>@lang('Total incl. VAT')</td>
          <td>{{ number_format($order->total + $order->shipping, 2, ',', ' ') }} €</td>
        </tr>
      </table>
      <hr>
    @endforeach
    <h3>@lang('Newsletter')</h3>
    @if($user->newsletter)
      <p>@lang('You have subscribed to our newsletter.')</p>
    @else
      <p>@lang('You are not subscribed to the newsletter.')</p>
    @endif
  </body>
</html>