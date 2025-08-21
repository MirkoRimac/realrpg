

<!-- Limitiere angezeigte Wörter -->
<?php
function limitWords($text, $limit = 100) {
  $words = preg_split('/\s+/', strip_tags($text));
  if (count($words) <= $limit) {
    return implode(' ', $words);
  }
  return implode(' ', array_slice($words, 0, $limit)) . '…';
}
?>

<div class="container-fluid px-3">

  <h1 class="text-center my-4">Dashboard</h1>

  <div class="row g-4">
    
<!-- Sidebar / Avatar & User Info -->
    <div class="col-12 col-lg-3 order-lg-1">
      <div class="avatar-card"
            data-name="<?= htmlspecialchars($user["username"]) ?>"
            data-race="<?= htmlspecialchars($user["race"]) ?>"
            data-class="<?= htmlspecialchars($user["class"]) ?>"
            data-backstory="<?= nl2br(htmlspecialchars($user["backstory"])) ?>"
            data-gold="<?= nl2br(htmlspecialchars($user["gold"])) ?>"
            data-xp="<?= nl2br(htmlspecialchars($user["xp"])) ?>">
      <div class="card text-center">
<!-- <img class="card-img-top img-fluid rounded" src="../assets/images/avatar.jpg" alt="Avatar" style="max-height: 300px; object-fit: cover;"> -->
      <div class="avatar-card"></div>
        <h3>Your Avatar</h3>
        <canvas id="avatarCanvas" 
                width="64" 
                height="64" 
                style="image-rendering: pixelated; cursor: pointer;"
                class="avatar-click"
                data-username="<?= htmlspecialchars($user['username']) ?>"
                data-class="<?= htmlspecialchars($user['class']) ?>"
                data-race="<?= htmlspecialchars($user['race']) ?>"
                data-level="<?= htmlspecialchars($user['level']) ?>"
                data-xp="<?= htmlspecialchars($user['xp']) ?>"
                data-backstory="<?= htmlspecialchars($user['backstory']) ?>">
        </canvas>

        <script src="js/avatarRenderer.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const userRace = <?= json_encode($user["race"]) ?>;
                const userClass = <?= json_encode($user["class"]) ?>;
                drawAvatar(userRace, userClass);
            });
        </script>



<!-- Level Anzeige und Progress Bar -->
        <div class="card-body">
          <?php
            require_once "../app/helpers/xp.php";
            $xpNeeded = xpForNextLevel($user["level"]);
            $percent = ($user["xp"] / $xpNeeded) * 100;
          ?>
          <h4>Level <?= htmlspecialchars($user["level"]) ?></h5>
          <div class="progress mb-2" style="height: 20px;">
            <div class="progress-bar bg-success" style="width: <?= $percent ?>%">
              <?= round($percent) ?>%
            </div>
          </div>
          <p><?= $user["xp"] ?> / <?= $xpNeeded ?> XP</p>
          <hr>

<!-- Daten zum Avatar -->
          
          <?php if ($user["class"] && $user["race"]): ?>
                <h4>Your Avatar</h5>
                <p>Name: <?= htmlspecialchars($user["username"]) ?></p>
                <p><strong>Race:</strong> <?= htmlspecialchars($user["race"]) ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($user["class"]) ?></p>
                <p><strong>Backstory:</strong><br> <?= nl2br(htmlspecialchars(limitWords($user["backstory"], 20))) ?></p>
            <?php endif; ?>
            </div>
        </div>
      </div>
    </div>

<!-- Main Content: Quests + Journal -->
    <div class="col-12 col-lg-6 order-lg-2">

<!-- Active Quests -->
    <section class="mb-5">
    <h2 class="mb-3">Active Quests</h2>

    <?php if (empty($quests)): ?>
        <p>No active quests</p>
    <?php else: ?>
        <div class="row g-3"> <!-- Bootstrap Row mit Gap -->
            <?php foreach ($quests as $quest): ?>
                <div class="col-12 col-lg-6"> <!-- 1 Spalte auf klein, 2 Spalten ab lg -->
                    <div class="card quest-card h-100"
                        data-title="<?= htmlspecialchars($quest["title"]) ?>"
                        data-description="<?= htmlspecialchars($quest["description"] ?? 'No description') ?>"
                        data-reward="<?= $quest["reward"] ?>"
                        data-xp="<?= $quest["xp"] ?>"
                        data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
                        data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>">
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
                            <p><span class="quest-label">Status:</span> 
                                <?= $quest['is_active'] ? '<span class="badge bg-success">Active</span>' : "Not active" ?>
                            </p>
                            <p><span class="quest-label">Reward:</span> 🪙 <span class="quest-value"><?= $quest["reward"] ?> Gold</span></p>
                            <p><span class="quest-label">XP:</span> ⭐ <?= $quest["xp"] ?> XP</p>
                            <p><span class="quest-label">Created:</span> <?= date('d.m.Y', strtotime($quest['created_at'])) ?></p>
                            <p><span class="quest-label">Due date:</span> <?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?></p>

                            <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                                <a href="?controller=quest&action=complete&id=<?= $quest['id'] ?>" 
                                   class="btn btn-success w-100">✔ Done</a>
                                <form method="POST" action="?controller=quest&action=toggleStatus" class="w-100 w-md-auto">
                                    <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
                                    <input type="hidden" name="is_active" value="0">
                                    <button class="btn btn-danger w-100">✖ Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>


<!-- Journal -->
      <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="mb-0">Journal</h2>
          <a href="?controller=journal&action=create" class="btn btn-success btn-sm">Add Entry</a>
        </div>

        <?php if (empty($availableJournal)): ?>
          <p>No journal entries available</p>
        <?php else: ?>
          <?php foreach ($availableJournal as $journal): ?>
            <div class="card journal-card mb-3"
                data-title="<?= htmlspecialchars($journal["title"]) ?>"
                data-description="<?= htmlspecialchars($journal["description"]) ?>"
                data-created="<?= date('d.m.Y', strtotime($journal['created_at'])) ?>">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($journal["title"]) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars(limitWords($journal["description"], 20 ))) ?></p>
                <h6 class="card-subtitle mb-2 text-color">
                  Created: <?= date('d.m.Y', strtotime($journal['created_at'])) ?>
                </h6>
              </div>
            </div>
        <?php endforeach; ?>

        <?php endif; ?>
      </section>
    </div>

<!-- Right Column: Available Quests -->
    <div class="col-12 col-lg-3 order-lg-3">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Available Quests</h2>
        <a href="?controller=quest&action=create" class="btn btn-success btn-sm">Add</a>
      </div>

      <?php if (empty($availableQuests)): ?>
        <p>No quests available</p>
      <?php else: ?>
        <?php foreach ($availableQuests as $quest): ?>
          <div class="card mb-3 quest-card" 
            data-title="<?= htmlspecialchars($quest["title"]) ?>"
            data-description="<?= htmlspecialchars($quest["description"]) ?>"
            data-reward="<?= $quest["reward"] ?>"
            data-xp="<?= $quest["xp"] ?>"
            data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
            data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
            <p><span class="quest-label">Status:</span> 
              <?= $quest['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Not active</span>' ?>
            </p>
            <p><span class="quest-label">Reward:</span> 🪙 <span class="quest-value"><?= $quest["reward"] ?> Gold</span></p>
            <p><span class="quest-label">XP:</span> ⭐ <?= $quest["xp"] ?> XP</p>
            <p><span class="quest-label">Created:</span><span class="quest-value"><?= date('d.m.Y', strtotime($quest['created_at'])) ?></span></p>
            <p><span class="quest-label">Due date:</span><span class="quest-value"><?= date('d.m.Y', strtotime($quest['created_at'])) ?></span></p>

            <form method="POST" action="?controller=quest&action=toggleStatus">
              <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
              <input type="hidden" name="is_active" value="1">
              <button type="submit" class="btn btn-success btn-sm w-100">Activate</button>
            </form>
          </div>
        </div>

        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
  </div>
</div>