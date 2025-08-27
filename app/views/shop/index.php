<div class="container-fluid px-3">
  <section class="mb-5">
    <h1 class="text-center my-4">Shop</h1>
    <div class="row g-4 justify-content-center">
      <?php foreach ($items as $item): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div 
            class="card item-card h-100 text-center px-2 py-3"
            style="cursor: pointer;"
            data-id="<?= (int)$item["id"]; ?>"
            data-img="sprites/<?= htmlspecialchars($item["icon"]); ?>"
            data-name="<?= htmlspecialchars($item["name"]); ?>"
            data-price="<?= htmlspecialchars($item["price"]); ?>"
            data-rarity="<?= htmlspecialchars($item["rarity"]); ?>"
            data-description="<?= htmlspecialchars($item["description"]); ?>"
          >
            <div class="card-body d-flex flex-column justify-content-between">
              <div class="mb-3">
                <img src="sprites/<?= htmlspecialchars($item["icon"]); ?>" width="180" class="pixel-art mb-4">
                <p class="mb-2">
                  <span class="quest-label">Item:</span> 
                  <span class="quest-value"><?= htmlspecialchars($item["name"]); ?></span>
                </p>
                <p class="mb-2">
                  <span class="quest-label">Price:</span> 
                  🪙 <span class="quest-value"><?= htmlspecialchars($item["price"]); ?> Gold</span>
                </p>
              </div>
              <div class="card-footer bg-transparent border-0">
                <span class="quest-label">Rarity:</span> 
                <span class="badge-rarity <?= strtolower($item['rarity']); ?>">
                  <?= htmlspecialchars($item["rarity"]); ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>
