import { iniciarAnimaciones } from './animaciones';
import { iniciarRack } from './rack-cargador';

/*
 * Alpine llega dentro del paquete de Livewire, así que aquí no se importa ni
 * se arranca. Los desplegables, el menú móvil y el aviso de cookies se
 * declaran con x-data en línea; el selector de tema vive en el <script> del
 * <head> del layout, porque tiene que existir antes de que Alpine arranque
 * (Livewire es un script clásico y este fichero lo emite Vite como módulo,
 * que va diferido y llegaría tarde).
 *
 * Lo que sí vive aquí es el movimiento: GSAP para los reveals de scroll y el
 * cargador del rack 3D, que trae Three.js en diferido solo si hace falta.
 */

iniciarAnimaciones();
iniciarRack();
