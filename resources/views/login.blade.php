<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pharma CMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="{{ asset("js/app.js") }}" defer></script>
</head>
<body>
    <div class="container">
        {{-- <form action="" id="form_submit">
            <input class="form-control" type="text" name="name" id="name" placeholder="Name">
            <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone">
            <input class="form-control" type="text" name="email" id="email" placeholder="Email">
            <input class="form-control" type="password" name="password" id="password" placeholder="password">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="yes" id="remember_me">
                <label class="form-check-label" for="remember_me">
                    Remember me
                </label>
            </div>
            <button class="btn btn-submit">Submit</button>
        </form> --}}
        {{-- <div class="row">
            <form action="" id="registration_submit">
                <input type="hidden" name="_method" value="patch">
                <input class="form-control" type="text" name="user" id="user" placeholder="User">
                <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone">
                <input class="form-control" type="text" name="email" id="email" placeholder="Email">
                <input type="file" name="img" id="img">
                <input class="form-control" type="password" name="password" id="password" placeholder="password">
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="password">
            
                <button class="btn btn-submit">Submit</button>
            </form>
        </div> --}}

        {{-- <div class="row">
            <form action="" id="customer_submit">
                <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone">
                <input class="form-control" type="text" name="opening_balance" id="opening_balance" placeholder="Opening Balance">
                <button class="btn btn-submit">Submit</button>
            </form>
        </div> --}}

        <div class="row">
            <form action="" id="add_medicine">
                <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                <input class="form-control" type="text" name="measurement" id="measurement" placeholder="Measurement">
                <input class="form-control" type="text" name="unit" id="unit" placeholder="Unit">
                <input class="form-control" type="text" name="selling_price" id="selling_price" placeholder="Selling Price">
                <input class="form-control" type="text" name="unit_per_segment" id="unit_per_segment" placeholder="Unit Per Segment">
                <button class="btn btn-submit">Submit</button>
            </form>
        </div>
        {{-- <form action="" id="logout">
            <button class="btn">Logout</button>
        </form> --}}
    </div>
</body>

</html>