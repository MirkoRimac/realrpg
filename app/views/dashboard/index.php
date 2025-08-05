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

  <h1 class="text-center my-4">Real RPG</h1>

  <div class="row g-4">
    
    <!-- Sidebar / Avatar & User Info -->
    <div class="col-12 col-lg-3 order-lg-1">
      <div class="card text-center">
        <!-- <img class="card-img-top img-fluid rounded" src="../assets/images/avatar.jpg" alt="Avatar" style="max-height: 300px; object-fit: cover;"> -->

        <h3>Preview</h3>
        <canvas id="avatarCanvas" width="64" height="64" style="image-rendering: pixelated;"></canvas>

        <script src="js/avatarRenderer.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const userRace = <?= json_encode($user["race"]) ?>;
                const userClass = <?= json_encode($user["class"]) ?>;
                drawAvatar(userRace, userClass);
            });
        </script>



        
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

          <!-- Limitiere die angezeigten Wörter -->


          <?php if ($user["class"] && $user["race"]): ?>
                <h4>Your Avatar</h5>
                <p>Name: <?= htmlspecialchars($user["username"]) ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($user["class"]) ?></p>
                <p><strong>Race:</strong> <?= htmlspecialchars($user["race"]) ?></p>
                <p><strong>Backstory:</strong><br> <?= nl2br(htmlspecialchars(limitWords($user["backstory"], 20))) ?></p>
            <?php endif; ?>

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
          <div class="d-grid gap-3">
            <?php foreach ($quests as $quest): ?>
              <div class="card quest-card mb-3"
                  data-title="<?= htmlspecialchars($quest["title"]) ?>"
                  data-description="<?= htmlspecialchars($quest["description"] ?? 'No description') ?>"
                  data-reward="<?= $quest["reward"] ?>"
                  data-xp="<?= $quest["xp"] ?>"
                  data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
                  data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>">
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
                  <p><strong>Status:</strong> <?= $quest['is_active'] ? '<span class="badge bg-success">Aktiv</span>' : "Inaktiv" ?></p>
                  <p><strong>Reward:</strong> 🪙 <?= $quest["reward"] ?> Gold</p>
                  <p><strong>XP:</strong> ⭐ <?= $quest["xp"] ?> XP</p>
                  <p><strong>Created:</strong> <?= date('d.m.Y', strtotime($quest['created_at'])) ?></p>
                  <p><strong>Due date:</strong> <?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?></p>

                  <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                    <a href="?controller=quest&action=complete&id=<?= $quest['id'] ?>" class="btn btn-success w-100">✔ Done</a>
                    <form method="POST" action="?controller=quest&action=toggleStatus" class="w-100 w-md-auto">
                      <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
                      <input type="hidden" name="is_active" value="0">
                      <button class="btn btn-danger w-100">✖ Cancel</button>
                    </form>
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
                data-description="<?= htmlspecialchars(limitWords($journal["description"], 20)) ?>"
                data-created="<?= date('d.m.Y', strtotime($journal['created_at'])) ?>">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($journal["title"]) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                  <?= date('d.m.Y', strtotime($journal['created_at'])) ?>
                </h6>
                <p class="card-text"><?= nl2br(htmlspecialchars($journal["description"])) ?></p>
                <a href="#" class="card-link">Read more...</a>
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
            data-description="<?= htmlspecialchars(limitWords($quest["description"], 20)) ?>"
            data-reward="<?= $quest["reward"] ?>"
            data-xp="<?= $quest["xp"] ?>"
            data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
            data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?= date('d.m.Y', strtotime($quest['created_at'])) ?></h6>
            <ul class="mb-2">
              <li><strong>Belohnung: 🪙 </strong> <?= $quest["reward"] ?> Gold</li>
              <li><strong>XP: ⭐ </strong> <?= $quest["xp"] ?> XP</li>
            </ul>
            <p><?= nl2br(htmlspecialchars($quest["description"])) ?></p>
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
