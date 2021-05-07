<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>

<body class="antialiased">
    <header>
        <div>
            <a href="/register">Registracija</a>
            <a href="/login">Prijava</a>
            <a href="/logout">Odjava</a>
            <a href="/tasks">Lista radova</a>
            <a href="/users">Korisnici</a>
            <a href="/create-task">Dodaj rad</a>
        </div>
    </header>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Naziv na engleskom</th>
                    <th>Studijski program</th>
                    @if($role == 'teacher') <th>Izabrao</th> @endif
                    <th>Prijava</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{$task->title}}</td>
                    <td>{{$task->title_en}}</td>
                    <td>{{$task->study_type}}</td>
                    @if($role == 'teacher') <td> @if($task->student){{$task->student->name}} @endif</td> @endif
                    <td>
                        @if($role == 'student')<a href="/apply/{{$task->id}}">Prijava</a> @endif
                        @if($role == 'teacher')<a href="/applicants/{{$task->id}}">Prijave</a>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>