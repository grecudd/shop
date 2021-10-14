@extends('app')

@section('content')
    @if (session('item_added'))
        <h3 style="color: green">
            {{ session('item_added') }}
        </h3>
    @endif
    @if (Auth::user())
        @if (Auth::user()->role == 'admin')
            <form action="{{ route('items.edit', $item->id) }}" method="GET">
                @csrf
                <button type="submit">Edit</button>
            </form>

            <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit">Delete</button>
            </form>
        @endif
    @endif

    <h2>
        {{ $item->name }}
        {{ $item->price }} $ <br>
        Descriere: {{ $item->description }} <br>
        @if ($item->image_path)
            <img src="{{ asset('storage/' . $item->image_path) }}" width="200" height="150">
        @endif
    </h2>

    @if ($item->quantity)
        <form action="{{ route('shop.addToCart', $item->id) }}" method="POST">
            @csrf
            <button type="submit">Add to cart</button>
        </form>
    @endif

@endsection
