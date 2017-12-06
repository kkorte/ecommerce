<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ShopTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TaxRateTableSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(AttributeTableSeeder::class);        
        $this->call(ProductAttributeTableSeeder::class);        
        $this->call(SendingMethodTableSeeder::class);
        $this->call(ProductTagGroupTableSeeder::class);

        Model::reguard();
    }
}
