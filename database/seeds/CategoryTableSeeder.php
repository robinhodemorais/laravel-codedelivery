<?php

use CodeDelivery\Models\Category;
use CodeDelivery\Models\Product;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Quando cria as categorias ele ja cria os produtos tbem
        factory(Category::class,10)->create()->each(function($c){

            for($i=0; $i<=5; $i++){
                $c->products()->save(factory(Product::class)->make());
            }
        });
    }
}
