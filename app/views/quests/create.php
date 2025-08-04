<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">
    <h2 class="text-center mb-4">New Quest</h2>

    <form action="?controller=quest&action=store" method="post">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Reward</label>
        <input type="number" name="reward" class="form-control" required></input>
      </div>
      <div class="mb-3">
        <label class="form-label">XP</label>
        <input type="number" name="xp" class="form-control" required></input>
      </div>
      <button type="submit" class="btn btn-success w-100">Save</button>
    </form>
  </div>
</div>