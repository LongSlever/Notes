@extends('layouts.main_layout')

@section('content')

   <h1>Essa é uma view com uma integração de layout</h1>
        <p>
            Usamos o section pra definir o que vai aparecer no layout e o yield no próprio layout
        </p>

        <hr>
    <h3> O valor é {{$value}}</h3>

@endsection
