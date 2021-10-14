<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $_SERVER['SERVER_NAME'] }}</title>
</head>

<body>
    <h3>
        <a href="{{ route('items.index') }}">HOME /</a>
        <a href="{{ route('profile') }}">
            Contul meu {{ Auth::user() ? '(' . Auth::user()->name . ')' : '' }} /
        </a>
        <a href="{{ route('shop.showCart') }}"> Shopping Cart
            @if (session()->get('cart'))
                @php
                    $totalQuantity = 0;
                    foreach (session()->get('cart') as $id => $item) {
                        $totalQuantity += $item['quantity'];
                    }
                @endphp
                ({{ $totalQuantity }})
            @endif
        </a>
    </h3>

    @yield('content')
</body>

</html>
