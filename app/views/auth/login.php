<div class="container text-center">
<h2>Login</h2>

<div class="row justify-content-center">
<div class="forms col-8">

<?php if (!empty($error)) echo '<p style="color:red;">' . $error . "</p>"; ?>
<form action="?controller=auth&action=doLogin" method="post">
    <input class="mb-3" type="email" name="email" placeholder="E-Mail" required>
    <input class="mb-3" type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<a href="?controller=auth&action=register">No Account? Register now!</a>
</div>
</div>
</div>