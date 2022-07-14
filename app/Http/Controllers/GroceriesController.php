<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Grocery;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GroceriesController extends Controller {
    public function index(Request $request): Factory|View|Application {

        $activeCategoryId = $request->get('category') ?? null; // explicit null declaration for clarity

        if ($activeCategoryId) {
            $groceries = Grocery::with('category')->latest()->filter()->get();
        } else {
            $groceries = cache()->remember('groceries.all', now()->addMinutes(5), function () {
                return Grocery::with('category')->latest()->get();
            });
        }
        $totalCost = round(
            $groceries->map(function ($grocery) {
                return $grocery->price * $grocery->quantity;
            })
                ->sum(),
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

    public function create(): Factory|View|Application {
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

        $grocery = Grocery::create();

        $grocery->name = $request->name;
        $grocery->price = $request->price;
        $grocery->quantity = $request->quantity;
        $grocery->purchased = $request->purchased ?? false ?
            true : false;
        $grocery->category_id = $request->category_id;

        $grocery->save();

        cache()->forget('groceries.all');
        return redirect("/groceries");
    }

    public function edit(Grocery $grocery): Factory|View|Application {
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
            'grocery_category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect(route('groceries.edit', [
                "grocery" => $grocery,
            ]))->withErrors($validator->errors())->withInput();
        }



        $grocery->name = $request->name;

        $grocery->price = $request->price;

        $grocery->quantity = $request->quantity;

        $grocery->purchased = $request->purchased ?? false ?
            true : false;

        $grocery->category_id = $request->category_id;

        $grocery->save();
        cache()->forget('groceries.all');
        return redirect("/groceries");
    }

    public function destroy(Grocery $grocery) {
        $grocery->delete();
        cache()->forget('groceries.all');
        return redirect("/groceries");
    }
}
