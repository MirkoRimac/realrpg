<div class="container-fluid">

<h1 class="header text-center m-3">Real RPG</h1>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-3">
        <img class="avatar" src="../assets/images/avatar.jpg">
        <!-- <div class="level text-center">
            <p>Level 217</p>
            <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar text-bg-info" style="width: 75%">75%</div>
            </div>
            <p>500 / 12000 XP⭐</p>
        </div> -->

        <?php
            require_once "../app/helpers/xp.php";
            $xpNeeded = xpForNextLevel($user["level"]);
            $percent = ($user["xp"] / $xpNeeded) * 100;
        ?>
        <div class="level text-center">
            <p>Level <?php echo htmlspecialchars($user["level"]); ?></p>
            <p><? htmlspecialchars($user["level"]); ?></p>
            <div class="progress">
                <div class="progress-bar" style="width: <?= $percent ?>%"><?= round($percent) ?>%</div>
            </div>
            <p><?= $user["xp"] ?> / <?= $xpNeeded ?> XP</p>
        </div>
        <div class="userInfo">
            <p>Name: Mörko</p>
            <p>Class: Mage</p>
            <p>Race: Night Elf</p>
        </div>
    </div>

    <div class="col-lg-6">
      <!-- <h2>Active Quests</h2> -->

      <!-- <table class="table">
        <thead>
            <tr>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th scope="col">Category</th>
            <th scope="col">Reward</th>
            <th scope="col">XP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">Do the dishes</th>
            <td>In Progress</td>
            <td>Daily Quest</td>
            <td>10 Gold</td>
            <td>50 XP</td>
            </tr>
            <tr>
            <th scope="row">Family time</th>
            <td>In Progress</td>
            <td>Daily Quest</td>
            <td>15 Gold</td>
            <td>100 XP</td>
            </tr>
            <tr>
            <th scope="row">Academy</th>
            <td>In Progress</td>
            <td>Main Quest</td>
            <td>15 Gold</td>
            <td>100 XP</td>
            </tr>
        </tbody>
        </table> -->

        <section class="quests">
            <h2>Aktive Quests</h2>
            <?php if (empty($quests)): ?>
                <p>Keine aktiven Quests</p>
            <?php else: ?>
                <div class="quest-list">
                <?php foreach ($quests as $quest): ?>
                    <div class="quest-card">
                    <h4><?= htmlspecialchars($quest["title"]) ?></h4>
                    <p><strong>Status:</strong> <?= $quest['is_active'] ? "Aktiv" : "Inaktiv" ?></p>
                    <p><strong>Reward:</strong> <?= $quest["reward"] ?> Gold</p>
                    <p><strong>XP:</strong> <?= $quest["xp"] ?> XP</p>
                    <p><strong>Erstellt:</strong> <?= date('d.m.Y', strtotime($quest['created_at'])) ?></p>

                    <div class="quest-buttons">
                        <a href="?controller=quest&action=complete&id=<?= $quest['id'] ?>" class="btn btn-success">✔ Erledigt</a>

                        <form method="POST" action="?controller=quest&action=toggleStatus">
                        <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
                        <input type="hidden" name="is_active" value="0">
                        <button type="submit" class="btn btn-warning">✖ Cancel</button>
                        </form>
                    </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            </section>


        <!-- Journal Area -->
        <h2 class="mt-5">Journal</h2>
        <a href="#" class="add_entry_btn">Add Entry</a>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Hothothot</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                <p class="card-text">Heute habe ich 3 Kabinen geschafft...</p>
                <a href="#" class="card-link">Read more...</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <h2>Available Quests</h2>
        <a href="?controller=quest&action=create" class="add_entry_btn">Add Quest</a>

        <?php if (empty($availableQuests)): ?>
            <p>Keine verfügbaren Quests</p>
        <?php else: ?>
            <?php foreach ($availableQuests as $quest): ?>
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($quest["title"]) ?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">
                            <?= date('d.m.Y', strtotime($quest['created_at'])) ?>
                        </h6>
                        <ul>
                            <li><p class="card-text">Belohnung: <?= $quest["reward"] ?> Gold</p></li>
                            <li><p class="card-text">XP: <?= $quest["xp"] ?> XP</p></li>
                        </ul>
                        <p class="card-text"><?= nl2br(htmlspecialchars($quest["description"])) ?></p>
                        <a href="#" class="card-link">Read more...</a>

                        <form method="POST" action="?controller=quest&action=toggleStatus">
                            <input type="hidden" name="quest_id" value="<?= $quest['id'] ?>">
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="btn btn-success btn-sm">Activate</button>
                        </form>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

  </div>
</div>

</div>