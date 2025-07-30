<div class="container">
    <h2>Your Quests</h2>

    <ul>
        <?php foreach($quests as $quest): ?>
        <li><? htmlspecialchars($quest[$title]); ?> (<? $quest["xp"] ?> XP)</li>
        <?php endforeach; ?>
    </ul>

    <a href="?controller=quest&action=create">Add new Quest</a>
</div>