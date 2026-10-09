import { gsap, ScrollTrigger } from './animaciones';

/*
 * Cargador del rack 3D.
 *
 * Este fichero sí viaja en el paquete principal, pero es diminuto: su único
 * trabajo es decidir SI merece la pena traer Three.js, y traerlo con import()
 * dinámico solo cuando la sección se acerca. Quien entra en la home y no baja
 * no descarga ni un byte de 3D.
 *
 * Se rinde y deja el listado en texto —que es lo que hay en el HTML de
 * partida— en tres casos: sin WebGL, con movimiento reducido, o si la carga
 * falla. La sección sigue explicando los seis servicios igual.
 *
 * IMPORTANTE: aquí no se fija (pin) nada.
 *
 * La versión anterior fijaba la sección y se quedaba con 2.520 px de scroll:
 * durante dos pantallas y media la rueda no movía la página. Funcionaba, pero
 * se sentía como si la web se hubiera colgado. Ahora el lienzo va con
 * position: sticky desde el CSS y aquí solo se observa por dónde va el lector
 * para mover la cámara. El scroll es el del navegador, sin intermediarios.
 */

/** ¿Puede este navegador pintar WebGL? Algunos lo anuncian y luego fallan. */
function hayWebGL() {
    try {
        const lienzo = document.createElement('canvas');
        return !! (window.WebGLRenderingContext && lienzo.getContext('webgl2'));
    } catch {
        return false;
    }
}

export function iniciarRack() {
    const seccion = document.querySelector('[data-rack]');
    if (! seccion) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || ! hayWebGL()) return;

    // Se precarga con margen para que, al llegar, ya esté listo.
    const vigia = new IntersectionObserver(
        (entradas) => {
            if (! entradas[0].isIntersecting) return;
            vigia.disconnect();
            montar(seccion).catch(() => {
                // Si algo falla, la lista en texto ya está en el HTML.
                seccion.dataset.rackEstado = 'error';
            });
        },
        { rootMargin: '600px 0px' },
    );

    vigia.observe(seccion);
}

async function montar(seccion) {
    const lienzo = seccion.querySelector('[data-rack-lienzo]');
    const pasos = Array.from(seccion.querySelectorAll('[data-rack-paso]'));
    if (! lienzo || ! pasos.length) return;

    const { crearEscena } = await import('./rack');
    const escena = crearEscena(lienzo);

    // A partir de aquí el CSS enseña el lienzo y el raíl de progreso.
    seccion.dataset.rackEstado = 'listo';
    escena.dimensionar();

    const marcas = Array.from(seccion.querySelectorAll('[data-rack-marca]'));
    const total = pasos.length;

    /*
     * El estado de la cámara vive en este objeto y lo animan tweens de GSAP.
     * `zoom` lo lleva el scroll de forma continua; `unidad` salta de equipo en
     * equipo pero suavizado, para que la cámara se deslice en vez de dar botes.
     */
    const camara = { zoom: 0, unidad: 0 };

    function pintar() {
        escena.situar(camara.zoom, camara.unidad);
        escena.pintar();
    }

    /* --- El acercamiento, ligado al scroll pero SIN fijar la sección ---
     *
     * El rango va de cuando la sección asoma por abajo a cuando ya está
     * colocada. Con el rango anterior ('top bottom' → 'top top') el
     * acercamiento se consumía ANTES de que el lienzo llegara a verse, así que
     * el plano general del armario entero no lo veía nadie. */
    ScrollTrigger.create({
        trigger: seccion,
        start: 'top 75%',
        end: 'top 5%',
        scrub: 0.5,
        onUpdate: (self) => {
            camara.zoom = self.progress;
            pintar();
        },
    });

    /* --- Qué equipo toca, según la tarjeta que esté en el centro --- */
    let activo = -1;

    function resaltar(indice) {
        if (indice === activo) return;
        activo = indice;

        pasos.forEach((paso, i) => {
            paso.dataset.activo = i === indice ? 'si' : 'no';
        });

        marcas.forEach((marca, i) => {
            marca.classList.toggle('bg-azafran', i === indice);
            marca.classList.toggle('bg-linea-fuerte', i !== indice);
            marca.classList.toggle('h-10', i === indice);
            marca.classList.toggle('h-6', i !== indice);
        });

        // La cámara se desliza hasta el equipo; no salta.
        gsap.to(camara, {
            unidad: indice,
            duration: 0.8,
            ease: 'power2.out',
            overwrite: true,
            onUpdate: pintar,
        });
    }

    pasos.forEach((paso, i) => {
        ScrollTrigger.create({
            trigger: paso,
            start: 'top 65%',
            end: 'bottom 35%',
            onToggle: (self) => self.isActive && resaltar(i),
        });
    });

    resaltar(0);
    pintar();

    /*
     * La sección crece bastante al aparecer el lienzo, así que hay que
     * recalcular las posiciones de los disparadores que ya existían.
     */
    ScrollTrigger.refresh();

    // Redimensionar y cambio de tema: repintar una vez, no en bucle.
    window.addEventListener('resize', () => {
        escena.dimensionar();
        pintar();
    }, { passive: true });

    new MutationObserver(() => escena.aplicarTema()).observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    });
}
