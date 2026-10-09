import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/*
 * Animaciones de scroll.
 *
 * Dos formas de usarlo desde Blade:
 *
 *   <div data-anim>...</div>            un elemento que entra al aparecer
 *   <ul data-anim="lista">...</ul>      sus hijos entran escalonados
 *
 * El estado inicial (opacity: 0) lo pone el CSS bajo `html.anim`, y esa clase
 * la añade el script en línea de la cabecera ANTES de pintar, solo si el
 * sistema no pide movimiento reducido. Dos consecuencias buenas:
 *
 *   - Sin JavaScript no hay clase, no hay opacity 0 y la web se ve entera.
 *   - Con movimiento reducido tampoco hay clase, así que no hay ni un
 *     parpadeo: el contenido nace visible en vez de aparecer y luego
 *     corregirse.
 *
 * QUIÉN decide el momento: IntersectionObserver. QUIÉN anima: GSAP.
 *
 * Es a propósito, y costó un fallo entenderlo. ScrollTrigger.batch calcula las
 * posiciones de cada elemento al crearlo y las guarda; el rack 3D se monta más
 * tarde y su `pin` mete de golpe 2.500 px en mitad de la página, así que todo
 * lo que va después se desplaza y sus disparadores apuntan a coordenadas que
 * ya no existen. Resultado: el pie y las fotos del taller se quedaban
 * invisibles para siempre. IntersectionObserver no guarda posiciones —lo
 * resuelve el propio navegador— y le da igual cuánto crezca la página.
 */

const DURACION = 0.7;
const DESPLAZAMIENTO = 24;
const ESCALONADO = 0.08;

/** Anima un grupo de elementos escalonándolos según entran en pantalla. */
function revelar(elementos) {
    if (! elementos.length) return;

    gsap.set(elementos, { opacity: 0, y: DESPLAZAMIENTO });

    // Se acumulan los que entran en el mismo instante para escalonarlos juntos.
    let lote = [];
    let pendiente = null;

    const soltar = () => {
        if (! lote.length) return;

        gsap.to(lote, {
            opacity: 1,
            y: 0,
            duration: DURACION,
            stagger: ESCALONADO,
            ease: 'power2.out',
            overwrite: true,
        });

        lote = [];
        pendiente = null;
    };

    const vigia = new IntersectionObserver(
        (entradas) => {
            entradas.forEach((entrada) => {
                if (! entrada.isIntersecting) return;

                vigia.unobserve(entrada.target);
                lote.push(entrada.target);
            });

            if (lote.length && pendiente === null) {
                pendiente = requestAnimationFrame(soltar);
            }
        },
        // Un pelín antes de que asome del todo, para que no se note el salto.
        { rootMargin: '0px 0px -12% 0px', threshold: 0.01 },
    );

    elementos.forEach((el) => vigia.observe(el));
}

export function iniciarAnimaciones() {
    // Si la clase no está, o no hay JS o se pidió movimiento reducido.
    if (! document.documentElement.classList.contains('anim')) return;

    // Le dice a la red de seguridad del <head> que ya hay quien revele esto.
    window.__animacionesListas = true;

    revelar(Array.from(document.querySelectorAll('[data-anim]:not([data-anim="lista"])')));

    // En las listas se anima cada hijo, no el contenedor.
    document.querySelectorAll('[data-anim="lista"]').forEach((contenedor) => {
        revelar(Array.from(contenedor.children));
    });
}

export { gsap, ScrollTrigger };
