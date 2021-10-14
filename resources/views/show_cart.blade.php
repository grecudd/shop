@extends('app')

@section('content')
    <h3 style="color: green">
        @if (session('removed_from_cart'))
            {{ session('removed_from_cart') }}
        @endif
    </h3>
    <h2>
        @if ($cart)
            @foreach ($cart as $id => $item)
                {{ $item['quantity'] }} x
                <a href="{{ route('items.show', $item['id']) }}">
                    {{ $item['name'] }} ({{ $item['price'] }} $)
                </a>

                <form action="{{ route('shop.addToCart', $item['id']) }}" method="POST">
                    @csrf
                    <button type="submit">+</button>
                </form>

                <form action="{{ route('shop.removeFromCart', $item['id']) }}" method="POST">
                    @csrf
                    <button type="submit">-</button>
                </form>
            @endforeach

            Total : {{ $totalPrice }} $

            <form action="{{ route('shop.buy') }}" method="POST">
                @csrf
                <button type="submit">Buy</button>
            </form>

            <form action="{{ route('shop.removeAll') }}" method="POST">
                @csrf
                <button type="submit">Remove all</button>
            </form>
        @else Cart empty.
        @endif
    </h2>
@endsection
