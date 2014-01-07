<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        {{ $channel->name or $title}} - {{UI::APP_NAME}}
    </title>
    <link rel="stylesheet" type="text/css" href="{{UI::APP_CDN}}css/style.css">
    <link rel="stylesheet" type="text/css" id="jquery_ui_theme">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{UI::APP_CDN}}images/favicons/{{$channel->favicon or 'default.png'}}">
    <style id="black_list" type="text/css"></style>
    <style id="mod_search" type="text/css"></style>
    <script src="{{UI::APP_CDN}}js/{{UI::APP_baseJS}}"></script>
    <script>
        var BASE_URL = '{{ UI::APP_BASE }}';
        var CDN_URL =  '{{ UI::APP_CDN  }}';
    </script>
</head>

<body>
    <div class="site dnone" id="site">
        <div class="banner"></div>
        <div class="menu">
            @include('menu')
        </div>
        <div class="content">
            @if (Session::has('error'))
                <div class="error">
                    {{Session::get('error')}}
                </div>
            @endif
            @if (Session::has('message'))
                <div class="message">
                    {{Session::get('message')}}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
        
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33776829-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</div>
</body>
</html>