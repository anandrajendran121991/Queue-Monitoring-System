<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <style>
        .help-block{
            color: red;
        }
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">User</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="/horizon">Horizon</a></li>
    </ul>
  </div>
</nav>

@if(Session::has('error'))
<div class="alert alert-danger">
    <strong>Danger!</strong> {{Session::get('error')}}
</div>
@endif

<div class="container">
  <h2>Create User</h2>
  <form action="/store" method='post'>
  @csrf
  <div class="form-group">
      <label for="pwd">First Name:</label>
      <input type="text" class="form-control" placeholder="Enter First Name" name="first_name">
      <span class="help-block">{!! $errors->create_user_form->first('first_name') !!}</span>
    </div>
    <div class="form-group">
      <label for="pwd">Last Name:</label>
      <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name">
      <span class="help-block">{!! $errors->create_user_form->first('last_name') !!}</span>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" placeholder="Enter email" name="email">
      <span class="help-block">{!! $errors->create_user_form->first('email') !!}</span>
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
