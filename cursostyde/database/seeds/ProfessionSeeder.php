<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('professions')->insert([
        'title' => 'Desarrollador backend'
      ]);

      DB::table('professions')->insert([
        'title' => 'Desarrollador frontend'
      ]);

      //DB::insert('INSERT INTO professions (title) VALUES (:title)', ['title' => 'Presidente']);
      DB::delete('delete from professions where title = ?', ['Presidente']);

      Profession::create([
        'title' => 'Administrador',
      ]);

      factory(Profession::class,7)->create();
    }
}
