<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profession = DB::table('professions')
        ->select('id')
        ->where(['title' => 'Desarrollador backend'])
        ->first();

        DB::table('users')->insert([
          'name' => 'Pepito Perez',
          'email' => 'pepe@aol.com',
          'password' => bcrypt('123'),
          'profession_id' => $profession->id,
        ]);

        $professionId = Profession::where('title','Administrador')->value('id');
        User::create([
          'name' => 'Ana Perez',
          'email' => 'ava@aol.com',
          'password' => bcrypt('123'),
          'profession_id' => $professionId,
        ]);

        factory(User::class,24)->create();
    }
}
