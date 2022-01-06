<!DOCTYPE html>
<html lang="en">
   <head>
    <title>WallArtEMall</title>
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ URL::asset('assets/stylesheets/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/stylesheets/style.bundle.css') }}" rel="stylesheet" type="text/css" />
  </head>

  <body id="kt_body" class="bg-body">
   


    @yield('content')
  

    <script src="{{ URL::asset('assets/javascript/plugins.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/javascript/scripts.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/javascript/general.jss') }}"></script>
    
  </body>
</html>