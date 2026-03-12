/**
 * Generate WebP, AVIF (hero only), and responsive image sizes for performance.
 * Run: npm install && npm run build:images
 */
const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const IMAGES_DIR = path.join(__dirname, '../assets/images');
const QUALITY = 65;
const SIZES = {
  hero: [1280, 960, 480],
  card: [1200, 800, 400],
  thumb: [800, 400],
};

async function processImage(filename) {
  const ext = path.extname(filename).toLowerCase();
  if (!['.jpg', '.jpeg', '.png'].includes(ext)) return;

  const base = path.basename(filename, ext);
  const inputPath = path.join(IMAGES_DIR, filename);

  if (!fs.existsSync(inputPath)) return;

  const meta = await sharp(inputPath).metadata();
  const imgW = meta.width || 800;

  let sizes;
  if (/hero/i.test(base)) {
    sizes = SIZES.hero;
  } else {
    sizes = imgW > 800 ? SIZES.card : SIZES.thumb;
  }
  sizes = [...new Set(sizes)].filter(s => s <= imgW).sort((a, b) => b - a);
  if (sizes.length === 0) sizes = [imgW];

  for (const w of sizes) {
    const webpPath = path.join(IMAGES_DIR, `${base}-${w}.webp`);
    await sharp(inputPath)
      .resize(w)
      .webp({ quality: QUALITY })
      .toFile(webpPath);
    console.log('  →', path.basename(webpPath));
  }

  const fullWebp = path.join(IMAGES_DIR, `${base}.webp`);
  await sharp(inputPath)
    .webp({ quality: QUALITY })
    .toFile(fullWebp);
  console.log('  →', path.basename(fullWebp));

  // Hero: also generate AVIF for better compression
  if (/hero/i.test(base)) {
    for (const w of sizes) {
      const avifPath = path.join(IMAGES_DIR, `${base}-${w}.avif`);
      await sharp(inputPath)
        .resize(w)
        .avif({ quality: QUALITY })
        .toFile(avifPath);
      console.log('  →', path.basename(avifPath));
    }
  }
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
