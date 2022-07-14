@extends('base')

@section('title')
    Edit a grocery
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit a grocery</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('groceries.update', $grocery->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        {{-- Create a grocery category dropdown --}}
                        <label for="category_id">Grocery category</label>
                        <select name="category_id" id="category_id" value="{{ $grocery->category_id }}"
                            class="form-select">
                            @foreach ($groceryCategories as $groceryCategory)
                                <option value="{{ $groceryCategory->id }}"
                                    {{ $grocery->category_id == $groceryCategory->id ? 'selected' : '' }}>
                                    {{ $groceryCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $grocery->name }}">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="any" class="form-control" id="price" name="price"
                            value="{{ $grocery->price }}">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" step="any" class="form-control" id="quantity" name="quantity"
                            value="{{ $grocery->quantity }}">
                    </div>
                    <div class="form-group">
                        <label for="purchased">Purchased</label>
                        <input type="checkbox" name="purchased" id="purchased"
                            @if ($grocery->purchased) checked @endif>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
