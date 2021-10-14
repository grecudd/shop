@extends('app')

@section('content')
    <h2>
        <a href="{{ route('shop.logOut') }}">LogOut</a> <br>
        Username : {{ Auth::user()->name }} <br>
        Balance : {{ Auth::user()->balance }} $ <br>
        @if (Auth::user()->role == 'admin')
            <form action="{{ route('items.create') }}" method="GET">
                @csrf
                <button type="submit">Add item</button>
            </form>
        @endif
        <br>
        @if (count($buyHistory) > 0)
            History:
            @foreach ($buyHistory as $item)
                <li>
                    {{ $item->bought_quantity }} x
                    <a href="{{ route('items.show', $item->id) }}">
                        {{ $item->name }} {{ $item->price }} $
                    </a>
                </li>

            @endforeach
        @else No history.
        @endif
    </h2>
@endsection
