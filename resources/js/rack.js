/*
 * Rack 3D de la home: un armario de pie de 42U.
 *
 * Este módulo lo carga rack-cargador.js con import() dinámico, así que Three.js
 * NO entra en el paquete principal: solo se descarga si alguien baja hasta la
 * sección del rack.
 *
 * Está construido por código, no cargado de un .glb. No hay ningún modelo de
 * rack de 19" con licencia CC0 que se pueda empaquetar, y para un armario que
 * son chapas, raíles y frontales compensa: sale con los colores de la marca,
 * cambia con el tema claro/oscuro, y cada unidad es un objeto al que se le
 * puede hablar por separado.
 */

import {
    ACESFilmicToneMapping,
    AmbientLight,
    BoxGeometry,
    Color,
    DirectionalLight,
    Group,
    Mesh,
    MeshStandardMaterial,
    PCFSoftShadowMap,
    PerspectiveCamera,
    PlaneGeometry,
    PMREMGenerator,
    PointLight,
    Scene,
    ShadowMaterial,
    Vector2,
    Vector3,
    WebGLRenderer,
} from 'three';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';

import {
    ALTO_UTIL,
    ANCHO_CHASIS,
    ANCHO_EXT,
    FONDO,
    RAIL_X,
    TECHO,
    U,
    UNIDADES_RACK,
    ZOCALO,
    Z_FRENTE,
    caja,
    conOclusion,
    frontal,
    latiguillos,
    materialesCable,
    repetir,
} from './rack-piezas';
import {
    texturaPantalla,
    texturaSerigrafia,
    texturasCepillado,
    texturasMalla,
    texturasRail,
} from './rack-texturas';

/* --------------------------------------------------------------------------
 * Qué lleva dentro el rack
 *
 * De arriba abajo, en unidades de rack. Colocado como se coloca de verdad: el
 * panel de parcheo arriba del todo, junto a la entrada de cable, y el SAI abajo
 * porque pesa treinta kilos y sube el centro de gravedad.
 *
 * Los `servicio` son los seis que enlazan con las páginas, y su orden tiene que
 * coincidir con el de las tarjetas de rack-3d.blade.php.
 *
 * `u` es la unidad más alta que ocupa la pieza, contando desde abajo (U1 es la
 * de más abajo, U42 la de arriba). Las entradas tienen que embaldosar las 42
 * sin huecos ni solapes: 2+1+1+1+1+1+3+2+2+1+3+5+2+10+4+3 = 42.
 * -------------------------------------------------------------------------- */
const CONTENIDO = [
    { u: 42, alto: 2, tipo: 'bandeja' },
    { u: 40, alto: 1, tipo: 'patch',    servicio: 0 },
    { u: 39, alto: 1, tipo: 'guia' },
    { u: 38, alto: 1, tipo: 'switch',   servicio: 1 },
    { u: 37, alto: 1, tipo: 'ciega' },
    { u: 36, alto: 1, tipo: 'firewall', servicio: 2 },
    { u: 35, alto: 3, tipo: 'ciega' },
    { u: 32, alto: 2, tipo: 'servidor' },
    { u: 30, alto: 2, tipo: 'servidor', servicio: 3 },
    { u: 28, alto: 1, tipo: 'ciega' },
    { u: 27, alto: 3, tipo: 'bahias',   servicio: 4 },
    { u: 24, alto: 3, tipo: 'ciega' },
    { u: 21, alto: 2, tipo: 'servidor' },
    { u: 19, alto: 2, tipo: 'ciega' },
    { u: 17, alto: 4, tipo: 'sai',      servicio: 5 },
    { u: 13, alto: 13, tipo: 'ciega' },
];

/*
 * Encuadre: plano general al entrar, acercamiento al recorrer.
 *
 * Las distancias no son a ojo. Con un campo de visión vertical de 32°, la
 * altura que entra en plano es 2·d·tan(16°) ≈ 0,574·d. El armario mide unas
 * 20,3 unidades de alto, así que para verlo entero con algo de aire hacen
 * falta ~23 / 0,574 ≈ 40 de distancia. Quedarse corto es lo que hacía que la
 * cámara acabara metida dentro del rack mirando el panel lateral.
 *
 * De cerca se busca encuadrar unas 12U (5,3 unidades) más margen: ~11.
 */
const CAMARA = {
    lejos: { z: 44, x: 7.2 },
    cerca: { z: 14.5, x: 3 },
};


const FOV = 32;

function esOscuro() {
    return document.documentElement.classList.contains('dark');
}

/** Altura del centro de una pieza, contando desde la base del armario. */
function alturaDe(u, altoU) {
    const base = -ALTO_UTIL / 2;
    return base + (u - altoU) * U + (altoU * U) / 2;
}

/* --------------------------------------------------------------------------
 * Materiales
 * -------------------------------------------------------------------------- */
function crearMateriales(movil) {
    /*
     * En móvil las texturas se generan a la mitad de resolución: el lienzo es
     * más pequeño, el detalle no llega al ojo y el filtro Sobel de las normales
     * cuesta cuatro veces menos sobre un lado la mitad de largo.
     */
    const escala = movil ? 0.5 : 1;

    const cepillado = texturasCepillado(escala);
    const malla = texturasMalla(escala);

    /*
     * Acero pintado. Lo que cambia respecto a antes es normalMap: sin él las
     * superficies devuelven la luz como un plano perfecto y el grano del
     * cepillado solo se notaba como manchas de brillo.
     */
    const acero = (color, rugosidad, metalico) =>
        new MeshStandardMaterial({
            color,
            roughness: rugosidad,
            metalness: metalico,
            roughnessMap: cepillado.rugosidad,
            normalMap: cepillado.normal,
            normalScale: new Vector2(0.35, 0.35),
        });

    return {
        armazon:  acero(0x272c34, 0.52, 0.62),
        chapa:    acero(0x333942, 0.46, 0.7),
        panel:    acero(0x2e343d, 0.44, 0.68),
        ciega:    acero(0x2b3038, 0.58, 0.5),
        bahia:    acero(0x3a414b, 0.4, 0.72),
        plastico: new MeshStandardMaterial({ color: 0x1b1f25, roughness: 0.8, metalness: 0.05 }),
        tornillo: new MeshStandardMaterial({ color: 0x9aa3ae, roughness: 0.3, metalness: 0.95 }),
        hueco:    new MeshStandardMaterial({ color: 0x090b0e, roughness: 0.95, metalness: 0.05 }),

        // Chapa perforada: el relieve de los agujeros va en las normales, y el
        // propio mapa de color hace de oclusión (oscuro dentro del agujero).
        malla: new MeshStandardMaterial({
            map: malla.color,
            normalMap: malla.normal,
            normalScale: new Vector2(1, 1),
            aoMap: movil ? null : malla.oclusion,
            aoMapIntensity: 0.85,
            roughness: 0.72,
            metalness: 0.45,
        }),

        serigrafiaPatch:  new MeshStandardMaterial({
            map: texturaSerigrafia('PATCH PANEL 24P · CAT6'),
            roughness: 0.6, metalness: 0.35,
        }),
        serigrafiaSwitch: new MeshStandardMaterial({
            map: texturaSerigrafia('GIGABIT SWITCH'),
            roughness: 0.6, metalness: 0.35,
        }),

        pantallaSai: new MeshStandardMaterial({
            color: 0x04140c,
            roughness: 0.22,
            emissive: new Color(0xffffff),
            emissiveMap: texturaPantalla('sai'),
            emissiveIntensity: 1.1,
        }),
        pantallaFirewall: new MeshStandardMaterial({
            color: 0x04140c,
            roughness: 0.22,
            emissive: new Color(0xffffff),
            emissiveMap: texturaPantalla('firewall'),
            emissiveIntensity: 1.1,
        }),

        ledVerde: new MeshStandardMaterial({
            color: 0x1f7a4d,
            emissive: new Color(0x33d98a),
            emissiveIntensity: 1.1,
        }),

        cable: materialesCable(),
        cepillado,
        escala,
    };
}

/* --------------------------------------------------------------------------
 * El armario
 * -------------------------------------------------------------------------- */
function construirRack(mats) {
    const rack = new Group();
    const servicios = [];

    const altoCaja = ALTO_UTIL + TECHO + ZOCALO;
    const centroCaja = (TECHO - ZOCALO) / 2;

    /* --- Chasis: laterales, techo, zócalo y fondo --- */
    [-1, 1].forEach((lado) => {
        const lateral = caja(0.12, altoCaja, FONDO, mats.armazon);
        lateral.position.set(lado * (ANCHO_EXT / 2 - 0.06), centroCaja, 0);
        lateral.castShadow = lateral.receiveShadow = true;
        rack.add(lateral);
    });

    const techo = caja(ANCHO_EXT, TECHO, FONDO, mats.armazon);
    techo.position.y = ALTO_UTIL / 2 + TECHO / 2;
    techo.castShadow = true;
    rack.add(techo);

    // Rejilla de extracción en el techo: todo rack la lleva.
    const ventilacion = caja(ANCHO_EXT * 0.62, 0.03, FONDO * 0.5, mats.malla);
    ventilacion.position.y = ALTO_UTIL / 2 + TECHO;
    ventilacion.rotation.x = 0;
    rack.add(ventilacion);

    const zocalo = caja(ANCHO_EXT, ZOCALO, FONDO, mats.armazon);
    zocalo.position.y = -(ALTO_UTIL / 2 + ZOCALO / 2);
    zocalo.castShadow = zocalo.receiveShadow = true;
    rack.add(zocalo);

    const trasera = caja(ANCHO_EXT, altoCaja, 0.1, mats.panel);
    trasera.position.set(0, centroCaja, -(FONDO / 2 - 0.05));
    rack.add(trasera);

    // Patas niveladoras
    const pata = new BoxGeometry(0.22, 0.22, 0.22);
    const y = -(ALTO_UTIL / 2 + ZOCALO + 0.11);
    rack.add(repetir(pata, mats.tornillo, [
        [-ANCHO_EXT / 2 + 0.35, y, FONDO / 2 - 0.4],
        [ANCHO_EXT / 2 - 0.35, y, FONDO / 2 - 0.4],
        [-ANCHO_EXT / 2 + 0.35, y, -FONDO / 2 + 0.4],
        [ANCHO_EXT / 2 - 0.35, y, -FONDO / 2 + 0.4],
    ]));

    /* --- Raíles de montaje ---
       El rasgo que hace que un rack se identifique de un vistazo. Los agujeros
       van en la textura, no en la malla. */
    const texRail = texturasRail(UNIDADES_RACK, mats.escala);
    const matRail = new MeshStandardMaterial({
        map: texRail.color,
        // Aquí está el cambio que se ve: los agujeros dejan de estar pintados
        // y pasan a hundirse, con sombra dentro y brillo en el canto.
        normalMap: texRail.normal,
        normalScale: new Vector2(1.4, 1.4),
        roughness: 0.5,
        metalness: 0.75,
        roughnessMap: mats.cepillado.rugosidad,
    });

    [-1, 1].forEach((lado) => {
        const rail = caja(0.22, ALTO_UTIL, 0.5, matRail);
        rail.position.set(lado * (RAIL_X + 0.11), 0, Z_FRENTE - 0.25);
        rail.castShadow = true;
        rack.add(rail);
    });

    /*
     * Las tapas ciegas se montan de una en una, no en planchas.
     *
     * Un tramo de 13U dibujado como una sola caja es una losa lisa que canta a
     * 3D barato; troceado en tapas de 1U aparecen las juntas y los tornillos
     * cada 44 mm, que es el ritmo que tiene un rack de verdad.
     */
    const alturas = {};

    const piezas = CONTENIDO.flatMap((pieza) =>
        pieza.tipo === 'ciega' && pieza.alto > 1
            ? Array.from({ length: pieza.alto }, (_, i) => ({
                ...pieza, u: pieza.u - i, alto: 1,
            }))
            : [pieza],
    );

    /* --- El equipamiento --- */
    piezas.forEach((pieza) => {
        const grupo = new Group();
        grupo.position.y = alturaDe(pieza.u, pieza.alto);

        const material = pieza.tipo === 'ciega'
            ? mats.ciega.clone()
            : mats.panel.clone();

        // Un pelín de variación de tono para que no parezcan clones.
        material.color.offsetHSL(0, 0, (Math.random() - 0.5) * 0.035);

        /*
         * Solo se modela el frontal, no el equipo entero. Desde delante el
         * fondo no se ve, y modelar cajas de 800 mm obligaría a rellenar un
         * interior que nadie mira. Lo importante es que TODOS los frentes
         * queden enrasados en Z_FRENTE, como en un rack de verdad.
         */
        const fondoPieza = pieza.tipo === 'ciega' ? 0.1 : 0.55;

        const cuerpo = caja(ANCHO_CHASIS, pieza.alto * U * 0.97, fondoPieza, material);
        cuerpo.position.z = Z_FRENTE - fondoPieza / 2;
        cuerpo.castShadow = cuerpo.receiveShadow = true;
        grupo.add(cuerpo);

        grupo.add(frontal(pieza.tipo, pieza.alto, mats));
        rack.add(grupo);

        if (pieza.servicio !== undefined) {
            servicios[pieza.servicio] = {
                grupo,
                material,
                y: grupo.position.y,
            };
        }

        alturas[pieza.tipo] = grupo.position.y;
    });

    /* --- Latiguillos entre el panel de parcheo y el switch --- */
    if (alturas.patch !== undefined && alturas.switch !== undefined) {
        rack.add(latiguillos(
            alturas.patch - U * 0.2,
            alturas.guia ?? (alturas.patch + alturas.switch) / 2,
            alturas.switch + U * 0.2,
            mats,
        ));
    }

    return { rack, servicios, altoCaja };
}

/* --------------------------------------------------------------------------
 * Escena
 * -------------------------------------------------------------------------- */
export function crearEscena(lienzo) {
    const movil = window.innerWidth < 1024;

    const renderizador = new WebGLRenderer({
        canvas: lienzo,
        antialias: true,
        alpha: true,
        powerPreference: 'low-power',
    });
    renderizador.setClearAlpha(0);

    /*
     * Sin mapeo tonal, el motor recorta los brillos de golpe y los metales
     * salen lavados. ACES es el que usan los visores de producto.
     */
    renderizador.toneMapping = ACESFilmicToneMapping;
    renderizador.toneMappingExposure = 1.15;

    if (! movil) {
        renderizador.shadowMap.enabled = true;
        renderizador.shadowMap.type = PCFSoftShadowMap;
    }

    const escena = new Scene();
    const mats = crearMateriales(movil);
    const { rack, servicios, altoCaja } = construirRack(mats);
    escena.add(rack);

    /*
     * El mapa de entorno es LO que hace que esto parezca metal.
     *
     * Un MeshStandardMaterial con metalness y sin nada alrededor que reflejar
     * se dibuja como plástico gris: no es un fallo de las luces, es que el
     * metal no tiene qué devolver. RoomEnvironment monta un estudio de
     * mentira y PMREMGenerator lo convierte en el mapa que necesita el motor.
     */
    const pmrem = new PMREMGenerator(renderizador);
    const entorno = pmrem.fromScene(new RoomEnvironment(), 0.04);
    escena.environment = entorno.texture;
    escena.environmentIntensity = movil ? 0.75 : 1;
    pmrem.dispose();

    /* --- Luces --- */
    const ambiente = new AmbientLight(0xffffff, 0.35);
    escena.add(ambiente);

    const principal = new DirectionalLight(0xffffff, 2.2);
    principal.position.set(9, 14, 16);
    if (! movil) {
        principal.castShadow = true;
        principal.shadow.mapSize.set(1024, 1024);
        principal.shadow.radius = 3;
        principal.shadow.camera.near = 1;
        principal.shadow.camera.far = 60;
        const r = altoCaja * 0.7;
        Object.assign(principal.shadow.camera, { left: -r, right: r, top: r, bottom: -r });
        principal.shadow.bias = -0.0015;
    }
    escena.add(principal);

    const contra = new DirectionalLight(0xbcd0ff, 0.5);
    contra.position.set(-12, 2, 6);
    escena.add(contra);

    /* Foco ámbar de la marca: situar() lo mueve a la altura del equipo activo. */
    const foco = new PointLight(0xe0870b, 0, 22, 2);
    foco.position.set(-3, 0, 6);
    escena.add(foco);

    /* Suelo invisible que solo recoge la sombra, para que el rack no flote. */
    if (! movil) {
        const suelo = new Mesh(
            new PlaneGeometry(60, 60),
            // Suave: solo tiene que posar el armario en el suelo, no dibujar
            // una mancha gris al lado.
            new ShadowMaterial({ opacity: 0.16 }),
        );
        suelo.rotation.x = -Math.PI / 2;
        suelo.position.y = -(ALTO_UTIL / 2 + ZOCALO + 0.22);
        suelo.receiveShadow = true;
        escena.add(suelo);
    }

    /* --- Cámara --- */
    const camara = new PerspectiveCamera(FOV, 1, 0.5, 200);
    const objetivo = new Vector3();

    function dimensionar() {
        const { clientWidth: ancho, clientHeight: alto } = lienzo.parentElement;
        if (! ancho || ! alto) return;

        const tope = window.innerWidth < 1024 ? 1.5 : 2;
        renderizador.setPixelRatio(Math.min(window.devicePixelRatio, tope));
        renderizador.setSize(ancho, alto, false);
        camara.aspect = ancho / alto;
        camara.updateProjectionMatrix();
    }

    function pintar() {
        renderizador.render(escena, camara);
    }

    /**
     * Coloca la cámara. El primer tramo del scroll es un plano general del
     * armario entero; a partir de ahí se acerca y va bajando de equipo en
     * equipo. Así se entiende primero QUÉ es y luego qué lleva dentro.
     */
    /**
     * Coloca la cámara.
     *
     * @param zoom    0 = plano general del armario entero, 1 = a la altura de
     *                un equipo. Lo lleva el scroll de la sección, de forma
     *                continua y sin fijar nada.
     * @param unidad  Índice del servicio, con decimales: 2.4 es "entre el
     *                tercero y el cuarto". Viene suavizado por un tween, así
     *                que la cámara se desliza entre equipos en vez de saltar.
     */
    function situar(zoom, unidad) {
        const suave = zoom * zoom * (3 - 2 * zoom);

        const z = CAMARA.lejos.z + (CAMARA.cerca.z - CAMARA.lejos.z) * suave;
        const x = CAMARA.lejos.x + (CAMARA.cerca.x - CAMARA.lejos.x) * suave;

        // Altura interpolada entre los dos equipos que rodean a `unidad`.
        const ultimo = servicios.length - 1;
        const acotado = Math.max(0, Math.min(ultimo, unidad));
        const bajo = Math.floor(acotado);
        const alto = Math.min(ultimo, bajo + 1);
        const resto = acotado - bajo;

        const destino = (servicios[bajo]?.y ?? 0) * (1 - resto)
                      + (servicios[alto]?.y ?? 0) * resto;

        /* Mientras se ve el armario entero la cámara se queda centrada: subir
           hacia el panel de parcheo en pleno plano general dejaba la base del
           armario fuera de plano. */
        const y = destino * suave;

        /* Y solo se alza sobre el objetivo cuando ya está cerca; en el plano
           general, mirar desde arriba recortaba el techo. */
        camara.position.set(x, y + 1.2 * suave, z);
        /* Se mira al plano del frente, no al centro del armario: si no, el
           panel lateral se come media composición. */
        objetivo.set(0, y, 2.2);
        camara.lookAt(objetivo);

        /*
         * Giro leve y nada más. El tres cuartos ya lo da el desplazamiento en X
         * de la cámara; si además se gira mucho el armario, los dos ángulos se
         * suman y se acaba viendo el lateral en vez del frente.
         */
        rack.rotation.y = -0.1 - suave * 0.03;

        const activo = Math.round(acotado);

        servicios.forEach((servicio, i) => {
            const encendido = i === activo;

            servicio.material.emissive.set(encendido ? 0xe0870b : 0x000000);
            servicio.material.emissiveIntensity = encendido ? 0.1 : 0;
            servicio.grupo.position.z = encendido ? 0.16 : 0;
        });

        foco.position.set(-3.2, destino + 0.6, 7);
        foco.intensity = (esOscuro() ? 20 : 13) * suave;
    }

    function aplicarTema() {
        const nocturno = esOscuro();

        ambiente.intensity = nocturno ? 0.28 : 0.42;
        principal.intensity = nocturno ? 1.9 : 2.4;
        escena.environmentIntensity = (movil ? 0.75 : 1) * (nocturno ? 0.75 : 1);
        renderizador.toneMappingExposure = nocturno ? 1.05 : 1.2;

        pintar();
    }

    function destruir() {
        entorno.dispose();
        renderizador.dispose();
        escena.traverse((objeto) => {
            objeto.geometry?.dispose();
            if (objeto.material) {
                (Array.isArray(objeto.material) ? objeto.material : [objeto.material])
                    .forEach((m) => {
                        m.map?.dispose();
                        m.roughnessMap?.dispose();
                        m.dispose();
                    });
            }
        });
    }

    dimensionar();
    aplicarTema();
    situar(0, 0);
    pintar();

    return { dimensionar, pintar, situar, aplicarTema, destruir, totalUnidades: servicios.length };
}
