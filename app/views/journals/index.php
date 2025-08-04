<div class="container">
    <h2>Your Journals</h2>

    <ul>
        <?php foreach($journals as $journal): ?>
        <li><? htmlspecialchars($journal[$title]); ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="?controller=journal&action=create">Add new Entry</a>
</div>