<?php

use App\User;
use App\produk;
use App\UserDetail;
use App\GaleriProduk;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class ProdukSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        //     $id = produk::insertGetId([
        //     'nama_produk'=> 'baju',
        //     'harga' => '10000',
        //     'stok' => '1000',
        //     'keterangan_produk' => 'loremlorem',
        //     'created_at' => date('Y-m-d H:i:s')
        // ]);
        for($i = 0; $i < 51; $i++) {
            produk::insert([
                'nama_produk'      =>  $faker->name,
                'harga'     =>  $faker->numberBetween(25,40),
                'stok'  =>  $faker->name,
                'keterangan_produk'  =>  $faker->name,
                'created_at' => date('Y-m-d H:i:s')

            ]);

            // UserDetail::insert([
            //     'user_id' => $id,
            //     'address' => Str::random(10),
            //     'phone' => Str::random(10),
            //     'hobby' => Str::random(10),
            //     'created_at' => date('Y-m-d H:i:s')

            // ]);
        }
    }
}

