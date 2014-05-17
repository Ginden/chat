@extends('layouts.master')

@section('content')
    
{{ Form::open(array('url' => 'login-data')) }}

    <input type="radio" class="dnone" name="login_type" id="xyz" value="key" checked />
    <input type="radio" class="dnone" name="login_type" id="abc" value="password" />
    <div class="tabs">
        <ul class="mini-menu">
                <li>
                    <a id="q" href="#tabs-1">logowanie kluczem</a>
                </li>
                <li>
                    <a id="t" href="#tabs-2">logowanie hasłem</a>
                </li>
            </ul>
        <fieldset id="tabs-1">
            Twój tajny klucz<br>
            <input type="text" id="keybox" name="unique_key">
            <br>
                <button class="button" id="save-key">zapisz</button>
                <button class="button" id="restore-key">przywróć</button><br>
        </fieldset>
        <fieldset id="tabs-2">
            <input placeholder="nick" type="text" id="keybox" name="nick">
            <input placeholder="hasło" type="password" id="keybox" name="password">
        </fieldset>
    </div>
    <input id="login_button" type="submit" text="zaloguj się" value="zaloguj się">
{{ Form::close() }}
     <script>
        $(function() {
            $( ".tabs" ).tabs();
            $('#q').click(function(){
                $('#xyz').prop('checked', true);
                return true;
            });
            $('#t').click(function(){
                $('#abc').prop('checked', true);
                return true;
            });
        });
     </script>
@stop