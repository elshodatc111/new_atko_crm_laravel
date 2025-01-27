<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="{{ env('HTTP_URL')}}assets/img/logo.png" rel="icon">
  <link href="{{ env('HTTP_URL')}}assets/img/logo.png" rel="apple-touch-icon">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="{{ env('HTTP_URL')}}assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="{{ env('HTTP_URL')}}assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{ env('HTTP_URL')}}assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{ env('HTTP_URL')}}assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{ env('HTTP_URL')}}assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{ env('HTTP_URL')}}assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="{{ env('HTTP_URL')}}assets/css/style.css" rel="stylesheet">
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('Techer') }}" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block w-100 text-center">MyCrm</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle" class="rounded-circle" style="font-size: 30px;"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span class="text-success">{{ Auth::user()->email }}</span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('TKabinet') }}"><i class="bi bi-person"></i><span>Kabinet</span></a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i><span>Chiqish</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
  
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('Techer') }}"><i class="bi bi-grid"></i><span>Bosh sahifa</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('TGuruhlar') }}"><i class="bi bi-columns"></i><span>Guruhlarim</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('TTolovlar') }}"><i class="bi bi-coin"></i><span>To'lovlar</span></a>
            </li>
        </ul>
    </aside>
  
    @yield('content')
  
    <footer id="footer" class="footer">
        <div class="copyright">
            <img src="{{ env('HTTP_URL')}}assets/img/logo.png" style="width:18px;"> <strong> <span> CodeStart</span></strong> Development Center
        </div>
    </footer>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/quill/quill.min.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/vendor/php-email-form/validate.js"></script>
  <script src="https://atko.tech/NiceAdmin/assets/js/main.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
  <script>
    $(".phone").inputmask("99 999 9999");
    (function($, undefined) {
        "use strict";
        $(function() {
            var $form1 = $( "#form1" );
            var $form2 = $( "#form2" );
            var $form3 = $( "#form3" );
            var $form4 = $( "#form4" );
            var $input1 = $form1.find( "#summa1" );
            var $input2 = $form1.find( "#summa2" );
            var $input3 = $form1.find( "#summa3" );
            var $input11 = $form2.find( "#summa1" );
            var $input22 = $form2.find( "#summa2" );
            var $input33 = $form2.find( "#summa3" );
            var $input111 = $form3.find( "#summa1" );
            var $input222 = $form3.find( "#summa2" );
            var $input333 = $form3.find( "#summa3" );
            var $input1111 = $form4.find( "#summa1" );
            var $input2222 = $form4.find( "#summa2" );
            var $input3333 = $form4.find( "#summa3" );
            $input1.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input1 = $this.val();
                var input1 = input1.replace(/[\D\s\._\-]+/g, "");
                input1 = input1 ? parseInt( input1, 10 ) : 0;
                $this.val( function() {return ( input1 === 0 ) ? "0" : input1.toLocaleString( "en-US" );} );
            } );
            $input2.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input2 = $this.val();
                var input2 = input2.replace(/[\D\s\._\-]+/g, "");
                input2 = input2 ? parseInt( input2, 10 ) : 0;
                $this.val( function() {return ( input2 === 0 ) ? "0" : input2.toLocaleString( "en-US" );} );
            } );
            $input3.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input3 = $this.val();
                var input3 = input3.replace(/[\D\s\._\-]+/g, "");
                input3 = input3 ? parseInt( input3, 10 ) : 0;
                $this.val( function() {return ( input3 === 0 ) ? "0" : input3.toLocaleString( "en-US" );} );
            } );
            $input11.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input11 = $this.val();
                var input11 = input11.replace(/[\D\s\._\-]+/g, "");
                input11 = input11 ? parseInt( input11, 10 ) : 0;
                $this.val( function() {return ( input11 === 0 ) ? "0" : input11.toLocaleString( "en-US" );} );
            } );
            $input22.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input22 = $this.val();
                var input22 = input22.replace(/[\D\s\._\-]+/g, "");
                input22 = input22 ? parseInt( input22, 10 ) : 0;
                $this.val( function() {return ( input22 === 0 ) ? "0" : input22.toLocaleString( "en-US" );} );
            } );
            $input33.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input33 = $this.val();
                var input33 = input33.replace(/[\D\s\._\-]+/g, "");
                input33 = input33 ? parseInt( input33, 10 ) : 0;
                $this.val( function() {return ( input33 === 0 ) ? "0" : input33.toLocaleString( "en-US" );} );
            } );
            $input1111.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input1111 = $this.val();
                var input1111 = input1111.replace(/[\D\s\._\-]+/g, "");
                input1111 = input1111 ? parseInt( input1111, 10 ) : 0;
                $this.val( function() {return ( input1111 === 0 ) ? "0" : input1111.toLocaleString( "en-US" );} );
            } );
            $input2222.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input2222 = $this.val();
                var input2222 = input2222.replace(/[\D\s\._\-]+/g, "");
                input2222 = input2222 ? parseInt( input2222, 10 ) : 0;
                $this.val( function() {return ( input2222 === 0 ) ? "0" : input2222.toLocaleString( "en-US" );} );
            } );
            $input3333.on( "keyup", function( event ) {
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {return;}
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {return;}
                var $this = $( this );
                var input3333 = $this.val();
                var input3333 = input3333.replace(/[\D\s\._\-]+/g, "");
                input3333 = input3333 ? parseInt( input3333, 10 ) : 0;
                $this.val( function() {return ( input3333 === 0 ) ? "0" : input3333.toLocaleString( "en-US" );} );
            } );
        });
    })(jQuery);
  </script>
</body>
</html>