<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Member;
use App\Models\Supplier;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::Create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin')
        ]);
        
        User::Create([
            'name' => 'Munawar Ahmad',
            'username' => 'anwar11',
            'email' => 'anwarahmad391@gmail.com',
            'password' => bcrypt('password')
        ]);

        User::Create([
            'name' => 'Shinta Purnama',
            'username' => 'shinta96',
            'email' => 'shinta@gmail.com',
            'password' => bcrypt('password')
        ]);

        Category::Create([
            'category_name' => 'makanan'
        ]);

        Category::Create([
            'category_name' => 'minuman'
        ]);

        Category::Create([
            'category_name' => 'vitamin'
        ]);

        Category::Create([
            'category_name' => 'obat'
        ]);

        Product::Create([
            'product_code' => '2022-08-04-fO9jFKm',
            'product_name' => 'Indomie Goreng',
            'product_category' => 'makanan',
            'product_merk' => 'Indomie',
            'buy_price' => 2800,
            'discount' => 0,
            'sell_price' => 3500,
            'stock' => 100
        ]);

        Product::Create([
            'product_code' => '2022-08-04-fO9Jkfw',
            'product_name' => 'Indomie Soto',
            'product_category' => 'makanan',
            'product_merk' => 'Indomie',
            'buy_price' => 2600,
            'discount' => 0,
            'sell_price' => 3000,
            'stock' => 100
        ]);

        Product::Create([
            'product_code' => '2022-08-04-fO9ZZuj',
            'product_name' => 'Indomie Kari Ayam',
            'product_category' => 'makanan',
            'product_merk' => 'Indomie',
            'buy_price' => 2600,
            'discount' => 0,
            'sell_price' => 3000,
            'stock' => 100
        ]);

        Product::Create([
            'product_code' => '2022-08-04-fO9saje',
            'product_name' => 'Indomie Ayam Bawang',
            'product_category' => 'makanan',
            'product_merk' => 'Indomie',
            'buy_price' => 2600,
            'discount' => 0,
            'sell_price' => 3000,
            'stock' => 100
        ]);

        Product::Create([
            'product_code' => '2022-08-04-892Jkfw',
            'product_name' => 'Fanta Orange',
            'product_category' => 'minuman',
            'product_merk' => 'Fanta',
            'buy_price' => 3300,
            'discount' => 0,
            'sell_price' => 5000,
            'stock' => 100
        ]);

        Product::Create([
            'product_code' => '2022-08-04-8956kfc',
            'product_name' => 'Fanta Strawbery',
            'product_category' => 'minuman',
            'product_merk' => 'Fanta',
            'buy_price' => 3300,
            'discount' => 0,
            'sell_price' => 5000,
            'stock' => 100
        ]);

        Product::Create([
            'product_code' => '2022-08-04-898idfm',
            'product_name' => 'Sprite',
            'product_category' => 'minuman',
            'product_merk' => 'Sprite',
            'buy_price' => 3400,
            'discount' => 0,
            'sell_price' => 5000,
            'stock' => 100
        ]);

        Member::Create([
            'member_code' => '20220804kdow',
            'member_name' => 'Muneeb Ahmad',
            'member_address' => 'Perum BPV, Ciseeng, Bogor',
            'member_phone' => '081293049941'
        ]);

        Member::Create([
            'member_code' => '2022080483ke',
            'member_name' => 'Zakiyya Sidiqa',
            'member_address' => 'Perum BPV, Ciseeng, Bogor',
            'member_phone' => '082293032893'
        ]);

        Member::Create([
            'member_code' => '2022080481hh',
            'member_name' => 'Shinta Purnama',
            'member_address' => 'Perum BPV, Ciseeng, Bogor',
            'member_phone' => '085293033849'
        ]);

        Supplier::Create([
            'supplier_code' => 'SPL-jdk0291',
            'supplier_name' => 'Toko Sumber Mulia',
            'supplier_address' => 'Jl Kenanga, Ciputat',
            'supplier_phone' => '085782939942'
        ]);

        Supplier::Create([
            'supplier_code' => 'SPL-hdj2123',
            'supplier_name' => 'MM Jaya Abadi',
            'supplier_address' => 'Jl Duren 2, Depok',
            'supplier_phone' => '089621929331'
        ]);

        Supplier::Create([
            'supplier_code' => 'SPL-zzd1221',
            'supplier_name' => 'MM Rizky 76',
            'supplier_address' => 'Jl H Aming, Bogor',
            'supplier_phone' => '021-293849'
        ]);

    }
}
