@extends('layout')

@section('title', "Usuarios")

@section('content')
    <h1>{{$title}}</h1>
    <a href="{{ url('/usuarios/nuevo') }}" class="btn btn-dark">Crear Usuario</a>

    <!-- <ul>
      @forelse ($users as $user)
      <li>{{$user->id}}. {{$user->name}}</li>
      @empty
      <p>No hay usuarios registrados</p>
      @endforelse
    </ul> -->
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>IDDB</th>
            <th>NOMBRES</th>
            <th>CORREO ELECTRÓNICO</th>
            <!-- <th>PROFESIÓN</th> -->
            <th>ACCIONES</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
          <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>

            <td>
              <!-- <a href="{{ url('/usuarios/'.$user->id) }}" class="btn btn-info">ver detalles</a> -->
              <div class="btn-group btn-group-toggle">
                <a href="{{ route('users.show', ['id' => $user]) }}" class="btn btn-primary">Ver detalles</a>
                <a href="{{ route('users.edit', ['id' => $user]) }}" class="btn btn-info">Editar</a>
                <form class="" action="{{ route('users.delete', $user) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-danger" name="button">Eliminar</button>
                </form>
              </div>
              <!-- <a href="{{ action('UserController@index') }}">Regresar al listado de usuarios</a> -->
            </td>
          </tr>
          @empty
          <p>No hay usuarios registrados</p>
          @endforelse
        </tbody>
      </table>

@endsection
