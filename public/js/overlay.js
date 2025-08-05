// document.addEventListener('DOMContentLoaded', () => {
//   const modalOverlay = document.getElementById('modalOverlay');
//   const modalBody = document.getElementById('modalBody');
//   const closeBtn = document.querySelector('.close-btn');

//   // Öffne Modal, wenn eine Quest-Karte angeklickt wird
//   document.querySelectorAll('.quest-card').forEach(card => {
//     card.addEventListener('click', () => {
//       const title = card.dataset.title;
//       const desc = card.dataset.description;
//       const reward = card.dataset.reward;
//       const xp = card.dataset.xp;
//       const created = card.dataset.created;
//       const due = card.dataset.due;

//       modalBody.innerHTML = `
//         <h2>🗺️ ${title}</h2>
//         <p>${desc}</p>
//         <ul class="mt-3">
//           <li><strong>Belohnung:</strong> 🪙 ${reward} Gold</li>
//           <li><strong>XP:</strong> ⭐ ${xp}</li>
//           <li><strong>Erstellt:</strong> ${created}</li>
//           <li><strong>Fällig bis:</strong> ${due}</li>
//         </ul>
//       `;

//       modalOverlay.classList.remove('d-none');
//     });
//   });

//   closeBtn.addEventListener('click', () => modalOverlay.classList.add('d-none'));
//   modalOverlay.addEventListener('click', e => {
//     if (e.target.id === 'modalOverlay') {
//       modalOverlay.classList.add('d-none');
//     }
//   });
// });

// document.addEventListener('DOMContentLoaded', () => {
//   const modalOverlay = document.getElementById('modalOverlay');
//   const modalBody = document.getElementById('modalBody');
//   const closeBtn = modalOverlay.querySelector('.close-btn');

//   // Handler für Karten-Klicks
//   document.querySelectorAll('.quest-card').forEach(card => {
//     card.addEventListener('click', () => {
//       const title = card.dataset.title;
//       const desc = card.dataset.description;
//       const reward = card.dataset.reward;
//       const xp = card.dataset.xp;
//       const created = card.dataset.created;
//       const due = card.dataset.due;

//       modalBody.innerHTML = `
//         <h4 class="mb-3">${title}</h4>
//         <p>${desc}</p>
//         <ul class="list-unstyled mt-3">
//           <li><strong>Belohnung:</strong> 🪙 ${reward} Gold</li>
//           <li><strong>XP:</strong> ⭐ ${xp}</li>
//           <li><strong>Erstellt:</strong> ${created}</li>
//           <li><strong>Fällig bis:</strong> ${due}</li>
//         </ul>
//       `;

//       modalOverlay.classList.remove('d-none');
//     });

//     // Verhindere Modal-Trigger durch Buttons oder Formulare innerhalb der Karte
//     card.querySelectorAll('form, button, a').forEach(el => {
//       el.addEventListener('click', e => e.stopPropagation());
//     });
//   });

//   // Schließen über "X"
//   closeBtn.addEventListener('click', () => {
//     modalOverlay.classList.add('d-none');
//   });

//   // Schließen durch Klick auf Hintergrund
//   modalOverlay.addEventListener('click', (e) => {
//     if (e.target === modalOverlay) {
//       modalOverlay.classList.add('d-none');
//     }
//   });
// });

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
    <h4 class="mb-3">${data.title}</h4>
    <p>${data.description}</p>
    <ul class="list-unstyled mt-3">
      <li><strong>Belohnung:</strong> 🪙 ${data.reward} Gold</li>
      <li><strong>XP:</strong> ⭐ ${data.xp}</li>
      <li><strong>Erstellt:</strong> ${data.created}</li>
      <li><strong>Fällig bis:</strong> ${data.due}</li>
    </ul>
  `);

  attachCardClick('.journal-card', data => `
    <h4 class="mb-3">${data.title}</h4>
    <p>${data.description}</p>
    <p class="mt-3 text-muted"><strong>Erstellt:</strong> ${data.created}</p>
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