/*
 * Texturas del rack, generadas con canvas.
 *
 * Ni un fichero que descargar. Cada superficie sale en pareja —color y
 * normales— porque es el mapa de normales el que hace el trabajo: sin él, los
 * agujeros de los raíles y las perforaciones de las rejillas son manchas
 * oscuras pintadas y la luz les pasa por encima sin enterarse.
 *
 * El relieve va en la textura y no en la malla a propósito. A la distancia a
 * la que se ve el rack no se distingue, y agujerear la geometría de verdad
 * exigiría operaciones booleanas que costarían mucho más de lo que aportan.
 */

import { CanvasTexture, RepeatWrapping, SRGBColorSpace } from 'three';

export function lienzo(ancho, alto) {
    const c = document.createElement('canvas');
    c.width = ancho;
    c.height = alto;
    return [c, c.getContext('2d', { willReadFrequently: true })];
}

/** Textura de color: va en espacio sRGB porque representa color. */
function texturaColor(canvas, repeticiones = [1, 1]) {
    const t = new CanvasTexture(canvas);
    t.colorSpace = SRGBColorSpace;
    t.wrapS = t.wrapT = RepeatWrapping;
    t.repeat.set(...repeticiones);
    t.anisotropy = 8;
    return t;
}

/** Textura de datos (normales, rugosidad, oclusión): NO lleva conversión sRGB. */
function texturaDatos(canvas, repeticiones = [1, 1]) {
    const t = new CanvasTexture(canvas);
    t.wrapS = t.wrapT = RepeatWrapping;
    t.repeat.set(...repeticiones);
    t.anisotropy = 8;
    return t;
}

/**
 * Convierte un mapa de alturas en escala de grises a un mapa de normales.
 *
 * Se mira cuánto sube o baja la altura a izquierda/derecha y arriba/abajo de
 * cada píxel (un Sobel de toda la vida) y de esa pendiente sale hacia dónde
 * mira la superficie. Es lo que permite que un agujero pintado tenga sombra
 * dentro y brillo en el canto sin tocar la geometría.
 *
 * `fuerza` exagera el relieve: por encima de 3 se nota falso.
 */
export function alturaANormal(canvasAlturas, fuerza = 2) {
    const { width: an, height: al } = canvasAlturas;
    const origen = canvasAlturas.getContext('2d', { willReadFrequently: true })
        .getImageData(0, 0, an, al).data;

    const [destino, ctx] = lienzo(an, al);
    const salida = ctx.createImageData(an, al);

    // Altura del píxel (x, y), con los bordes envueltos: las texturas se repiten.
    const alturaEn = (x, y) => {
        const px = ((y + al) % al) * an + ((x + an) % an);
        return origen[px * 4] / 255;
    };

    for (let y = 0; y < al; y++) {
        for (let x = 0; x < an; x++) {
            const dx =
                (alturaEn(x - 1, y - 1) + 2 * alturaEn(x - 1, y) + alturaEn(x - 1, y + 1)) -
                (alturaEn(x + 1, y - 1) + 2 * alturaEn(x + 1, y) + alturaEn(x + 1, y + 1));

            const dy =
                (alturaEn(x - 1, y - 1) + 2 * alturaEn(x, y - 1) + alturaEn(x + 1, y - 1)) -
                (alturaEn(x - 1, y + 1) + 2 * alturaEn(x, y + 1) + alturaEn(x + 1, y + 1));

            // Normalizar el vector (dx, dy, 1/fuerza) y llevarlo a 0..255.
            const nx = dx * fuerza;
            const ny = dy * fuerza;
            const largo = Math.hypot(nx, ny, 1);

            const i = (y * an + x) * 4;
            salida.data[i] = ((nx / largo) * 0.5 + 0.5) * 255;
            salida.data[i + 1] = ((ny / largo) * 0.5 + 0.5) * 255;
            salida.data[i + 2] = ((1 / largo) * 0.5 + 0.5) * 255;
            salida.data[i + 3] = 255;
        }
    }

    ctx.putImageData(salida, 0, 0);
    return destino;
}

/* --------------------------------------------------------------------------
 * Raíl de montaje
 *
 * El patrón de tres agujeros cuadrados por U es lo que hace que un rack se
 * reconozca al instante, así que es la textura que más se mira: va a 128×256
 * por U en vez de los 32×64 que tenía.
 * -------------------------------------------------------------------------- */
export function texturasRail(repeticiones, escala = 1) {
    const AN = Math.round(128 * escala);
    const AL = Math.round(256 * escala);
    const lado = Math.round(AN * 0.42);
    const centros = [0.25, 0.5, 0.75].map((f) => Math.round(AL * f));

    // --- color ---
    const [color, ctx] = lienzo(AN, AL);
    ctx.fillStyle = '#333944';
    ctx.fillRect(0, 0, AN, AL);

    // Los cantos doblados del perfil, más oscuros.
    const grad = ctx.createLinearGradient(0, 0, AN, 0);
    grad.addColorStop(0, 'rgba(0,0,0,0.5)');
    grad.addColorStop(0.22, 'rgba(255,255,255,0.05)');
    grad.addColorStop(0.78, 'rgba(255,255,255,0.03)');
    grad.addColorStop(1, 'rgba(0,0,0,0.5)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, AN, AL);

    ctx.fillStyle = '#07090c';
    centros.forEach((cy) => ctx.fillRect((AN - lado) / 2, cy - lado / 2, lado, lado));

    // --- alturas: el agujero hundido, con su bisel ---
    const [alturas, hctx] = lienzo(AN, AL);
    hctx.fillStyle = '#b4b4b4';
    hctx.fillRect(0, 0, AN, AL);

    centros.forEach((cy) => {
        const x = (AN - lado) / 2;
        const y = cy - lado / 2;
        // Halo claro alrededor = el reborde troquelado.
        hctx.fillStyle = '#d8d8d8';
        hctx.fillRect(x - 2, y - 2, lado + 4, lado + 4);
        hctx.fillStyle = '#101010';
        hctx.fillRect(x, y, lado, lado);
    });

    return {
        color: texturaColor(color, [1, repeticiones]),
        normal: texturaDatos(alturaANormal(alturas, 2.6), [1, repeticiones]),
    };
}

/* --------------------------------------------------------------------------
 * Rejilla de ventilación perforada
 * -------------------------------------------------------------------------- */
export function texturasMalla(escala = 1) {
    const AN = Math.round(512 * escala);
    const AL = Math.round(256 * escala);
    const columnas = 34;
    const filas = 14;
    const pasoX = AN / columnas;
    const pasoY = AL / filas;
    const radio = Math.min(pasoX, pasoY) * 0.32;

    const puntos = [];
    for (let f = 0; f < filas; f++) {
        for (let i = 0; i < columnas; i++) {
            // Filas alternas desplazadas: es como se troquela de verdad.
            puntos.push([i * pasoX + (f % 2 ? pasoX / 2 : 0) + pasoX / 2, f * pasoY + pasoY / 2]);
        }
    }

    const [color, ctx] = lienzo(AN, AL);
    ctx.fillStyle = '#3c424b';
    ctx.fillRect(0, 0, AN, AL);
    ctx.fillStyle = '#080a0d';
    puntos.forEach(([x, y]) => {
        ctx.beginPath();
        ctx.arc(x, y, radio, 0, Math.PI * 2);
        ctx.fill();
    });

    const [alturas, hctx] = lienzo(AN, AL);
    hctx.fillStyle = '#c0c0c0';
    hctx.fillRect(0, 0, AN, AL);
    puntos.forEach(([x, y]) => {
        hctx.fillStyle = '#0d0d0d';
        hctx.beginPath();
        hctx.arc(x, y, radio, 0, Math.PI * 2);
        hctx.fill();
    });

    return {
        color: texturaColor(color),
        normal: texturaDatos(alturaANormal(alturas, 2.2)),
        // La chapa perforada refleja distinto dentro del agujero que fuera.
        oclusion: texturaDatos(color),
    };
}

/* --------------------------------------------------------------------------
 * Acero cepillado
 *
 * El grano va marcadamente horizontal: es lo que da el brillo alargado del
 * acero cepillado, y con un ruido isótropo no aparece.
 * -------------------------------------------------------------------------- */
export function texturasCepillado(escala = 1) {
    const LADO = Math.round(512 * escala);

    const [rugosidad, ctx] = lienzo(LADO, LADO);
    ctx.fillStyle = '#8f8f8f';
    ctx.fillRect(0, 0, LADO, LADO);

    for (let i = 0; i < LADO * 14; i++) {
        const y = Math.random() * LADO;
        const x = Math.random() * LADO;
        const largo = 30 + Math.random() * 180;
        const claro = Math.random() > 0.5;
        ctx.strokeStyle = `rgba(${claro ? 255 : 0},${claro ? 255 : 0},${claro ? 255 : 0},0.05)`;
        ctx.lineWidth = Math.random() < 0.25 ? 1.6 : 0.8;
        ctx.beginPath();
        ctx.moveTo(x, y);
        ctx.lineTo(x + largo, y + (Math.random() - 0.5) * 1.5);
        ctx.stroke();
    }

    // El mismo grano sirve de alturas: son surcos finísimos.
    return {
        rugosidad: texturaDatos(rugosidad, [3, 3]),
        normal: texturaDatos(alturaANormal(rugosidad, 0.7), [3, 3]),
    };
}

/* --------------------------------------------------------------------------
 * Frontales serigrafiados
 *
 * Un panel de parcheo real lleva los puertos numerados. Es un detalle pequeño
 * pero es de los que el ojo reconoce sin saber que los está mirando.
 * -------------------------------------------------------------------------- */
export function texturaSerigrafia(etiqueta = '') {
    const AN = 1024;
    const AL = 96;
    const [c, ctx] = lienzo(AN, AL);
    const COLUMNAS = 12;

    ctx.fillStyle = '#262b33';
    ctx.fillRect(0, 0, AN, AL);

    /*
     * Doce números, uno por columna de puertos. El plano que lleva esta
     * textura mide justo la rejilla de puertos, así que repartirlos a intervalos
     * iguales los deja alineados con cada columna.
     */
    const margen = (0.26 / (0.355 * 11 + 0.26)) * AN / 2;
    const util = AN - margen * 2;

    ctx.fillStyle = '#aab2be';
    ctx.font = '700 40px system-ui, sans-serif';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';

    for (let i = 0; i < COLUMNAS; i++) {
        ctx.fillText(String(i + 1), margen + (util / (COLUMNAS - 1)) * i, AL * 0.42);
    }

    if (etiqueta) {
        ctx.fillStyle = '#6e7783';
        ctx.font = '600 26px system-ui, sans-serif';
        ctx.textAlign = 'left';
        ctx.fillText(etiqueta, margen, AL * 0.84);
    }

    return texturaColor(c);
}

/* --------------------------------------------------------------------------
 * Pantallas LCD
 *
 * Un rectángulo verde plano se lee como plástico de color. Con contenido
 * —barras, dígitos— se lee como una pantalla encendida.
 * -------------------------------------------------------------------------- */
export function texturaPantalla(tipo = 'sai') {
    const AN = 256;
    const AL = 96;
    const [c, ctx] = lienzo(AN, AL);

    ctx.fillStyle = '#04140c';
    ctx.fillRect(0, 0, AN, AL);

    ctx.fillStyle = '#3ee08a';

    if (tipo === 'sai') {
        // Barra de carga de batería y un porcentaje.
        ctx.fillRect(16, 22, 150, 22);
        ctx.fillStyle = '#0a1f14';
        ctx.fillRect(120, 25, 43, 16);
        ctx.fillStyle = '#3ee08a';
        ctx.font = '700 30px ui-monospace, monospace';
        ctx.textBaseline = 'middle';
        ctx.fillText('87%', 176, 33);

        ctx.font = '500 18px ui-monospace, monospace';
        ctx.fillText('ON LINE', 16, 68);
    } else {
        // Cortafuegos: unas barras de tráfico.
        ctx.font = '500 17px ui-monospace, monospace';
        ctx.textBaseline = 'middle';
        ctx.fillText('WAN  ok', 14, 22);
        for (let i = 0; i < 14; i++) {
            const h = 8 + Math.random() * 34;
            ctx.fillRect(14 + i * 16, 78 - h, 10, h);
        }
    }

    const t = texturaColor(c);
    t.wrapS = t.wrapT = RepeatWrapping;
    return t;
}
