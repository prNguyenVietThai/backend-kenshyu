<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./views/assets/css/reset.css">
    <link rel="stylesheet" href="./views/assets/css/login.css">
</head>
<body>
    <div class="login">
        <div class="login__header">
            <h3 class="login__title">LOGIN</h3>
            <div class="login__logo" >
                <img src="https://picsum.photos/id/237/200">
            </div>
        </div>
        <form class="login__body" method='POST' action='/prtimes/login'>
            <div class="form-group">
                <label>EMAIL</label>
                <input name='email' type='email'>
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <input name='password' type='password'>
            </div>
            <button type="submit">LOGIN</button>
        </form>
        <div class="login__footer">
            <div class="signup">Don't have account? <a href="/login" class="btn-signup">Sign up</a></div>
        </div>
    </div>
</body>
</html>
