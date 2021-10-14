@extends('app')

@section('content')
    <h3 style="color: green">
        @if (session('item_deleted'))
            {{ session('item_deleted') }}
        @elseif (session('removed_all_from_cart'))
            {{ session('removed_all_from_cart') }}
        @elseif (session('transaction_success'))
            {{ session('transaction_success') }}
        @endif
    </h3>
    <h3 style="color: red">
        @if (session('transaction_failed'))
            {{ session('transaction_failed') }}
        @endif
    </h3>
    <h3>

        <form action="{{ route('shop.search') }}" method="GET">
            <label for="search"></label>
            <input type="text" name="search">
            <button type="submit">Search</button>
        </form>

        <form action="{{ route('shop.sortPrice') }}">
            <input type="hidden" {{ $sort ? 'value=' . $sort : 'asc' }} name="sort" />
            Sort Price: <button type="submit">{{ $sort }}</button>
            <input type="hidden" {{ $search ? 'value=' . $search : '' }} name="search" />
        </form>

        @if (count($items) > 0)
            @foreach ($items as $item)
                <a href="{{ route('items.show', $item->id) }}">{{ $item->name }} {{ $item->price }} $
                </a>
                <br>
            @endforeach
        @else No items.
        @endif
    </h3>
@endsection
