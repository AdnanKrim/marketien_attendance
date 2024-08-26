<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Sheet</title>
    <style>
        .htmlBody {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to left, #0e859d, #04505f)
        }

        .invoice-box {
            width: 20cm;
            height: 29.7cm;
            margin: 0;
            font-family: "Open Sans", sans-serif;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 20px;
            border-bottom: 2px solid #0e859d;
            padding-bottom: 10px;
        }

        h2 {
            color: #555;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #0e859d;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        .table-container {
            overflow-x: auto;

        }

        .title-section {
            display: flex;
            justify-content: space-between;
        }

        .signature-section {
            position: absolute;
            text-align: center;
            bottom: 30px;
            right: 20px;
        }

        hr {
            width: 200px;
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
        }

        .submit-button:hover {
            background: linear-gradient(to bottom, #3bb890, #114070);
        }

        .invoice-footer {
            display: flex;
            justify-content: center;
        }
    </style>

</head>

<body>
    <div class="htmlBody">

        <div class="invoice-box" id="container_content">
            <h1>Attendance Sheet for {{ $month }}</h1>
            {{-- <h2>Name:{{$employee->name}} </h2>
            <h2>Id: {{$employee->employee_id}}</h2> --}}
            <div class="title-section">
                <span>
                    <h2>Name:{{ $employee->name }}</h2>
                    <h2>Id:{{ $employee->employee_id }}</h2>
                </span>
                <span>
                    <h2>Issue Date:{{$issue_date}} </h2>
                </span>
            </div>
            <div class="table-container">
                <table id="myTable">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Login Time</th>
                            <th>Login Delay</th>
                            <th>Logout Time</th>
                            <th>Logout Early</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendance as $attend)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attend['date'] }}</td>
                                <td>{{ $attend['weekday'] }}</td>
                                <td>{{ $attend['login'] }}</td>
                                <td>{{ $attend['login_delay'] }}</td>
                                <td>{{ $attend['logout'] }}</td>
                                <td>{{ $attend['logout_early'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="signature-section">
                <span>
                    <hr>
                    <p>Authority Signature</p>
                </span>
                </span>
            </div>
        </div>
    </div>
    <div class="invoice-footer">
        <input type="button" id="rep" value="Make PDF" class="submit-button btn_print">
        <button id="downloadexcel" class="submit-button ">Convert to Excel</button>
    </div>
</body>
{{-- <script src="js/table2excel.js"></script> --}}
<script src="{{ asset('js/table2excel.js') }}"></script>
<script>
    document.getElementById('downloadexcel').addEventListener('click', function() {
        var table2excel = new Table2Excel();
        table2excel.export(document.querySelectorAll("#myTable"));
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready(function($) {

        $(document).on('click', '.btn_print', function(event) {
            event.preventDefault();

            //credit : https://ekoopmans.github.io/html2pdf.js

            var element = document.getElementById('container_content');

            //easy
            // html2pdf().from(element).save();

            //custom file name
            html2pdf().set({
                filename: 'attendance_' + '{{ $employee->name }}_' + '{{ $month }}' +
                    '.pdf'
            }).from(element).save();


            //more custom settings
            // var opt = {
            //     margin: 1,
            //     filename: 'pageContent_' + js.AutoCode() + '.pdf',
            //     image: {
            //         type: 'jpeg',
            //         quality: 0.98
            //     },
            //     html2canvas: {
            //         scale: 2
            //     },
            //     jsPDF: {
            //         unit: 'in',
            //         format: 'letter',
            //         orientation: 'portrait'
            //     }
            // };

            // New Promise-based usage:
            // html2pdf().set(opt).from(element).save();


        });



    });
</script>

</html>
