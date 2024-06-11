<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body style="background-color: lightblue;">
    <div class="container">

        <h2 style="margin-top : 5rem ; text-align:center;" >Sign Up for Account</h2>
        <form action="/register" method="POST">
            @csrf
            <div style="background-color:green;">
                @if(Session::get('success'))
                <div style="color:black; margin: 1rem; ">
                    {{Session::get('success')}}
                </div>
                @endif
                
                @if(Session::get('Fail'))
                <div style="color: red;">
                    {{Session::get('Fail')}}
                </div>
                @endif
            </div>
            <div class="input-group mb-3" style="margin-top : 5rem ;">
                <label class="input-group-text" for="inputGroupSelect01">Name</label>
                <select class="form-select" id="inputGroupSelect01">
                  <option selected>select your name</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
            
            
            <div class="form-group" style="margin-top : 2rem ;">
                <label for="radiobutton"> Log Type:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="account_type" id="inlineRadio1" value="Invidual">
                    <label class="form-check-label" for="inlineRadio1">login</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="account_type" id="inlineRadio2" value="Business">
                    <label class="form-check-label" for="inlineRadio2">logout</label>
                </div>
                
            </div>
            
            
            <button type="submit" class="btn btn-primary" style="margin-top : 3rem ;">Submit</button>
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>