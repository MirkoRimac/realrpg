<h2>Create an Account</h2>

<form action="?controller=auth&action=doRegister" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="E-Mail" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Create Account</button>
</form>

<a href="?controller=auth&action=login">Back to login</a>