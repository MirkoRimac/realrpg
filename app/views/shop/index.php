<div class="container-fluid px-3">
<section class="mb-5">
    <h1 class=" text-center my-4">Shop</h1>
    <div class="row g-3 justify-content-center">
        <?php foreach($items as $item): ?>
            <!-- <div class="col-12 col-lg-3"> -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card item-card h-100" style="cursor: pointer"
                    data-name="<?= htmlspecialchars($item["name"]); ?>"
                    data-price="<?= htmlspecialchars($item["price"]); ?>"
                    data-rarity="<?= htmlspecialchars($item["rarity"]); ?>"
                    data-description="<?= htmlspecialchars($item["description"]); ?>">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <img src="../public/sprites/logo.png" width="200">
                        </div>
                        <p><span class="quest-label">Item:</span> <span class="quest-value"><?= htmlspecialchars($item["name"]); ?><span></p>
                        <p><span class="quest-label">Price:</span> 🪙 <span class="quest-value"><?= htmlspecialchars($item["price"]); ?> Gold<span></p>
                        <p><span class="quest-label">Rarity:</span><span class="quest-value"><?= htmlspecialchars($item["rarity"]); ?><span></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</div>