<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Grocery;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroceriesController extends Controller {
    public function index(Request $request): View {

        $activeCategoryId = $request->get('category') ?? null; // explicit null declaration for clarity

        $groceries = Grocery::with('category')->latest()->filter()->get();

        $totalCost = round(
            $groceries->reduce(function ($carry, $grocery) {
                return $carry + $grocery->price * $grocery->quantity;
            }, 0),
            2
        );

        $groceryCategories = cache()->remember('groceries.categories', now()->addMinutes(5), function () {
            return Category::all();
        });




        return view(
            "groceries.index",
            [
                'groceries' => $groceries,
                'totalCost' => $totalCost,
                'groceryCategories' => $groceryCategories,
                'activeCategoryId' => $activeCategoryId,
            ]
        );
    }

    public function create(): View {
        $groceryCategories = cache()->remember('groceries.categories', now()->addMinutes(5), function () {
            return Category::all();
        });
        return view("groceries.create", [
            'groceryCategories' => $groceryCategories,
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'grocery_category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect(route('groceries.create'))->withErrors($validator->errors())->withInput();
        }

        $grocery = Grocery::create(
            [
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->grocery_category_id,
            ]
        );
        return redirect("/groceries");
    }

    public function edit(Grocery $grocery): View {
        $groceryCategories = Category::all();
        return view("groceries.edit", [
            'grocery' => $grocery,
            'groceryCategories' => $groceryCategories,
        ]);
    }

    public function update(Request $request, Grocery $grocery) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'purchased' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return redirect(route('groceries.edit', [
                "grocery" => $grocery,
            ]))->withErrors($validator->errors())->withInput();
        }

        $grocery->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'purchased' => $request->purchased ?? false ?
                true : false,
            'category_id' => $request->category_id,
        ]);

        return redirect("/groceries");
    }

    public function destroy(Grocery $grocery) {
        $grocery->delete();
        cache()->forget('groceries.all');
        return redirect("/groceries");
    }
}
