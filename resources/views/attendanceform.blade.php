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
                    <div class="card-header">Marketien Attendance Form</div>
                    <div class="card-body" style="">
                        <img src="images/Marketien-Logo.png" class="img
                        " alt="">
                        <form action="/get-attendance" method="POST">
                            @csrf
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
                            <div class="input-group mb-3" style="margin : 5rem 0rem ;">
                                <label class="input-group-text" for="inputGroupSelect01">Name</label>
                                <select class="form-select" id="inputGroupSelect01" name="name">
                                    <option selected>select your name</option>
                                    @foreach ($names as $name)
                                        <option value="{{ $name->name }}">{{ $name->name }}</option>
                                    @endforeach

                                    {{-- <option value="2">Two</option>
                                    <option value="3">Three</option> --}}
                                </select>
                                
                            </div>
                
                                <span style="color:red;">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>


                            <div class="form-group" style="margin : 2rem ;">
                                <label for="radiobutton" style="color: rgb(24, 24, 22); font-size: 30px"> Log
                                    Type:</label>
                                <div class="form-check form-check-inline" style="margin-left : 2rem ;">
                                    <input class="form-check-input" type="radio" name="log_type" id="inlineRadio1"
                                        value="login">
                                    <label class="form-check-label" for="inlineRadio1"
                                        style="color: rgb(30, 30, 23); font-size: 20px">login</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="log_type" id="inlineRadio2"
                                        value="logout">
                                    <label class="form-check-label" for="inlineRadio2"
                                        style="color: rgb(26, 26, 22); font-size: 20px">logout</label>
                                </div>
                                
                            </div>
                            <span style="color:red;">
                                @error('log_type')
                                    {{ $message }}
                                @enderror
                            </span>

                            <div style="display:flex ; justify-content:center;">

                                <button type="submit" class="btn btn-primary" style=""
                                    class="btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div style="display:flex ; justify-content:center; margin-top: 5rem ;">

            
            <a href="/register" class="btn btn-secondary">Registration</a>
        </div> --}}
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
