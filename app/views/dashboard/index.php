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

    <!-- Sidebar -->
    <div class="col-12 col-lg-3 order-lg-1">
      <div class="card text-center">
        <h3>Your Avatar</h3>
        <canvas id="avatarCanvas" width="64" height="64" style="image-rendering: pixelated; cursor: pointer;"
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

        <div class="card-body">
          <?php
            // require_once "../app/helpers/xp.php";
            $xpNeeded = xpForNextLevel($user["level"]);
            $percent = ($user["xp"] / $xpNeeded) * 100;
          ?>
          <h4>Level <?= htmlspecialchars($user["level"]) ?></h4>
          <div class="progress mb-2" style="height: 20px;">
            <div class="progress-bar bg-success" style="width: <?= $percent ?>%">
              <?= round($percent) ?>%
            </div>
          </div>
          <p><?= $user["xp"] ?> / <?= $xpNeeded ?> XP</p>
          <hr>
          <?php if ($user["class"] && $user["race"]): ?>
            <h4>Your Avatar</h4>
            <p>Name: <?= htmlspecialchars($user["username"]) ?></p>
            <p><strong>Class:</strong> <?= htmlspecialchars($user["class"]) ?></p>
            <p><strong>Race:</strong> <?= htmlspecialchars($user["race"]) ?></p>
            <p><strong>Backstory:</strong><br> <?= nl2br(htmlspecialchars(limitWords($user["backstory"], 20))) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="col-12 col-lg-9 order-lg-2">
      <ul class="nav nav-tabs mb-3" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">Active Quests</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="available-tab" data-bs-toggle="tab" data-bs-target="#available" type="button" role="tab">Available Quests</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="journal-tab" data-bs-toggle="tab" data-bs-target="#journal" type="button" role="tab">Journal</button>
        </li>
      </ul>

      <div class="tab-content" id="dashboardTabsContent">
        <!-- Active Quests -->
        <div class="tab-pane fade show active" id="active" role="tabpanel">
          <section class="mb-5">
            <?php if (empty($quests)): ?>
              <p>No active quests</p>
            <?php else: ?>
              <div class="row g-3">
                <?php foreach ($quests as $quest): ?>
                  <div class="col-12 col-lg-6">
                    <div class="card quest-card mb-3"
                        data-title="<?= htmlspecialchars($quest["title"]) ?>"
                        data-description="<?= htmlspecialchars($quest["description"] ?? 'No description') ?>"
                        data-reward="<?= $quest["reward"] ?>"
                        data-xp="<?= $quest["xp"] ?>"
                        data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
                        data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>">
                      <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
                        <p><strong>Status:</strong> <span class="badge bg-success">Aktiv</span></p>
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
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </section>
        </div>

        <!-- Available Quests -->
        <div class="tab-pane fade" id="available" role="tabpanel">
          <section>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <!-- <h2 class="mb-0">Available Quests</h2> -->
              <a href="?controller=quest&action=create" class="btn btn-success btn-sm">Add new Quest</a>
            </div>

            <?php if (empty($availableQuests)): ?>
              <p>No quests available</p>
            <?php else: ?>
              <div class="row g-3">
                <?php foreach ($availableQuests as $quest): ?>
                  <div class="col-12 col-lg-6">
                    <div class="card quest-card h-100"
                        data-title="<?= htmlspecialchars($quest["title"]) ?>"
                        data-description="<?= nl2br(htmlspecialchars($quest["description"])) ?>"
                        data-reward="<?= $quest["reward"] ?>"
                        data-xp="<?= $quest["xp"] ?>"
                        data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
                        data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>">
                      <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
                        <p><strong>Status:</strong> <span class="badge bg-danger">Not active</span></p>
                        <h6 class="card-subtitle mb-2 text-muted"><?= date('d.m.Y', strtotime($quest['created_at'])) ?></h6>
                        <ul class="mb-2">
                          <li><strong>Belohnung: 🪙</strong> <?= $quest["reward"] ?> Gold</li>
                          <li><strong>XP: ⭐</strong> <?= $quest["xp"] ?> XP</li>
                        </ul>
                        <p><?= htmlspecialchars(limitWords($quest["description"], 20)) ?></p>
                        <form method="POST" action="?controller=quest&action=toggleStatus">
                          <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
                          <input type="hidden" name="is_active" value="1">
                          <button type="submit" class="btn btn-success btn-sm w-100">Activate</button>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </section>
        </div>


        <!-- Journal -->
        <div class="tab-pane fade" id="journal" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- <h2 class="mb-0">Journal</h2> -->
            <a href="?controller=journal&action=create" class="btn btn-success btn-sm">Add new Entry</a>
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
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>
