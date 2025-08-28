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
  <div class="row g-4">
    <!-- Sidebar -->
    <div class="col-12 col-lg-3 order-lg-1">
      <div class="avatar-card"
           data-name="<?= htmlspecialchars($user["username"]) ?>"
           data-race="<?= htmlspecialchars($user["race"]) ?>"
           data-class="<?= htmlspecialchars($user["class"]) ?>"
           data-backstory="<?= nl2br(htmlspecialchars($user["backstory"])) ?>"
           data-gold="<?= nl2br(htmlspecialchars($user["gold"])) ?>"
           data-xp="<?= nl2br(htmlspecialchars($user["xp"])) ?>">
        <div class="card text-center p-3">
          <h3 class="mb-3">Your Avatar</h3>
          <canvas id="avatarCanvas"
                  width="64" height="64"
                  style="image-rendering: pixelated; cursor: pointer;"
                  class="avatar-click mb-3"
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
              require_once "../app/helpers/xp.php";
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
              <h5>Your Avatar</h5>
              <p>Name: <?= htmlspecialchars($user["username"]) ?></p>
              <p><strong>Race:</strong> <?= htmlspecialchars($user["race"]) ?></p>
              <p><strong>Class:</strong> <?= htmlspecialchars($user["class"]) ?></p>
              <p><strong>Backstory:</strong><br> <?= nl2br(htmlspecialchars(limitWords($user["backstory"], 20))) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="col-12 col-lg-9 order-lg-2">
      <ul class="nav nav-tabs mb-3" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="quests-tab" data-bs-toggle="tab" data-bs-target="#quests" type="button" role="tab">Active Quests</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="available-tab" data-bs-toggle="tab" data-bs-target="#available" type="button" role="tab">Available Quests</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="journal-tab" data-bs-toggle="tab" data-bs-target="#journal" type="button" role="tab">Journal</button>
        </li>
      </ul>

      <div class="tab-content" id="dashboardTabsContent">
        <!-- Available Quests with category grouping -->
        <div class="tab-pane fade show active" id="quests" role="tabpanel">
          <?php
          $groupedQuests = [ 'main' => [], 'daily' => [], 'side' => [] ];
          foreach ($availableQuests as $quest) {
            $category = strtolower($quest['category'] ?? 'side');
            $groupedQuests[$category][] = $quest;
          }
          ?>

          <?php foreach (["main" => "Main Quests", "daily" => "Daily Quests", "side" => "Side Quests"] as $key => $label): ?>
            <?php if (!empty($groupedQuests[$key])): ?>
              <h4 class="mb-3 mt-4"><?= $label ?></h4>
              <div class="row g-3">
                <?php foreach ($groupedQuests[$key] as $quest): ?>
                  <div class="col-12 col-lg-6">
                    <div class="card quest-card h-100"
                         data-title="<?= htmlspecialchars($quest["title"]) ?>"
                         data-description="<?= htmlspecialchars($quest["description"]) ?>"
                         data-reward="<?= (int)$quest["reward"] ?>"
                         data-xp="<?= (int)$quest["xp"] ?>"
                         data-gold="<?= (int)$quest["reward"] ?>"
                         data-created="<?= date('d.m.Y', strtotime($quest['created_at'])) ?>"
                         data-due="<?= date('d.m.Y', strtotime($quest['due_date'] ?? $quest['created_at'])) ?>"
                         data-category="<?= htmlspecialchars($quest['category']) ?>">
                      <div class="card-body">
                        <h5 class="card-title">
                          <?= htmlspecialchars($quest["title"]) ?>
                          <span class="badge badge-category <?= strtolower($quest["category"]) ?>">
                            <?= ucfirst($quest["category"]) ?>
                          </span>
                        </h5>
                        <p><span class="quest-label">Status:</span> 
                          <?= $quest['is_active'] 
                                ? '<span class="badge bg-success">Active</span>' 
                                : '<span class="badge bg-danger">Not active</span>' ?>
                        </p>
                        <p><span class="quest-label">Reward:</span> 🪙 <?= $quest["reward"] ?> Gold</p>
                        <p><span class="quest-label">XP:</span> ⭐ <?= $quest["xp"] ?> XP</p>
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
          <?php endforeach; ?>
        </div>

        <!-- Journal -->
        <div class="tab-pane fade" id="journal" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="?controller=journal&action=create" class="btn btn-success btn-sm">Add new Entry</a>
          </div>

          <?php if (empty($availableJournal)): ?>
            <p>No journal entries available</p>
          <?php else: ?>
            <div class="row g-3">
              <?php foreach ($availableJournal as $journal): ?>
                <div class="col-12 col-lg-6">
                  <div class="card journal-card h-100"
                        data-title="<?= htmlspecialchars($journal["title"]) ?>"
                        data-description="<?= htmlspecialchars($journal["description"]) ?>"
                        data-created="<?= date('d.m.Y', strtotime($journal['created_at'])) ?>">
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($journal["title"]) ?></h5>
                      <p class="card-text"><?= nl2br(htmlspecialchars(limitWords($journal["description"], 20))) ?></p>
                      <h6 class="card-subtitle mb-2 text-color">
                        Created: <?= date('d.m.Y', strtotime($journal['created_at'])) ?>
                      </h6>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>
