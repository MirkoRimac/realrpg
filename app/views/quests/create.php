<div class="container text-center">
    <h2>New Quest</h2>

<div class="row justify-content-center">
    <div class="forms col-8">
        <form action="?controller=quest&action=store" method="post">
            <input class="mb-3" type="text" name="title" value="<?= htmlspecialchars($formData['title']) ?>" placeholder="Quest title" required>
            <textarea class="mb-3" name="description" placeholder="Quest description" required></textarea>
            <input class="mb-3" type="number" name="reward" placeholder="reward in gold" required>
            <input class="mb-3" type="number" name="xp" placeholder="XP" required>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
</div>