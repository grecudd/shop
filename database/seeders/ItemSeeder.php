<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = new Item();
        $item->name = "laptop";
        $item->description = "laptop Asus";
        $item->price = 2700;
        $item->quantity = 4;
        $item->save();

        $item = new Item();
        $item->name = "telefon";
        $item->description = "telefon  samsung";
        $item->price = 1600;
        $item->quantity = 5;
        $item->save();
    }
}
