<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_code' => '95d4e862-0f61-4ea1-819f-fae00083a8ac',
                'name' => 'Super Admin',
                'email' => 'superadmin@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$biiLEEOoEepKBm.ykzU6B.r/Sc38Or4l69ajknKW6jo2Z8NHEPMsS',
                'remember_token' => NULL,
                'last_login' => '2026-04-15 01:23:42',
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 01:23:42',
                'role_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'user_code' => '7886cd3d-b3ef-482a-9e35-2d5fe4d6f6e8',
                'name' => 'Ahmad Administrator',
                'email' => 'admin@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$2uJOo0ROj8NVxhNzmKBfWu3bBh84aXOepUn2MMMXw2tNQ.I8ZDaWG',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'user_code' => '7c8a26c5-6d48-48d6-a2e2-8bab850c3ced',
                'name' => 'Drs. Bambang Kusuma, M.Pd',
                'email' => 'kepsek@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$qjx8bJLsnhAt8hxVht.2uOj4yRpZR8KUiJNQCaeIEbrQ8M6Ckaqju',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 3,
            ),
            3 => 
            array (
                'id' => 4,
                'user_code' => 'c4e9f06c-72e3-49e2-a87d-b0c70818a043',
                'name' => 'Ibu Sri Wahyuni, S.Pd',
                'email' => 'guru1@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$gZfDrKvSnq4UJQbW57K/sOcXmksbILzw7AGAcRv0zdXw0RtH1a0DC',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 4,
            ),
            4 => 
            array (
                'id' => 5,
                'user_code' => '61c861d1-315c-4ab0-a0b9-b2df5e7eef35',
                'name' => 'Bapak Hendra Saputra, S.Pd',
                'email' => 'guru2@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$9RQtEtMIIIwWwYZyidG3pOiViID.Su5xDiZTneART7LFZ/bkjHvBy',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 4,
            ),
            5 => 
            array (
                'id' => 6,
                'user_code' => '0958fc71-8ba9-4f15-9f0a-b884ff5260a8',
                'name' => 'Ibu Rina Marlina, S.Pd',
                'email' => 'guru3@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$xJ7gCeqvqWOIpZkV3VEW2OBFVx1OopH40ZupSx9hRADhsIdeXdBfy',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 4,
            ),
            6 => 
            array (
                'id' => 7,
                'user_code' => '3fc94bad-4622-4bb6-a263-9da3cb011998',
                'name' => 'Dedi Setiawan, A.Md',
                'email' => 'stafftu1@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$HJJCTyORiZyVxtrDVsJxTOgIcMYhlUeBuXIlfmIZBYty6ykAr/rK.',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 5,
            ),
            7 => 
            array (
                'id' => 8,
                'user_code' => '4144ffe9-efbd-4c80-b070-771a9237a2b1',
                'name' => 'Nurul Hidayati',
                'email' => 'stafftu2@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$HnluqZ38TE.TQ15INJNOxOscNnJK92s.w2u9t.NM6S6zEDKAgwsRW',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 5,
            ),
            8 => 
            array (
                'id' => 9,
                'user_code' => '37bdaa1c-0adc-4ae6-905f-efe8ab622a7d',
                'name' => 'Fajar Operator',
                'email' => 'operator@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$/.uGTgCqg66yVJQR60Vo8.HKU6rKVyvV1K62cMAbhdTtqr0DeaGzu',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 6,
            ),
            9 => 
            array (
                'id' => 10,
                'user_code' => 'a28bf116-32f8-407f-9b99-50930a48bf4c',
                'name' => 'Siti Nonaktif',
                'email' => 'nonaktif@cerdas-in.id',
                'email_verified_at' => NULL,
                'password' => '$2y$12$yUXSyNK5dyMdKe79LYIe/uRDAtJj7MGVseeu0fEs8vRnXzxcuomoG',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 0,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
                'role_id' => 6,
            ),
            10 => 
            array (
                'id' => 11,
                'user_code' => '2cc058bb-1018-4e6a-931f-73c697133a8f',
                'name' => 'Agustina Wahyuni, S.Pd',
                'email' => 'agustina.wahyuni02@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$i4PGvvKSdZfRWNDwq4p5xe/N.ndHGsAfcv7iuqSC109T0vO4LTXmy',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 02:03:01',
                'updated_at' => '2026-04-15 02:03:01',
                'role_id' => 4,
            ),
            11 => 
            array (
                'id' => 12,
                'user_code' => '286135b0-04a2-4933-ab2b-f726a744112e',
                'name' => 'Sukarno, S.Pd',
                'email' => 'sukarno1945@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$HSWtgnUjhMuGN0B5Y3rbhu9YabZultYVfte8YXFtineTS3lbo63yu',
                'remember_token' => NULL,
                'last_login' => NULL,
                'is_active' => 1,
                'created_at' => '2026-04-15 02:21:28',
                'updated_at' => '2026-04-15 02:21:28',
                'role_id' => 4,
            ),
        ));
        
        
    }
}