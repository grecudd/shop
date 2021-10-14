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
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li style="color: red">
                    {{ $error }}
                </li>
            @endforeach
        @endif

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name">Name: </label>
            <input type="text" name="name">
            <br>

            <label for="description">Description: </label>
            <input type="text" name="description">
            <br>

            <label for="price">Price: </label>
            <input type="text" name="price">
            <br>

            <label for="quantity">Quantity: </label>
            <input type="text" name="quantity">
            <br>

            <input type="file" name="image">
            <br>

            <button type="submit">Save</button>
        </form>
    </h3>
    <form action="{{ route('items.index') }}">
        <button type="submit">Cancel</button>
    </form>

</body>

</html>
