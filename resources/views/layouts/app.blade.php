<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Package Price Calculator</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="stylesheet" href="{{asset("css/bootstrap.css")  }}">
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")  }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="{{asset("css/sidebars.css")  }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset("css/datatable.css") }}">

    @yield("css")

    <link rel="stylesheet" href="{{asset("css/style.css")  }}">
</head>

<body class="vh-100">
    @yield("content")


    <script src="{{asset("js/sidebars.js")  }}"></script>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset("js/custom.js") }}"></script>
    <script src="{{ asset("js/formatter.js") }}"></script>
    <script src="{{ asset("js/modal.js") }}"></script>
    @yield("script")
</body>

</html>