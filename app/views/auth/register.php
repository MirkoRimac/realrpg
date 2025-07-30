<div class="container text-center">
<h2>Create an Account</h2>

<div class="row justify-content-center">
    <div class="forms col-8">
<form action="?controller=auth&action=doRegister" method="post">
    <input class="mb-3" type="text" name="username" placeholder="Username" required>
    <input class="mb-3" type="email" name="email" placeholder="E-Mail" required>
    <input class="mb-3" type="password" name="password" placeholder="Password" required>
    <button type="submit">Create Account</button>
</form>

<a href="?controller=auth&action=login">Back to login</a>

    </div>
</div>
</div>