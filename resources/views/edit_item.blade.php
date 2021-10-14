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
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <label for="name">Name: </label>
            <input type="text" name="name" value="{{ $item->name }}">
            <br>

            <label for="description">Description: </label>
            <input type="text" name="description" value="{{ $item->description }}">
            <br>

            <label for="price">Price: </label>
            <input type="text" name="price" value="{{ $item->price }}">
            <br>

            <label for="quantity">Quantity: </label>
            <input type="text" name="quantity" value="{{ $item->quantity }}">
            <br>

            <input type="file" name="image">
            <br>

            <button type="submit">Save</button>
        </form>

        <form action="{{ route('items.index') }}">
            <button type="submit">Cancel</button>
        </form>
    </h3>

</body>

</html>
