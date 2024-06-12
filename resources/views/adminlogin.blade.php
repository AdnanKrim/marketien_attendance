<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card" style="margin-top: 3rem;">
                    <div class="card-header">Admin Login only</div>
                    <div class="card-body" style="">
                        <img src="images/Marketien-Logo.png" class="img
                        " alt="">
                        <form action="/check" method="POST">
                            @csrf
                            <div style="background-color:green;">
                                @if (Session::get('success'))
                                    <div style="color:black; margin: 1rem; ">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                @if (Session::get('fail'))
                                    <div style="color: red;">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">

                            </div>
                            



                            <div style="display:flex ; justify-content:center; margin-top: 3rem ;">

                                <button type="submit" class="btn btn-primary" style=""
                                    class="btn">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
