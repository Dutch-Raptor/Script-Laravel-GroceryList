<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Catch_;
use App\Models\Category;
use App\Models\Grocery;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        Category::truncate();

        Category::create([
            'name' => 'Beverages',
        ]);
        Category::create([
            'name' => 'Bread/Bakery',
        ]);
        Category::create([
            'name' => 'Canned/Jarred Goods',
        ]);
        Category::create([
            'name' => 'Dry/Baking Goods',
        ]);
        Category::create([
            'name' => 'Frozen Foods',
        ]);
        Category::create([
            'name' => 'Meat',
        ]);
        Category::create([
            'name' => 'Produce',
        ]);
        Category::create([
            'name' => 'Other',
        ]);

        Grocery::factory(25)->create();
        cache()->forget('groceries.all');
        cache()->forget('groceries.categories');
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
