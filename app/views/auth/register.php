<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
    <h2 class="text-center mb-4">Create an Account</h2>

    <?php if (!empty($error)) : ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="?controller=auth&action=doRegister" method="post">
      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="E-Mail" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Login</button>
    </form>

    <p class="text-center mt-3">
      <a href="?controller=auth&action=login">Back to login</a>
    </p>
  </div>
</div>
