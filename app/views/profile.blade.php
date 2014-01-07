@extends('layouts.master')

@section('content')
    Profil użytkownika.
    <?php
        echo json_encode($user);
    ?>
@stop