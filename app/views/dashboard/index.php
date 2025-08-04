<div class="container-fluid px-3">

  <h1 class="text-center my-4">Real RPG</h1>

  <div class="row g-4">
    
    <!-- Sidebar / Avatar & User Info -->
    <div class="col-12 col-lg-3 order-lg-1">
      <div class="card text-center">
        <img class="card-img-top img-fluid rounded" src="../assets/images/avatar.jpg" alt="Avatar" style="max-height: 300px; object-fit: cover;">

        <div class="card-body">
          <?php
            require_once "../app/helpers/xp.php";
            $xpNeeded = xpForNextLevel($user["level"]);
            $percent = ($user["xp"] / $xpNeeded) * 100;
          ?>
          <h5>Level <?= htmlspecialchars($user["level"]) ?></h5>
          <div class="progress mb-2" style="height: 20px;">
            <div class="progress-bar bg-success" style="width: <?= $percent ?>%">
              <?= round($percent) ?>%
            </div>
          </div>
          <p><?= $user["xp"] ?> / <?= $xpNeeded ?> XP</p>
          <hr>
          <p>Name: <?= htmlspecialchars($user["username"]) ?></p>
          <p>Class: Mage</p>
          <p>Race: Night Elf</p>
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
              <div class="card">
                <div class="card-body">
                  <h5><?= htmlspecialchars($quest["title"]) ?></h5>
                  <p><strong>Status:</strong> <?= $quest['is_active'] ? "Aktiv" : "Inaktiv" ?></p>
                  <p>
                    <span class="badge bg-success">Aktiv</span>
                  </p>
                  <p><strong>Reward:</strong> 🪙 <?= $quest["reward"] ?> Gold</p>
                  <p><strong>XP:</strong> ⭐ <?= $quest["xp"] ?> XP</p>
                  <p><strong>Erstellt:</strong> <?= date('d.m.Y', strtotime($quest['created_at'])) ?></p>

                  <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                    <a href="?controller=quest&action=complete&id=<?= $quest['id'] ?>" class="btn btn-success w-100"><i class="bi bi-check-circle-fill"></i> Done</a>
                    <form method="POST" action="?controller=quest&action=toggleStatus" class="w-100 w-md-auto">
                      <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
                      <input type="hidden" name="is_active" value="0">
                      <button class="btn btn-danger w-100"><i class="bi bi-x-circle-fill"></i> Cancel</button>
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
            <div class="card mb-3">
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
          <div class="card mb-3">
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
