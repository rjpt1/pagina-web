@extends('layout')

@section('title', "Crear usuario")

@section('content')
    <h1>Crear nuevo usuario</h1>
    <!-- @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif -->
    <form class="" action="{{ url('usuarios/crear') }}" method="post">
      {!! csrf_field() !!}
      <label for="name">Nombres:</label>
      <input type="text" name="name" id="name" value="{{ old('name') }}"><br>
      @if($errors->has('name'))

          <p>{{ $errors->first('name') }}</p>

      @endif
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" value="{{ old('email') }}"><br>
      @if($errors->has('email'))
        <p>{{ $errors->first('email') }}</p>
      @endif
      <label for="password">Contraseña:</label>
      <input type="password" name="password" id="password"><br>
      <label for="profession_id">Profesión:</label>


      <select id="profession_id" name="profession_id">
        @foreach($prof as $profesion)
        <option value="{{ $profesion->id }}" name="id">{{  $profesion->title }}</option>
        @endforeach
		</select><br>
       <!--<input type="text" name="profession_id" value=""> -->
      <button type="submit" name="button">Crear usuario</button>

    </form>

    

@endsection

<style media="screen">
  p {color:red;}
</style>
