const canvas = document.getElementById('avatarCanvas');
const ctx = canvas.getContext('2d');
const scale = 4;

const drawPixel = (x, y, color) => {
  ctx.fillStyle = color;
  ctx.fillRect(x * scale, y * scale, scale, scale);
};

const skinColors = {
  Elf: '#c9b5a6',
  Human: '#f1c27d',
  Orc: '#3a5e3a',
};

const hairColors = {
  Elf: '#5b3e0a',
  Human: '#2c1b0e',
  Orc: '#1b3a1b',
};

const classColors = {
  Mage: { robe: '#3a0ca3', cloak: '#720026' },
  Warrior: { armor: '#666666', cape: '#aa0000' },
  Rouge: { outfit: '#222222', accents: '#cc8800' },
};

function drawHead(race, skinColor, hairColor) {
  // Kopf zeichnen (Beispiel, Kopf 6x6 Pixel)
  for (let x = 4; x < 10; x++) {
    for (let y = 1; y < 7; y++) {
      drawPixel(x, y, skinColor);
    }
  }

  // Ohren je nach Rasse
  if (race === 'Elf') {
    drawPixel(3, 3, skinColor);
    drawPixel(10, 3, skinColor);
  } else if (race === 'Orc') {
    drawPixel(3, 4, '#3a5e3a');
    drawPixel(10, 4, '#3a5e3a');
  }
  // Haare (einfacher Streifen oben)
  for (let x = 4; x < 10; x++) {
    drawPixel(x, 0, hairColor);
  }
}

function drawFace() {
  // Augen
  drawPixel(5, 3, '#000');
  drawPixel(8, 3, '#000');
  // Mund
  drawPixel(6, 6, '#900');
  drawPixel(7, 6, '#900');
}

function drawMageBody(colors) {
  // Robe
  for (let x = 4; x < 10; x++) {
    for (let y = 7; y < 14; y++) {
      drawPixel(x, y, colors.robe);
    }
  }
  // Umhang
  for (let x = 3; x < 11; x++) {
    drawPixel(x, 14, colors.cloak);
  }
}

function drawWarriorBody(colors) {
  // Rüstung
  for (let x = 4; x < 10; x++) {
    for (let y = 7; y < 14; y++) {
      drawPixel(x, y, colors.armor);
    }
  }
  // Umhang
  for (let x = 3; x < 11; x++) {
    drawPixel(x, 14, colors.cape);
  }
}

function drawRougeBody(colors) {
  // Kleidung
  for (let x = 4; x < 10; x++) {
    for (let y = 7; y < 14; y++) {
      drawPixel(x, y, colors.outfit);
    }
  }
  // Akzente
  for (let x = 3; x < 11; x++) {
    drawPixel(x, 14, colors.accents);
  }
}

function drawAvatar(race, klass) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  const skinColor = skinColors[race] || '#f0c27d';
  const hairColor = hairColors[race] || '#000';
  const colors = classColors[klass] || classColors.Mage;

  drawHead(race, skinColor, hairColor);
  drawFace();

  if (klass === 'Mage') {
    drawMageBody(colors);
  } else if (klass === 'Warrior') {
    drawWarriorBody(colors);
  } else if (klass === 'Rouge') {
    drawRougeBody(colors);
  }
}

// Macht die Funktion global zugreifbar
window.drawAvatar = drawAvatar;
