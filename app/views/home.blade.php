@extends('layouts.master')

@section('content')
    Zalogowałeś się poprawnie. Gratulacje. Zobacz <a href="{{ route('channels.list') }}">listę kanałów</a>.
@stop