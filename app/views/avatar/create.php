<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
    <h2>Create Your Avatar</h2>

    <form action="?controller=avatar&action=store" method="POST">
        <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class" class="form-select" required>
                <option value="">Choose...</option>
                <option value="Warrior">Warrior</option>
                <option value="Mage">Mage</option>
                <option value="Rouge">Rouge</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Race</label>
            <select name="race" class="form-select" required>
                <option value="">Choose...</option>
                <option value="Human">Human</option>
                <option value="Elf">Elf</option>
                <option value="Orc">Orc</option>
            </select>
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Skin color</label>
            <input type="color" name="skinColor" value="#f1c27d" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Clothes</label>
            <input type="color" name="clothesColor" value="#4a90e2" class="form-control">
        </div> -->


        <div class="mb-3">
            <label class="form-label">Backstory</label>
            <textarea name="backstory" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Avatar</button>
    </form>
  </div>
</div>