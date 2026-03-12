/**
 * Generate WebP and responsive image sizes for performance.
 * Run: npm install && npm run build:images
 */
const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const IMAGES_DIR = path.join(__dirname, '../assets/images');
const SIZES = {
  // Hero: 480 / 960 / 1280 only (no 1920)
  hero: [1280, 960, 480],
  // Content images: 400 / 800 / 1200
  card: [1200, 800, 400],
  // Smaller thumbs where applicable
  thumb: [800, 400],
};

async function processImage(filename) {
  const ext = path.extname(filename).toLowerCase();
  if (!['.jpg', '.jpeg', '.png'].includes(ext)) return;

  const base = path.basename(filename, ext);
  const inputPath = path.join(IMAGES_DIR, filename);

  if (!fs.existsSync(inputPath)) return;

  const meta = await sharp(inputPath).metadata();
  const w = meta.width || 800;

  // Hero images detected by name; everything else uses card/thumb sizes
  let sizes;
  if (/hero/i.test(base)) {
    sizes = SIZES.hero;
  } else {
    sizes = w > 800 ? SIZES.card : SIZES.thumb;
  }
  sizes = [...new Set(sizes)].filter(w => w <= (meta.width || 0)).sort((a, b) => b - a);
  if (sizes.length === 0) sizes = [meta.width];

  for (const w of sizes) {
    const webpPath = path.join(IMAGES_DIR, `${base}-${w}.webp`);
    await sharp(inputPath)
      .resize(w)
      .webp({ quality: 70 }) // target 65–70 for smaller payload
      .toFile(webpPath);
    console.log('  →', path.basename(webpPath));
  }

  const fullWebp = path.join(IMAGES_DIR, `${base}.webp`);
  await sharp(inputPath)
    .webp({ quality: 70 })
    .toFile(fullWebp);
  console.log('  →', path.basename(fullWebp));
}

async function main() {
  const files = fs.readdirSync(IMAGES_DIR).filter(f => /\.(jpg|jpeg|png)$/i.test(f));
  console.log('Processing', files.length, 'images...\n');

  for (const f of files) {
    console.log(f);
    try {
      await processImage(f);
    } catch (e) {
      console.error('  Error:', e.message);
    }
  }
  console.log('\nDone.');
}

main();
