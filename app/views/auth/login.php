<h2>Login</h2>

<?php if (!empty($error)) echo '<p style="color:red;">' . $error . "</p>"; ?>
<form action="?controller=auth&action=doLogin" method="post">
    <input type="email" name="email" placeholder="E-Mail" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<a href="?controller=auth&action=register">No Account? Register now!</a>