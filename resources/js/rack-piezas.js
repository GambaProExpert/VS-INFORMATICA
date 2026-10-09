/*
 * Piezas y texturas del rack.
 *
 * Separado de rack.js para que allí quede solo la escena (luz, cámara,
 * recorrido) y aquí la carpintería: medidas reales, texturas generadas con
 * canvas y el frontal de cada tipo de equipo.
 *
 * Todo va en unidades de escena donde 1 unidad = 100 mm, así que las medidas
 * se pueden contrastar con un catálogo: un rack de 42U son 600 mm de ancho por
 * 2.000 de alto, y una U son 44,45 mm.
 */

import {
    BoxGeometry,
    CatmullRomCurve3,
    Group,
    InstancedMesh,
    Mesh,
    MeshStandardMaterial,
    Object3D,
    PlaneGeometry,
    TubeGeometry,
    Vector3,
} from 'three';
import { RoundedBoxGeometry } from 'three/examples/jsm/geometries/RoundedBoxGeometry.js';

/* --------------------------------------------------------------------------
 * Medidas (mm / 100)
 * -------------------------------------------------------------------------- */
export const U = 0.4445;        // una unidad de rack: 44,45 mm
export const UNIDADES_RACK = 42;
export const ANCHO_EXT = 6.0;   // 600 mm, el ancho estándar de un armario
export const FONDO = 6.0;       // 600 mm: el fondo de un armario de red
export const ALTO_UTIL = UNIDADES_RACK * U;
export const ZOCALO = 1.0;
export const TECHO = 0.45;

/** Cara frontal de los equipos: 19" entre orejas, 17,5" el chasis. */
export const ANCHO_OREJAS = 4.826;
export const ANCHO_CHASIS = 4.445;
export const RAIL_X = ANCHO_OREJAS / 2;

/*
 * Ancho del rótulo serigrafiado. Cubre exactamente la rejilla de 12 puertos
 * (del centro del primero al del último, más medio puerto por lado) para que
 * cada número caiga sobre su columna.
 */
export const PASO_PUERTO = 0.355;
export const ANCHO_ROTULO = PASO_PUERTO * 11 + 0.26;

/*
 * El plano del frente: donde queda la cara delantera de TODO lo que se monta
 * en el rack, igual que en uno de verdad, donde todos los frontales quedan
 * enrasados contra el raíl.
 *
 * Es un valor compartido a propósito. Cuando el chasis y sus detalles se
 * colocaban cada uno a su profundidad, los puertos y las rejillas flotaban
 * delante del equipo y se veía el interior hueco del armario por los huecos.
 */
export const Z_FRENTE = FONDO / 2 - 0.05;

/* --------------------------------------------------------------------------
 * Utilidades de geometría
 * -------------------------------------------------------------------------- */

/*
 * Toda caja del rack lleva las aristas matadas.
 *
 * Un canto de 90° exactos es de las cosas que más delatan que algo es 3D: la
 * chapa real tiene un radio pequeño que atrapa una línea de luz en cada arista.
 * El radio se limita a un tercio de la dimensión menor para que las piezas
 * finas —tornillos, tiradores— no se conviertan en cápsulas.
 */
export function caja(ancho, alto, fondo, material, radio = 0.012) {
    const r = Math.min(radio, Math.min(ancho, alto, fondo) / 3);
    const geo = new RoundedBoxGeometry(ancho, alto, fondo, 2, r);

    conOclusion(geo);

    return new Mesh(geo, material);
}

/**
 * Three.js lee el mapa de oclusión del SEGUNDO juego de coordenadas, no del
 * primero. Copiarlo es una línea y sin ella el aoMap sencillamente no se ve.
 */
export function conOclusion(geometria) {
    if (geometria.attributes.uv && ! geometria.attributes.uv1) {
        geometria.setAttribute('uv1', geometria.attributes.uv);
    }
    return geometria;
}

/**
 * Muchas piezas iguales en una sola llamada de dibujo. Un rack de 42U lleva
 * cientos de tornillos y puertos; sin esto son cientos de llamadas.
 */
export function repetir(geometria, material, posiciones) {
    const malla = new InstancedMesh(geometria, material, posiciones.length);
    const temp = new Object3D();

    posiciones.forEach((p, i) => {
        temp.position.set(p[0], p[1], p[2]);
        temp.updateMatrix();
        malla.setMatrixAt(i, temp.matrix);
    });

    malla.instanceMatrix.needsUpdate = true;

    return malla;
}

/* --------------------------------------------------------------------------
 * Latiguillos
 *
 * Lo que de verdad delata a un rack no es la textura del metal: es el
 * cableado. Un panel de parcheo sin un solo cable se lee como expositor de
 * tienda.
 *
 * Van de un puerto del panel a un puerto del switch, pasando por la guía de
 * cables que hay entre medias, con la caída natural que hace un latiguillo. Y
 * van ORDENADOS, que es justo lo que afirma el texto de la primera tarjeta.
 * -------------------------------------------------------------------------- */

const COLORES_CABLE = [0x2f6fd0, 0x2f6fd0, 0x3b82c4, 0x6b7480, 0x9aa3ae, 0x2f6fd0];

export function latiguillos(yPanel, yGuia, ySwitch, mats) {
    const g = new Group();
    const cuantos = 10;

    for (let i = 0; i < cuantos; i++) {
        const x = -1.72 + i * 0.36;
        // Los del panel y los del switch no caen en el mismo puerto: se cruzan
        // un poco, como en la realidad.
        const xDestino = x + (i % 3 === 0 ? 0.36 : -0.18);
        const salida = 0.16 + (i % 4) * 0.05;   // cuánto se separa del frontal

        const curva = new CatmullRomCurve3([
            new Vector3(x, yPanel, Z_FRENTE + 0.04),
            new Vector3(x, yPanel - 0.1, Z_FRENTE + salida),
            new Vector3((x + xDestino) / 2, yGuia, Z_FRENTE + salida + 0.06),
            new Vector3(xDestino, ySwitch + 0.1, Z_FRENTE + salida),
            new Vector3(xDestino, ySwitch, Z_FRENTE + 0.04),
        ]);

        const tubo = new Mesh(
            new TubeGeometry(curva, 24, 0.022, 6, false),
            mats.cable[i % mats.cable.length],
        );
        tubo.castShadow = true;
        g.add(tubo);
    }

    return g;
}

/** Los materiales de los cables, uno por color de la paleta de red. */
export function materialesCable() {
    return COLORES_CABLE.map((color) =>
        new MeshStandardMaterial({ color, roughness: 0.55, metalness: 0.05 }));
}

/* --------------------------------------------------------------------------
 * Frontales
 *
 * Cada tipo de equipo con lo que de verdad se le ve por delante.
 * -------------------------------------------------------------------------- */

/** Orejas de montaje con sus dos tornillos: así se sujeta al raíl. */
function orejas(altoU, mats) {
    const g = new Group();
    const alto = altoU * U;

    [-1, 1].forEach((lado) => {
        const oreja = caja(0.19, alto * 0.94, 0.05, mats.chapa);
        oreja.position.set(lado * (ANCHO_OREJAS / 2 - 0.095), 0, Z_FRENTE + 0.025);
        g.add(oreja);
    });

    const tornillos = [];
    [-1, 1].forEach((lado) => {
        const x = lado * (ANCHO_OREJAS / 2 - 0.095);
        if (altoU >= 2) {
            tornillos.push([x, alto * 0.3, Z_FRENTE + 0.06], [x, -alto * 0.3, Z_FRENTE + 0.06]);
        } else {
            tornillos.push([x, 0, Z_FRENTE + 0.06]);
        }
    });

    g.add(repetir(new BoxGeometry(0.07, 0.07, 0.03), mats.tornillo, tornillos));

    return g;
}

export function frontal(tipo, altoU, mats) {
    const g = new Group();
    const alto = altoU * U;
    const z = Z_FRENTE + 0.03;

    g.add(orejas(altoU, mats));

    if (tipo === 'ciega') {
        // Tapa ciega: chapa lisa. Es la mitad de un rack de verdad.
        return g;
    }

    if (tipo === 'bandeja') {
        for (let i = 0; i < 5; i++) {
            const anilla = caja(0.1, alto * 0.55, 0.22, mats.chapa);
            anilla.position.set(-1.6 + i * 0.8, 0, z + 0.1);
            g.add(anilla);
        }
        return g;
    }

    if (tipo === 'guia') {
        for (let i = 0; i < 6; i++) {
            const peine = caja(0.14, alto * 0.6, 0.16, mats.plastico);
            peine.position.set(-1.75 + i * 0.7, 0, z + 0.07);
            g.add(peine);
        }
        return g;
    }

    if (tipo === 'patch' || tipo === 'switch') {
        // 24 puertos RJ45 en dos filas, como cualquier panel o switch de 24.
        const puertos = [];
        for (let fila = 0; fila < 2; fila++) {
            for (let i = 0; i < 12; i++) {
                puertos.push([-1.95 + i * 0.355, fila ? -alto * 0.2 : alto * 0.2, z]);
            }
        }
        g.add(repetir(new BoxGeometry(0.26, 0.17, 0.05), mats.hueco, puertos));

        /*
         * Serigrafía: la numeración de los puertos.
         *
         * Va sobre un PlaneGeometry y no sobre una caja. RoundedBoxGeometry
         * reparte las coordenadas de textura de otra manera por culpa de los
         * biseles, así que el rótulo salía troceado e ilegible. Un plano tiene
         * las UV limpias de 0 a 1 y el texto cae donde toca.
         */
        const rotulo = new Mesh(
            new PlaneGeometry(ANCHO_ROTULO, alto * 0.22),
            tipo === 'patch' ? mats.serigrafiaPatch : mats.serigrafiaSwitch,
        );
        rotulo.position.set(0, alto * 0.4, z + 0.001);
        g.add(rotulo);

        if (tipo === 'switch') {
            // Los pilotos de enlace, que es lo que distingue un switch de un
            // panel de parcheo pasivo.
            const leds = [];
            for (let i = 0; i < 12; i++) {
                leds.push([-1.95 + i * 0.355, alto * 0.38, z]);
            }
            g.add(repetir(new BoxGeometry(0.05, 0.04, 0.03), mats.ledVerde, leds));

            const consola = caja(0.3, 0.14, 0.05, mats.hueco);
            consola.position.set(2.05, -alto * 0.2, z);
            g.add(consola);
        }
        return g;
    }

    if (tipo === 'firewall') {
        const puertos = [];
        for (let i = 0; i < 8; i++) puertos.push([-1.7 + i * 0.42, -alto * 0.18, z]);
        g.add(repetir(new BoxGeometry(0.3, 0.2, 0.05), mats.hueco, puertos));

        const pantalla = caja(1.15, 0.2, 0.04, mats.pantallaFirewall, 0.004);
        pantalla.position.set(1.45, alto * 0.22, z);
        g.add(pantalla);
        return g;
    }

    if (tipo === 'servidor') {
        // Rejilla de ventilación en el centro y dos bahías a un lado.
        const rejilla = caja(2.5, alto * 0.66, 0.03, mats.malla);
        rejilla.position.set(-0.55, 0, z);
        g.add(rejilla);

        for (let i = 0; i < 2; i++) {
            const bahia = caja(0.62, alto * 0.66, 0.06, mats.bahia);
            bahia.position.set(1.05 + i * 0.7, 0, z);
            g.add(bahia);
        }

        const boton = caja(0.12, 0.12, 0.05, mats.hueco);
        boton.position.set(-1.95, alto * 0.3, z);
        g.add(boton);

        g.add(repetir(new BoxGeometry(0.06, 0.05, 0.03), mats.ledVerde, [
            [-1.95, -alto * 0.28, z],
            [-1.72, -alto * 0.28, z],
        ]));
        return g;
    }

    if (tipo === 'bahias') {
        // Cabina de discos: filas de bandejas extraíbles con su tirador.
        const filas = altoU >= 3 ? 3 : 2;
        const porFila = 4;
        const altoBahia = (alto * 0.86) / filas;

        for (let f = 0; f < filas; f++) {
            const y = (alto * 0.86) / 2 - altoBahia / 2 - f * altoBahia;
            for (let i = 0; i < porFila; i++) {
                const x = -1.65 + i * 1.1;

                const bahia = caja(1.0, altoBahia * 0.88, 0.07, mats.bahia);
                bahia.position.set(x, y, z);
                g.add(bahia);

                const tirador = caja(0.09, altoBahia * 0.6, 0.05, mats.chapa);
                tirador.position.set(x - 0.42, y, z + 0.05);
                g.add(tirador);
            }
        }

        const leds = [];
        for (let f = 0; f < filas; f++) {
            const y = (alto * 0.86) / 2 - altoBahia / 2 - f * altoBahia;
            for (let i = 0; i < porFila; i++) leds.push([-1.65 + i * 1.1 + 0.4, y, z + 0.04]);
        }
        g.add(repetir(new BoxGeometry(0.05, 0.05, 0.03), mats.ledVerde, leds));
        return g;
    }

    if (tipo === 'sai') {
        const pantalla = caja(1.5, alto * 0.34, 0.04, mats.pantallaSai, 0.004);
        pantalla.position.set(-1.25, alto * 0.12, z);
        g.add(pantalla);

        const rejilla = caja(1.6, alto * 0.5, 0.03, mats.malla);
        rejilla.position.set(1.2, -alto * 0.08, z);
        g.add(rejilla);

        g.add(repetir(new BoxGeometry(0.16, 0.16, 0.05), mats.hueco, [
            [-0.1, -alto * 0.26, z],
            [0.2, -alto * 0.26, z],
        ]));
        return g;
    }

    return g;
}

