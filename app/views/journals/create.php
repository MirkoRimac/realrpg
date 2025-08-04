<div class="container text-center">
    <h2>New Journal Entry</h2>

<div class="row justify-content-center">
    <div class="forms col-8">
        <form action="?controller=journal&action=store" method="post">
            <input class="mb-3" type="text" name="title" value="<?= htmlspecialchars($formData['title']) ?>" placeholder="Journal title" required>
            <textarea class="mb-3" name="description" placeholder="Journal description" required></textarea>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
</div>