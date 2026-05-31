<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Quiz System</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            max-width:1000px;
            margin:40px auto;
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table,th,td{
            border:1px solid #ddd;
        }

        th,td{
            padding:10px;
        }

        .btn{
            padding:8px 12px;
            text-decoration:none;
            border:1px solid #ccc;
            cursor:pointer;
        }

        .success{
            color:green;
            margin-bottom:15px;
        }
    </style>
</head>
<body>

<h1>Dynamic Quiz System</h1>

@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

@yield('content')

</body>
</html>