<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Error</title>
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
    <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>Siz bu tizimdan foydalana olmaysiz. Mobile ilovadan foydalaning.</h2>
        <a class="btn" href="{{ route('home') }}">Back to home</a>
    </section>
</body>
</html>