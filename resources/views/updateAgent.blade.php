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
<style>
    label{
        color: black;
    }
</style>

<body>
    <div class="container">

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card" style="margin-top: 3rem;">
                    <div class="card-header">Employee Update Form</div>
                    <div class="card-body" style="">
                        <img src="images/Marketien-Logo.png" class="img
                        " alt="">
                        <form action="/update-agent" method="POST">
                            @csrf
                            <div style="background-color:green;">
                                @if (Session::get('success'))
                                    <div style="color:rgb(251, 248, 248); margin: 1rem; ">
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
                                <label for="exampleInputEmail1">Token</label>
                                <input type="text" name="token" class="form-control" placeholder="Enter token">
                                <span style="color:red;">@error('name'){{ $message }}@enderror</span>

                            </div>

                            <div class="input-group mb-3" style="margin : 1.5rem 0rem ;">
                                <label class="input-group-text" for="inputGroupSelect01">Name</label>
                                <select class="form-select" id="inputGroupSelect01" name="id">
                                    <option selected>select your name</option>
                                    @foreach ($names as $name)
                                        <option value="{{ $name->id }}">{{ $name->name }}</option>
                                    @endforeach

                                    {{-- <option value="2">Two</option>
                                    <option value="3">Three</option> --}}
                                </select>

                            </div>



                            <div style="display:flex ; justify-content:center; margin-top: 3rem ;">

                                <button type="submit" class="btn btn-primary" style=""
                                    class="btn">Update</button>
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
