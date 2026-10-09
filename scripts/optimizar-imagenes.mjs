/*
 * Genera las variantes optimizadas de las imágenes del sitio.
 *
 *   node scripts/optimizar-imagenes.mjs
 *
 * Qué hace:
 *   1. Un .webp junto a cada .jpg/.png de public/images (el original se queda
 *      al lado como respaldo; son ficheros pequeños, de 2 a 70 KB).
 *   2. Las 38 capturas de a3ERP viven en resources/imagenes-originales/, no en
 *      public/, porque son de 1280×1024 y suman 7,6 MB que nadie descarga
 *      nunca: lo que se sirve es el .webp y la miniatura de 480 px. Dejarlas
 *      en public/ sería subirlas al servidor en cada despliegue para nada.
 *
 * Sin AVIF a propósito: el visor de la galería pinta una sola <img> con el src
 * enlazado a Alpine, y un <picture> no sirve ahí — el navegador resuelve los
 * <source> al analizar el HTML, antes de que Alpine cambie nada. WebP lo
 * soporta todo lo que sigue vivo desde 2020.
 *
 * No modifica ningún original. Es idempotente: se puede lanzar las veces que
 * haga falta.
 */

import sharp from 'sharp';
import { readdir, stat, mkdir } from 'node:fs/promises';
import { existsSync } from 'node:fs';
import path from 'node:path';

const PUBLICAS = 'public/images';
const ORIGINALES_GALERIA = 'resources/imagenes-originales/a3erp-galeria';
const GALERIA = path.join(PUBLICAS, 'a3erp', 'galeria');
const MINIS = path.join(GALERIA, 'mini');

const esImagen = (f) => /\.(jpe?g|png)$/i.test(f);

async function* recorrer(dir) {
    for (const entrada of await readdir(dir)) {
        const ruta = path.join(dir, entrada);
        if ((await stat(ruta)).isDirectory()) {
            yield* recorrer(ruta);
        } else if (esImagen(entrada)) {
            yield ruta;
        }
    }
}

const kb = (n) => (n / 1024).toFixed(0) + ' KB';

async function main() {
    if (!existsSync(MINIS)) await mkdir(MINIS, { recursive: true });

    // ---- 1. Imágenes normales del sitio ------------------------------------
    let convertidas = 0;
    let ahorro = 0;

    for await (const origen of recorrer(PUBLICAS)) {
        if (origen.includes(`${path.sep}mini${path.sep}`)) continue;

        const destino = origen.replace(/\.(jpe?g|png)$/i, '.webp');
        const antes = (await stat(origen)).size;

        await sharp(origen).webp({ quality: 82, effort: 5 }).toFile(destino);

        ahorro += antes - (await stat(destino)).size;
        convertidas++;
    }

    console.log(`${convertidas} imágenes del sitio convertidas a WebP · ${kb(ahorro)} menos`);

    // ---- 2. Galería de a3ERP -----------------------------------------------
    if (!existsSync(ORIGINALES_GALERIA)) {
        console.log('No hay originales de la galería; me la salto.');
        return;
    }

    let capturas = 0;

    for (const fichero of await readdir(ORIGINALES_GALERIA)) {
        if (!esImagen(fichero)) continue;

        const origen = path.join(ORIGINALES_GALERIA, fichero);
        const nombre = path.basename(fichero, path.extname(fichero));

        // Grande, para el visor.
        await sharp(origen)
            .webp({ quality: 80, effort: 5 })
            .toFile(path.join(GALERIA, `${nombre}.webp`));

        // Miniatura, que es lo único que se descarga al abrir la página.
        await sharp(origen)
            .resize({ width: 480, withoutEnlargement: true })
            .webp({ quality: 78 })
            .toFile(path.join(MINIS, `${nombre}.webp`));

        capturas++;
    }

    console.log(`${capturas} capturas de a3ERP: grande + miniatura de 480 px`);
}

main().catch((e) => {
    console.error(e);
    process.exit(1);
});
