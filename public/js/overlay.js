document.addEventListener('DOMContentLoaded', () => {
  const modalOverlay = document.getElementById('modalOverlay');
  const modalBody = document.getElementById('modalBody');
  const closeBtn = modalOverlay.querySelector('.close-btn');

  function openModal(html) {
    modalBody.innerHTML = html;
    modalOverlay.classList.remove('d-none');
  }

  function attachCardClick(selector, builderFn) {
    document.querySelectorAll(selector).forEach(card => {
      card.addEventListener('click', () => {
        const html = builderFn(card.dataset);
        openModal(html);
      });

      card.querySelectorAll('form, button, a').forEach(el => {
        el.addEventListener('click', e => e.stopPropagation());
      });
    });
  }

  attachCardClick('.quest-card', data => `
    <h4 class="mb-3 quest-title">${data.title} <span class="badge badge-category">${data.category}</span></h4>
    <p><span class="quest-value">${data.description}</span></p>
    <ul class="list-unstyled mt-3">
      <li><span class="quest-label">Reward:</span> 🪙 ${data.reward} Gold</li>
      <li><span class="quest-label">XP:</span> ⭐ ${data.xp}</li>
      <li><span class="quest-label">Created:</span> ${data.created}</li>
      <li><span class="quest-label">Due date:</span> ${data.due}</li>
    </ul>
  `);

  attachCardClick('.journal-card', data => `
    <ul class="list-unstyled mt-3">
      <li><h4 class="mb-3">${data.title}</h4></li>
      <li><p class="mt-3"><span class="quest-label">Created:</span> ${data.created}</p></li>
      <li><p>${data.description}</p></li>
    </ul>
  `);

  attachCardClick('.avatar-card', data => `
    <ul class="list-unstyled mt-3">
      <li><span class="quest-label mb-3">Name: </span>${data.name}</li>
      <li><span class="quest-label mb-3">Race: </span>${data.race}</li>
      <li><span class="quest-label mb-3">Class: </span>${data.class}</li>
      <li><span class="quest-label mb-3">XP: </span>⭐ ${data.xp} XP</li>
      <li><span class="quest-label mb-3">Gold: </span>🪙 ${data.gold} Gold</li>
      <li><span class="quest-label">Backstory: </span>${data.backstory}</li>
    </ul>  
  `);

  attachCardClick('.item-card', data => `
    <ul class="list-unstyled mt-3">
      <div class="d-flex flex-column align-items-center mb-4">
          <img src="${data.img}" width="200" class="pixel-art">
      </div>
      <li><span class="quest-label mb-3">Item: </span>${data.name}</li>
      <li><span class="quest-label mb-3">Price:</span> 🪙 ${data.price} Gold</li>
      <li><span class="quest-label mb-3">Rarity: </span>${data.rarity}</li>
      <li><span class="quest-label mb-3">Description: </span>${data.description}</li>
      <form method="POST" action="?controller=shop&action=buy" class="d-flex gap-2">
        <input type="hidden" name="item_id" value="${data.id}">
        <input type="number" name="qty" min="1" value="1" class="form-control form-control-sm w-auto">
        <button type="submit" class="btn btn-success btn-sm">Buy</button>
      </form>
    </ul>
  `);

  attachCardClick('.inventory-card', data => `
    <ul class="list-unstyled mt-3">
      <div class="d-flex flex-column align-items-center mb-4">
          <img src="${data.img}" width="200" class="pixel-art">
      </div>
      <li><span class="quest-label mb-3">Item: </span>${data.name}</li>
      <li><span class="quest-label mb-3">Value:</span> 🪙 ${data.value} Gold</li>
      <li><span class="quest-label mb-3">Quantity: </span>${data.qty}x</li>
      <li><span class="quest-label mb-3">Rarity: </span><span class="badge-rarity <?= strtolower($item['rarity']); ?>"><?= htmlspecialchars($item["rarity"]); ?>${data.rarity}</span></li>
      <li><span class="quest-label mb-3">Description: </span>${data.description}</li>
    </ul>
  `);

  closeBtn.addEventListener('click', () => {
    modalOverlay.classList.add('d-none');
  });

  modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) {
      modalOverlay.classList.add('d-none');
    }
  });
});
