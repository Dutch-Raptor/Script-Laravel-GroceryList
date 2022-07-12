@extends('base')

@section('title')
    Groceries
@endsection

@section('content')
    <main>
        <div class="container">
            <h1>Groceries</h1>


            <div class="row">
                <div class="chip-card-list">
                    <a href="{{ route('groceries.index') }}"
                        class="chip-card @if ($activeCategoryId == null) active @endif">
                        All
                    </a>
                    @foreach ($groceryCategories as $groceryCategory)
                        <a href="{{ route('groceries.index', ['category' => $groceryCategory->id]) }}"
                            class="chip-card @if ($activeCategoryId == $groceryCategory->id) active @endif">
                            {{ $groceryCategory->name }}
                        </a>
                    @endforeach
                </div>

                @if ($groceries->count() === 0)
                    There are no groceries at this moment, You can add some here.
                    <a href="{{ route('groceries.create') }}">Add a grocery</a>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Purchased</th>
                                <th>Total Cost</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groceries as $grocery)
                                <tr>
                                    <td>{{ $grocery->name }}</td>
                                    <td>${{ number_format($grocery->price, 2) }}</td>
                                    <td>{{ number_format($grocery->quantity, 2) }}</td>
                                    <td>{{ $grocery->purchased ? 'Yes' : 'No' }}</td>
                                    <td>${{ number_format($grocery->price * $grocery->quantity, 2) }}</td>
                                    <td>{{ $grocery->category->name }}</td>
                                    <td>
                                        <a href="{{ route('groceries.edit', ['id' => $grocery->id]) }}">Edit</a>
                                        <form action="{{ route('groceries.destroy', ['id' => $grocery->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Total</td>
                                <td>${{ number_format($totalCost, 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            </div>
    </main>
@endsection
