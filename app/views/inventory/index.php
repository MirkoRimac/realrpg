<div class="container-fluid px-3">
<section class="mb-5">
    <h1 class=" text-center my-4">Inventory</h1>
    <div class="row g-3 justify-content-center">
        <?php foreach($items as $it): ?>
            <!-- <div class="col-12 col-lg-3"> -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card inventory-card h-100" style="cursor: pointer"
                    data-img="sprites/<?= htmlspecialchars($it['icon']) ?>"
                    data-name="<?= htmlspecialchars($it['name']) ?>"
                    data-qty="<?= (int)$it['qty'] ?>"
                    data-value="<?= (int)$it['price'] ?>"
                    data-description="<?= htmlspecialchars($it['description']) ?>"
                    data-rarity="<?= htmlspecialchars($it['rarity']) ?>">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center mb-4">
                        <img src="sprites/<?= htmlspecialchars($it['icon']) ?>"
                            alt="<?= htmlspecialchars($it['name']) ?>"
                            class="pixel-art mb-3" width="128" height="128">
                        </div>
                        <h5 class="card-title"><?= htmlspecialchars($it['name']) ?></h5>
                        <p class="mb-1">
                            <span class="badge-rarity <?= strtolower($it['rarity']) ?>">
                            <?= htmlspecialchars($it['rarity']) ?>
                            </span>
                        </p>
                        <p class="mb-1"><span class="quest-label">Quantity:</span> <span class="quest-value"><?= (int)$it['qty'] ?>x</span></p>
                        <p class="mb-2"><span class="quest-label">Value:</span> 🪙 <?= (int)$it['price'] ?> Gold</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</div>