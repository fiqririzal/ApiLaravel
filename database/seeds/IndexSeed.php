<?php

use App\User;
use App\produk;
use App\UserDetail;
use App\GaleriProduk;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class IndexSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $id = User::insertGetId([
            'name'=> 'Fiqri',
            'email' => 'fiqririzal10@gmail.com',
            'password' => Hash::make('12345678'),
            'created_at' => date('Y-m-d H:i:s')

        ]);
        userDetail::insert([
            'user_id'=>$id,
            'address' => 'jalan babakan desa01/01',
            'phone' => '081234567',
            'hobby'=>'makan',
            'created_at' => date('Y-m-d H:i:s')

        ]);
        for($i = 0; $i < 51; $i++) {
            $id = User::insertGetId([
                'name'      =>  $faker->name,
                'email'     =>  $faker->unique()->safeEmail,
                'password'  =>  Hash::make('password'),
                'created_at' => date('Y-m-d H:i:s')

            ]);

            UserDetail::insert([
                'user_id' => $id,
                'address' => Str::random(10),
                'phone' => Str::random(10),
                'hobby' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s')

            ]);
       
        }
        Artisan::call('passport:install');
        }

    }
