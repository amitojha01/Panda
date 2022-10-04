<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('email', '!=', '')->delete();
        User::insert(array(
            0 =>   array(
                    'role_id'=> '0',
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('secret'),
            ),
            1=>   array(
                    'role_id'=> '1',
                    'name' => 'Test User',
                    'email' => 'c@gmail.com',
                    'password' => Hash::make('secret'),
            )
        )
        );
    }
}
