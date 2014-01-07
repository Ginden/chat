@extends('layouts.master')

@section('content')
    
<script>
    var currentUser = {{ ChatAuth::user()->toJson() }};
    window['channel'] = {{$channel->id}};
    window['access_level'] = {{$accessLevel}};
</script>
<?php
    Session::put('counter', Session::get('counter', 0)+1);
?>
<div id="chat"></div>

<script src="{{UI::APP_CDN}}js/chat.js"></script>
    
@stop