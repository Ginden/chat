@extends('layouts.master')

@section('content')
    
    <h2>Ostatni tydzień</h2>
    <table style="min-width: 500px; text-align: center;">
    <tr><th>Użytkownik</th><th>Liczba wiadomości</th></tr>
    @foreach ($rank as $row)
        <tr>
            <td>
                {{$row->name}}
            </td>
            <td>
                {{$row->messages}}
            </td>
        </tr>
    
    @endforeach
    </table>
    
@stop