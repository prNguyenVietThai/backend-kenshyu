<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./public/css/reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/auth.css">
</head>
<body>
<div class="login">
    <div class="login__header">
        <h3 class="login__title">SIGN UP</h3>
        <div class="login__logo" >
            <img src="https://picsum.photos/id/237/200">
        </div>
    </div>
    <?php if($data['error']): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $data['error'] ?>
        </div>
    <?php elseif($data['signup_success']): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $data['signup_success'] ?>
            <a href="/login" class="login-btn">Login now!</a>
        </div>
    <?php endif ?>
    <form class="login__body" method='POST' action='/signup'>
        <div class="form-group">
            <label>Your name</label>
            <input name='name' type='name'>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input name='email' type='email'>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input name='password' type='password'>
        </div>
        <div class="form-group">
            <label>Confirm</label>
            <input name='confirm' type='password'>
        </div>
        <button type="submit">Sign up</button>
    </form>
    <div class="login__footer">
        <div class="signup">Do you haved account? <a class="btn-signup" href="/login">Login now</a></div>
    </div>
</div>
</body>
</html>

