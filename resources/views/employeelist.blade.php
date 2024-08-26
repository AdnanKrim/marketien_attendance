<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=`, initial-scale=1.0">
    <title>Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- style section  -->
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .logout-btn {
            position: absolute;
            right: 20px;
            top: 20px;
        }
    </style>
</head>
<body>


    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/attendance">Attendance</a>
            </li>
        </ul>
    </div>
    <div class="content">
        <div style="background-color:green;">
            @if (Session::get('success'))
                <div style="color:black; margin: 1rem; ">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::get('fail'))
                <div style="color: rgb(238, 255, 0);">
                    {{ Session::get('fail') }}
                </div>
            @endif
        </div>
        {{-- <button class="btn btn-danger logout-btn">Logout</button> --}}
        <a class="btn btn-danger logout-btn" href="/logout">Logout</a>
        <h2>Employee List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>EmployeeId</th>
                    <th>EmployeeName</th>
                    <th>Login</th>
                    <th>Logout</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee as $emp)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$emp->employee_id}}</td>
                    <td>{{$emp->name}}</td>

                    @if($emp->present === 1)

                    <td><i style="color:green; font-size:24px" class="fa fa-check-circle"></i> </td>
                    {{-- <td style="color: green">Present</td> --}}
                    {{-- <td><i style="font-size:24px" class="fa">&#xf058;</i> </td> --}}
                    @elseif ($emp->present === null)
                    <td>New</td>
                    @else
                    <td><i class="fa fa-times-circle-o" style="color:red;font-size:24px"></i></td>
                    @endif

                    @if($emp->leave === 1)

                    <td><i style="color:green; font-size:24px" class="fa fa-check-circle"></i> </td>
                    @elseif ($emp->leave === null)
                    <td>New</td>
                    @else
                    <td><i class="fa fa-times-circle-o" style="color:red;font-size:24px"></i></td>
                    @endif

                    <td>
                        <a href="/detail/{{$emp['id']}}" class="btn btn-success btn-sm">
                            <i class="fa fa-edit">Details</i>
                        </a>
                        <a href="/delete/{{$emp['id']}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash">delete</i>
                        </a>

                    </td>

                </tr>
                @endforeach


                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
