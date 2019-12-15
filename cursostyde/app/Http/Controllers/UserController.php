<?php

namespace App\Http\Controllers;

use App\User;
use App\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){

      $users = User::all();
      //$users = DB::table('users')->get();
      //dd($users);
      return view('users.index', [
        'users' => $users,
        'title' => 'Listado de Usuarios'
      ]);
    }

    //mostrar detalles de un usuarios
    public function show(User $user){
      return view('users.show',compact('user'));
    }

    // public function show($id){
    //   $user = User::findOrFail($id);
    //   // $user = User::find($id);
    //   //
    //   // if ($user == null) {
    //   //   return response()->view('errors.404', [], 404);
    //   // }
    //   return view('users.show',compact('user'));
    // }

    public function create(){
      $prof = Profession::all();
	  return view('users.create', compact('prof'));
    }

    // public function edit($id){
    //   return view('users.editar',[
    //     'id' => $id,
    //   ]);
    // }

    public function practica(){
      return view('users.practicandovista');
    }

    public function store(){
      //$data = request()->all();
      $data = request()->validate([
        'profession_id' =>'required',
        'name' => 'required',
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => 'required',
      ], [
        'name.required' => 'El campo nombre es obligatorio',
        'email.unique' => 'El correo ya esta registrado en el sistema',
      ]);

      if (empty($data['name'])) {
        return redirect('usuarios/nuevo')->withErrors([
          'name' => 'El campo nombre es obligatorio'
        ]);
      }

      //dd($data);

      User::create([
        'profession_id' => $data['profession_id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
      ]);

      //dd($j);//$j va a ser igual a User::create para ver lo que va a crear y los datos

      return redirect()->route('users.index');
    }

    public function edit(User $user){
      $prof = Profession::all();
      return view('users.edit', [
        'user' => $user,
        'profession' => $prof,
      ]);
    }

    public function update(User $user){
      $data = request()->validate([
        'name' => 'required',
        //'email' => ['required', 'email', 'unique:users,email,'.$user->id],
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'password' => '',
      ], [
        'name.required' => 'El campo nombre es obligatorio',
      ]);

      if ($data['password'] != null){
        $data['password'] = bcrypt($data['password']);
      }
      else{
        unset($data['password']);
      }

      $user->update($data);

      return redirect("usuarios/{$user->id}");
    }

    public function destroy(User $user){

      $user->delete();

      return redirect()->route('users.index');
    }
}
