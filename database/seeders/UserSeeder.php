<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | Create User Type: Admin & Staff
        |--------------------------------------------------------------------------
        */
        DB::table('users_type')->insert(
            [
                ['name' => 'Admin'],
                ['name' => 'Staff'],
                ['name' => 'Customer'],
            ]
        );




        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */
        $users =  [
            // admin
            [
                'type_id'       => 1,
                'name'          => 'Hai Tongmeng',
                'sex'           => 'male',
                'email'         => 'tongmeng016@gmail.com',
                'phone'         => '087544835',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/Users/Tongmeng.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')

            ],
            [
                'type_id'       => 1,
                'name'          => 'Veasna Dara',
                'sex'           => 'male',
                'email'         => 'daraa.veasna@gmail.com',
                'phone'         => '011386747',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            // staff
            [
                'type_id'       => 2,
                'name'          => 'Choeng Kimlay',
                'sex'           => 'male',
                'email'         => 'mingfongmen@gmail,com',
                'phone'         => '098787839',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/Users/Kimlay.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 2,
                'name'          => 'Heng Menghy',
                'sex'           => 'male',
                'email'         => 'hengmenghy2002@gmail.com',
                'phone'         => '085843465',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/Users/Menghy.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            // customer
            [
                'type_id'       => 3,
                'name'          => 'Chharng Chhit',
                'sex'           => 'male',
                'email'         => 'chhit085@gmail.com',
                'phone'         => '085720085',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'Ang Ousa',
                'sex'           => 'male',
                'email'         => 'Ousa@gmail.com',
                'phone'         => '093451537',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'CHAB SREYLEN',
                'sex'           => 'female',
                'email'         => 'SREYLEN@gmail.com',
                'phone'         => '0962272240',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'CHHAY SAN WATHNAK',
                'sex'           => 'male',
                'email'         => 'SANWATHNAK@gmail.com',
                'phone'         => '017246621',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'DIN PICH',
                'sex'           => 'male',
                'email'         => 'PICH@gmail.com',
                'phone'         => '086318261',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'DUONG DARIYA',
                'sex'           => 'female',
                'email'         => 'DARIYA@gmail.com',
                'phone'         => '087706927',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'EK MONIROTH',
                'sex'           => 'female',
                'email'         => 'MONIROTH@gmail.com',
                'phone'         => '0963890107',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'HEANG CHANLEANG',
                'sex'           => 'male',
                'email'         => 'CHANLEANG@gmail.com',
                'phone'         => '086471873',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'HIEK LYMONYRATANAK',
                'sex'           => 'male',
                'email'         => 'LYMONYRATANAK@gmail.com',
                'phone'         => '0885439988',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'HOK SOCHETRA',
                'sex'           => 'male',
                'email'         => 'SOCHETRA@gmail.com',
                'phone'         => '010661890',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'KANG EANGCHHEANG',
                'sex'           => 'male',
                'email'         => 'EANGCHHEANG@gmail.com',
                'phone'         => '0888957575',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'KREN SELA',
                'sex'           => 'male',
                'email'         => 'SELA@gmail.com',
                'phone'         => '016331330',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'LEANG KIMLONG',
                'sex'           => 'male',
                'email'         => 'KIMLONG@gmail.com',
                'phone'         => '078565165',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'type_id'       => 3,
                'name'          => 'LENG SOKCHHAY',
                'sex'           => 'male',
                'email'         => 'SOKCHHAY@gmail.com',
                'phone'         => '087600063',
                'password'      => bcrypt('123456'),
                'is_active'     => 1,
                'point'         => rand(5,100),

                'avatar'        => 'static/icon/user.png',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
            ],


        ];



        /*
        |--------------------------------------------------------------------------
        | Write To Database
        |--------------------------------------------------------------------------
        |
        | It will insert to table users of database minimart.
        |
        */
        DB::table('user')->insert($users);

        // $users = [];
        // DB::table('user')->insert($users);


    }
}
