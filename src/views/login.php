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
        <h3 class="login__title">LOGIN</h3>
        <div class="login__logo">
            <img src="/public/logo.png">
        </div>
    </div>
    <?php if($data['error']): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $data['error'] ?>
        </div>
    <?php endif ?>
    <form class="login__body" method='POST' action='/login'>
        <div class="form-group">
            <label>Email</label>
            <input name='email' type='email' required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input name='password' type='password' required>
        </div>
        <button type="submit">LOGIN</button>
    </form>
    <div class="login__footer">
        <div class="signup">Don't have account? <a href="/signup" class="btn-signup">Sign up</a></div>
    </div>
</div>
</body>
</html>
