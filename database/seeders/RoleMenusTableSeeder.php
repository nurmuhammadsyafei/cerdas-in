<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleMenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_menus')->delete();
        
        \DB::table('role_menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'menu_id' => 6,
            ),
            1 => 
            array (
                'id' => 2,
                'role_id' => 1,
                'menu_id' => 7,
            ),
            2 => 
            array (
                'id' => 3,
                'role_id' => 1,
                'menu_id' => 8,
            ),
            3 => 
            array (
                'id' => 4,
                'role_id' => 1,
                'menu_id' => 9,
            ),
            4 => 
            array (
                'id' => 5,
                'role_id' => 1,
                'menu_id' => 10,
            ),
            5 => 
            array (
                'id' => 6,
                'role_id' => 1,
                'menu_id' => 11,
            ),
            6 => 
            array (
                'id' => 7,
                'role_id' => 1,
                'menu_id' => 12,
            ),
            7 => 
            array (
                'id' => 8,
                'role_id' => 1,
                'menu_id' => 13,
            ),
            8 => 
            array (
                'id' => 9,
                'role_id' => 1,
                'menu_id' => 14,
            ),
            9 => 
            array (
                'id' => 10,
                'role_id' => 1,
                'menu_id' => 15,
            ),
            10 => 
            array (
                'id' => 11,
                'role_id' => 1,
                'menu_id' => 16,
            ),
            11 => 
            array (
                'id' => 12,
                'role_id' => 1,
                'menu_id' => 17,
            ),
            12 => 
            array (
                'id' => 13,
                'role_id' => 1,
                'menu_id' => 18,
            ),
            13 => 
            array (
                'id' => 53,
                'role_id' => 1,
                'menu_id' => 19,
            ),
            14 => 
            array (
                'id' => 14,
                'role_id' => 2,
                'menu_id' => 6,
            ),
            15 => 
            array (
                'id' => 15,
                'role_id' => 2,
                'menu_id' => 7,
            ),
            16 => 
            array (
                'id' => 16,
                'role_id' => 2,
                'menu_id' => 8,
            ),
            17 => 
            array (
                'id' => 17,
                'role_id' => 2,
                'menu_id' => 9,
            ),
            18 => 
            array (
                'id' => 18,
                'role_id' => 2,
                'menu_id' => 10,
            ),
            19 => 
            array (
                'id' => 19,
                'role_id' => 2,
                'menu_id' => 11,
            ),
            20 => 
            array (
                'id' => 20,
                'role_id' => 2,
                'menu_id' => 12,
            ),
            21 => 
            array (
                'id' => 21,
                'role_id' => 2,
                'menu_id' => 13,
            ),
            22 => 
            array (
                'id' => 22,
                'role_id' => 2,
                'menu_id' => 14,
            ),
            23 => 
            array (
                'id' => 23,
                'role_id' => 2,
                'menu_id' => 15,
            ),
            24 => 
            array (
                'id' => 24,
                'role_id' => 2,
                'menu_id' => 16,
            ),
            25 => 
            array (
                'id' => 25,
                'role_id' => 2,
                'menu_id' => 17,
            ),
            26 => 
            array (
                'id' => 26,
                'role_id' => 2,
                'menu_id' => 18,
            ),
            27 => 
            array (
                'id' => 54,
                'role_id' => 2,
                'menu_id' => 19,
            ),
            28 => 
            array (
                'id' => 27,
                'role_id' => 3,
                'menu_id' => 6,
            ),
            29 => 
            array (
                'id' => 28,
                'role_id' => 3,
                'menu_id' => 7,
            ),
            30 => 
            array (
                'id' => 29,
                'role_id' => 3,
                'menu_id' => 8,
            ),
            31 => 
            array (
                'id' => 30,
                'role_id' => 3,
                'menu_id' => 9,
            ),
            32 => 
            array (
                'id' => 31,
                'role_id' => 3,
                'menu_id' => 10,
            ),
            33 => 
            array (
                'id' => 32,
                'role_id' => 3,
                'menu_id' => 11,
            ),
            34 => 
            array (
                'id' => 33,
                'role_id' => 3,
                'menu_id' => 12,
            ),
            35 => 
            array (
                'id' => 34,
                'role_id' => 3,
                'menu_id' => 13,
            ),
            36 => 
            array (
                'id' => 35,
                'role_id' => 3,
                'menu_id' => 14,
            ),
            37 => 
            array (
                'id' => 36,
                'role_id' => 3,
                'menu_id' => 15,
            ),
            38 => 
            array (
                'id' => 55,
                'role_id' => 3,
                'menu_id' => 19,
            ),
            39 => 
            array (
                'id' => 37,
                'role_id' => 4,
                'menu_id' => 6,
            ),
            40 => 
            array (
                'id' => 38,
                'role_id' => 4,
                'menu_id' => 8,
            ),
            41 => 
            array (
                'id' => 39,
                'role_id' => 4,
                'menu_id' => 9,
            ),
            42 => 
            array (
                'id' => 40,
                'role_id' => 4,
                'menu_id' => 10,
            ),
            43 => 
            array (
                'id' => 41,
                'role_id' => 4,
                'menu_id' => 11,
            ),
            44 => 
            array (
                'id' => 42,
                'role_id' => 4,
                'menu_id' => 12,
            ),
            45 => 
            array (
                'id' => 43,
                'role_id' => 4,
                'menu_id' => 13,
            ),
            46 => 
            array (
                'id' => 44,
                'role_id' => 4,
                'menu_id' => 14,
            ),
            47 => 
            array (
                'id' => 45,
                'role_id' => 4,
                'menu_id' => 15,
            ),
            48 => 
            array (
                'id' => 46,
                'role_id' => 5,
                'menu_id' => 6,
            ),
            49 => 
            array (
                'id' => 47,
                'role_id' => 5,
                'menu_id' => 7,
            ),
            50 => 
            array (
                'id' => 48,
                'role_id' => 5,
                'menu_id' => 8,
            ),
            51 => 
            array (
                'id' => 49,
                'role_id' => 5,
                'menu_id' => 14,
            ),
            52 => 
            array (
                'id' => 50,
                'role_id' => 5,
                'menu_id' => 15,
            ),
            53 => 
            array (
                'id' => 56,
                'role_id' => 5,
                'menu_id' => 19,
            ),
            54 => 
            array (
                'id' => 51,
                'role_id' => 6,
                'menu_id' => 6,
            ),
            55 => 
            array (
                'id' => 52,
                'role_id' => 6,
                'menu_id' => 12,
            ),
        ));
        
        
    }
}