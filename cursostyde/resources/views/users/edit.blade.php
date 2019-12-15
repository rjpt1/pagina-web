@extends('layout')

@section('title', "Editar usuario")

@section('content')
    <h1>Editar usuario</h1>
    <!-- @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif -->
    <form class="" action="{{ url("usuarios/{$user->id}") }}" method="post">
      {{ method_field('PUT')}}
      {!! csrf_field() !!}
      <label for="name">Nombres:</label>
      <input type="text" name="name" for="name" value="{{ old('name', $user->name) }}"><br>
      @if($errors->has('name'))

          <p>{{ $errors->first('name') }}</p>

      @endif
      <label for="email">E-mail:</label>
      <input type="email" name="email" for="email" value="{{ old('email', $user->email) }}"><br>
      @if($errors->has('email'))
        <p>{{ $errors->first('email') }}</p>
      @endif
      <label for="password">Contraseña:</label>
      <input type="password" name="password" for="password"><br>
      @if($errors->has('password'))
        <p>{{ $errors->first('password') }}</p>
      @endif
      <label for="profession_id">Profesión:</label>

      <select name="profession_id" >
        @foreach($profession as $profesion)
          <option value="{{ old('profession_id', $user->profession_id) }}" >{{  $profesion->title }} </option>
        @endforeach
      </select><br>
      <button type="submit" name="button">Actualizar usuario</button>
    </form>

@endsection

<style media="screen">
  p {color:red;}
</style>
