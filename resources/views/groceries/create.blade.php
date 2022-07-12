@extends('base')

@section('title')
    Create a new grocery
@endsection

@section('content')
    <div class="container">
        <h1>
            Create a grocery list item!
        </h1>

        <form action="/groceries" method="post" class="create-item-form">
            @csrf
            <div class="form-group">
                <label for="grocery_category_id">Grocery category</label>
                <select name="grocery_category_id" id="grocery_category_id" class="form-control">
                    @foreach ($groceryCategories as $groceryCategory)
                        <option value="{{ $groceryCategory->id }}">{{ $groceryCategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="any" required>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" step="any" required>
            <input type="submit" value="Create">
        </form>
    </div>
@endsection
