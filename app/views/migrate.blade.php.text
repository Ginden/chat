@extends('layouts.master')

@section('content')
    
{{ Form::open(array('url' => 'migrate')) }}

            <input                              type="hidden" class="dnone"
                name="unique_key" value="{{ Session::get('unique_key') }}" />
            <input placeholder="email (opcjonalny)"         type="text" name="mail">
            <input placeholder="hasło"          type="password" name="password">
            <input placeholder="powtórz hasło"  type="password" name="password_repeat">
        </fieldset>
    </div>
    <input id="login_button" type="submit" text="zmień dane dostępowe" value="zmień dane dostępowe">
{{ Form::close() }}

@stop