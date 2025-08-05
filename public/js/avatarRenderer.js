const canvas = document.getElementById('avatarCanvas');
const ctx = canvas.getContext('2d');

// Konstante Sprite Größe
const spriteWidth = 32;
const spriteHeight = 32;

// Dein Sprite Sheet laden
const spriteSheet = new Image();
spriteSheet.src = 'sprites/spriteSheet.png';  // Pfad anpassen

// Zuordnung: welche Rasse+Klasse liegt an welcher Spalte
const spriteMap = {
    Human: { Warrior: 0, Mage: 1, Rouge: 2 },
    Elf:   { Warrior: 3, Mage: 4, Rouge: 5 },
    Orc:   { Warrior: 6, Mage: 7, Rouge: 8 },
};

// Avatar zeichnen
function drawAvatar(race, klass) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    spriteSheet.onload = () => {
        drawCharacter(race, klass);
    };

    // falls Bild schon geladen
    if (spriteSheet.complete) {
        drawCharacter(race, klass);
    }
}

function drawCharacter(race, klass) {
    const col = spriteMap[race][klass];
    ctx.imageSmoothingEnabled = false; // für Pixel-Look

    ctx.drawImage(
        spriteSheet,
        col * spriteWidth, 0,            // Quelle x,y
        spriteWidth, spriteHeight,       // Quelle w,h
        0, 0,                            // Ziel x,y
        spriteWidth * 2, spriteHeight * 2 // Ziel w,h (4x Zoom)
    );
}

// global für dein Dashboard zugänglich machen
window.drawAvatar = drawAvatar;
