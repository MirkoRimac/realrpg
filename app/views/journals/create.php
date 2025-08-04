<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">
    <h2 class="text-center mb-4">New Journal Entry</h2>

    <form action="?controller=journal&action=store" method="post">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control" required></textarea>
      </div>
      <button type="submit" class="btn btn-success w-100">Save Entry</button>
    </form>
  </div>
</div>