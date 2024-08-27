<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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

        .row>.col {
            padding: 10px;
        }

        .submit-button {
            display: block;
            width: 20%;
            padding: 10px;
            background: linear-gradient(to top, #3bb890, #114070);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
        }

        .submit-button:hover {
            background: linear-gradient(to bottom, #3bb890, #114070);
        }

        .invoice-footer{
            display: flex;
            justify-content: start;

        }
    </style>
</head>

<body>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="/admin">Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/attendance">Attendance</a>
            </li>
        </ul>
    </div>
    <div class="content">
        {{-- <button class="btn btn-danger logout-btn">Logout</button> --}}
        <a class="btn btn-danger logout-btn" href="/logout">Logout</a>
        <h2>Attendance List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>LogType</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>EmployeeName</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $detail->log_type }}</td>
                        <td>{{ $detail->date }}</td>
                        <td>{{ $detail->time }}</td>
                        <?php
                        $employee = \App\Models\Employee::where('id', $detail->user_id)->first();
                        ?>
                        <td>{{ $employee->name }}</td>
                        {{-- @if ($detail->log_type === 'login')
                    <td>{{$detail->entry_late." minutes late"}}</td>
                    @endif
                    @if ($detail->log_type === 'logout')
                    <td>{{$detail->leave_early. " minutes early"}}</td>
                    @endif --}}
                    </tr>
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        {{ $details->links() }}

        <div class="row">
            <div class="col">
                <h2>Login Detail</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th>Entry_Late</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                            @if ($detail->log_type === 'login')
                                <tr>
                                    <td>{{ $detail->date }}</td>
                                    <td>{{ $detail->entry_late . ' minutes late' }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h2>Logout Detail</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th>Leave_Early</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                            @if ($detail->log_type === 'logout')
                                <tr>
                                    <td>{{ $detail->date }}</td>
                                    <td>{{ $detail->leave_early . ' minutes early' }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="invoice-footer">
            @php
                use Carbon\Carbon;
                $this_month = Carbon::now()->format('m');
                $prev_month = Carbon::now()->subMonth()->format('m');
            @endphp
            <a id="rep" href="/excel-sheet/{{ $employee_id }}/{{$prev_month}}" class="submit-button"> Detail In
                Prev. Month </a>
            <a id="rep" href="/excel-sheet/{{ $employee_id }}/{{$this_month}}" class="submit-button" style="margin-left: 2px;"> Detail In
                This Month </a>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
