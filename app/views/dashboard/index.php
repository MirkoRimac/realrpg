<div class="container-fluid">

<h2>Real RPG</h2>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-3">
        <img class="avatar" src="../../../assets/images/placeholder.jpg">
        <div class="level text-center">
            <p>Level 217</p>
            <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar text-bg-info" style="width: 75%">75%</div>
            </div>
            <p>500 / 12000 XP⭐</p>
        </div>

        <p>Name: Moschn</p>
        <p>Class: Mage</p>
        <p>Race: Night Elf</p>
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
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Reward</th>
                            <th>XP</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quests as $quest): ?>
                            <tr>
                                <td><?= htmlspecialchars($quest["title"]) ?></td>
                                <td><?= htmlspecialchars($quest['is_active']) ?></td>
                                <td><?= htmlspecialchars($quest['reward']) ?> Gold</td>
                                <td><?= htmlspecialchars($quest['xp']) ?> XP</td>
                                <td><?= date('d.m.Y', strtotime($quest['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <!-- Journal Area -->
        <h2>Journal</h2>
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

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Build a PHP Project</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Build a real project with PHP</h6>
                <ul>
                    <li><p class="card-text">Category: Main Quest</p></li>
                    <li><p class="card-text">Reward: 100 Gold</p></li>
                    <li><p class="card-text">XP: 500 XP</p></li>
                </ul>
                <a href="#" class="card-link">Read more...</a>
            </div>
            </div>
        </div>

  </div>
</div>

</div>