<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Customer</h1>

        <!-- Form for editing customer -->
        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="first_name" class="font-weight-bold">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $customer->first_name }}" required>
            </div>
            <div class="form-group">
                <label for="last_name" class="font-weight-bold">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customer->last_name }}" required>
            </div>
            <div class="form-group">
                <label for="age" class="font-weight-bold">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="{{ $customer->age }}" required>
            </div>
            <div class="form-group">
                <label for="dob" class="font-weight-bold">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{ $customer->dob }}" required>
            </div>
            <div class="form-group">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">Update Customer</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
