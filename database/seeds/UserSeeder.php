<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $user_maarten = new User([
                                     'name' => 'Maarten',
                                     'email' => 'maarten.dejager@visma.com',
                                     'address' => 'Richard Holkade 9, 2033 PZ Haarlem',
                                     'password' => Hash::make('password'),
                                     'email_verified_at' => date('Y-m-d H:i:s'),
                                 ]);
        $user_maarten->save();
    }
}
