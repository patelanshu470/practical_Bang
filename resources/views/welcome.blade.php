<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test Application</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Customer Form</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('store.customer') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="Customer name" name="name">
                @if ($errors->has('name'))
                    <div class="error">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="name@example.com" id="email" name="email">
                <span id="liveEmail" ></span>
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone</label>
                <input type="number" class="form-control" placeholder="Contact number" id="phone" name="phone">
                <span id="livePhone" ></span>

                @if ($errors->has('phone'))
                    <div class="error">{{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Address</label>
                <input type="text" class="form-control" placeholder="address" name="address">
                @if ($errors->has('address'))
                    <div class="error">{{ $errors->first('address') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Pincode</label>
                <input type="number" class="form-control" placeholder="pincode" name="pincode">
                @if ($errors->has('pincode'))
                    <div class="error">{{ $errors->first('pincode') }}</div>
                @endif
            </div>

            <div class="">
                <button type="submit" id="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</body>

{{-- attention:  --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
{{-- for email validation  --}}
<script>
    $(document).ready(function() {
        $('#email').on('keyup', function() {
            const email = $(this).val(); 
            event.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('dublicate.check') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email
                },
                dataType: 'json',
                success: function(data) {
                    if(data=="dublicate"){
                        $("#liveEmail").text('This email is already taken').css('color', 'red');
                        event.preventDefault();
                        $("#submit").prop("disabled", true);

                    }else{
                        $("#liveEmail").text('This email is available').css('color', 'green');
                        $("#submit").prop("disabled", false);

                    }
                  
                }
            });
        });
    });
</script>
{{-- for phone validation  --}}
<script>
    $(document).ready(function() {
        $('#phone').on('keyup', function() {
            const phone = $(this).val(); 
            event.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('dublicate.check') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "phone": phone
                },
                dataType: 'json',
                success: function(data) {
                    if(data=="dublicate"){
                        $("#livePhone").text('This phone number is already taken').css('color', 'red');
                        $("#submit").prop("disabled", true);
                    }else{
                        $("#livePhone").text('This phone number is available').css('color', 'green');
                        $("#submit").prop("disabled", false);
                    }
                  
                }
            });
        });
    });
</script>



</html>
