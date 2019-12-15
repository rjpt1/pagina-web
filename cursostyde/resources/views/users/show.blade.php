{{--
@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <h1>Usuario #{{ $user->id }}</h1>

    Mostrando detalle del usuario: {{ $user->id }}<br>
    Nombre: {{ $user->name }}<br>
    Correo Electrónico: {{ $user->email }}<br>
    Profesión: @if($user->profession_id == null)No tiene profesión.@else{{ $user->profession->title }}@endif

    <p>
      <a href="{{ url('/usuarios') }}">Regresar con url</a><br>
      <a href="{{ action('UserController@index') }}">Regresar con action</a>
    </p>
@endsection
--}}

@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
<div class="card mx-auto d-block" style="width: 18rem;">
  @if($user->name == 'Cosme Fulanito')<img class="card-img-top" src="{{ asset('img/cos.jpeg') }}" alt="Fotografía">
  @else<img class="card-img-top" src="{{ asset('img/user.png') }}" alt="Fotografía">@endif
  <div class="card-body">
    <h1 class="card title">Usuario #{{ $user->id }}</h1>
    <p class="card-text">
      <ul>
        <li>Nombre: {{ $user->name }}</li>
        <li>Correo Electrónico: {{ $user->email }}</li>
        <li>Profesión: @if($user->profession_id == null)No tiene profesión.@else{{ $user->profession->title }}@endif</li>
      </ul>
    </p>
    {{--<a href="{{ url('/usuarios') }}">Regresar con url</a><br>--}}
    <a href="{{ action('UserController@index') }}" class="btn btn-info mx-auto d-block">Regresar</a>
  </div>
</div>
@endsection
