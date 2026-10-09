# VS Informática La Roda — web

Renovación de [vsinformatica.es](https://www.vsinformatica.es) (Joomla 3, © 1997–2021) al stack
TALL: **Tailwind 4 + Alpine + Laravel 13 + Livewire 4**, con **GSAP** para el movimiento y
**Three.js** para el rack 3D de la home.

Se conservan la estructura, los textos y las 17 páginas del sitio original. Todo en español.

## Arrancar

```bash
composer install
npm install
php artisan migrate
npm run dev          # y en otra terminal:
php artisan serve
```

En `http://127.0.0.1:8000`. La base de datos es SQLite (`database/database.sqlite`) y solo guarda
las consultas del formulario de contacto: **el contenido no toca la base de datos**.

Los correos van al log (`MAIL_MAILER=log`): las consultas enviadas se leen en
`storage/logs/laravel.log`.

## Dónde está cada cosa

| Qué | Dónde |
|---|---|
| Datos de la empresa (NAP, horario, partners, soporte remoto) | `config/empresa.php` |
| Catálogo de servicios (menú, tarjetas, índices, sitemap) | `config/servicios.php` |
| Redirecciones 301 desde el Joomla antiguo | `config/redirecciones.php` |
| Lectura del catálogo | `app/Contenido/Servicios.php` |
| Cuerpo de cada página de servicio | `resources/views/servicios/{slug}.blade.php` |
| Sistema de color, tipografía y tema | `resources/css/app.css` |
| Selector de tema (claro/sistema/oscuro) | `resources/views/components/layouts/base.blade.php` (script del `<head>`) |
| Formulario de contacto | `app/Livewire/FormularioContacto.php` |
| Animaciones de scroll | `resources/js/animaciones.js` (`data-anim` y `data-anim="lista"` en las vistas) |
| Rack 3D | `resources/views/components/rack-3d.blade.php` + `resources/js/rack.js`, `rack-piezas.js` y `rack-cargador.js` |
| Versalitas pequeñas (menú, antetítulos, migas) | utilidad `etiqueta` en `resources/css/app.css` |

### Añadir un servicio

1. Una entrada en `config/servicios.php`.
2. Su vista en `resources/views/servicios/{slug}.blade.php`.

El menú, el pie, el mapa del sitio y el sitemap se enteran solos. Si te olvidas de la vista, el
test `RutasTest` te lo dice.

## Decisiones que conviene conocer

- **El tema oscuro va por clase `.dark`, no por media query**, porque el selector tiene que poder
  imponerse a la preferencia del sistema. Los colores se declaran en `:root`/`.dark` y se exponen
  a Tailwind con `@theme inline`: un `@theme` normal congela los valores al compilar y el tema no
  podría cambiar.
- **El selector de tema es una función global** declarada en el `<script>` del `<head>`, no un
  `Alpine.data()` en `app.js`. Alpine viaja dentro del paquete de Livewire, que es un script
  clásico al final del `<body>` y se ejecuta antes que `app.js` (que Vite emite como módulo, y los
  módulos van diferidos).
- **Las fuentes se autoalojan** y las sirve Vite desde `resources/fuentes/`. Ninguna IP de
  visitante llega a un CDN (RGPD). Están en `resources/` y no en `public/` a propósito: con
  `npm run dev` la hoja de estilos la sirve Vite, y una ruta absoluta `/fuentes/…` se resolvería
  contra el servidor de Vite en lugar de contra Laravel, devolviendo 404. De paso, en producción
  Vite les pone huella y se pueden cachear para siempre.
- **El movimiento decide con IntersectionObserver y anima con GSAP**, no con `ScrollTrigger.batch`.
  ScrollTrigger guarda las posiciones al crear cada disparador, y el `pin` del rack —que se monta
  tarde— mete 2.500 px en mitad de la página: todo lo que va después se desplazaba y sus reveals
  no llegaban a saltar nunca, dejando el pie invisible. IntersectionObserver no guarda posiciones.
- **El contenido nunca depende del JavaScript para verse.** El estado inicial `opacity: 0` cuelga
  de `html.anim`, clase que solo añade el script del `<head>` si hay JS y no se pide movimiento
  reducido, y que además se retira sola a los 4 s si el paquete de animaciones no da señales.
- **La cabecera no lleva teléfono ni horario.** Los tuvo: un botón ámbar a la derecha y el horario
  en la franja superior. El botón competía en color con las llamadas a la acción de cada página —el
  único ámbar de la pantalla debe ser el que quieres que se pulse— y el horario ocupaba un sitio
  privilegiado en las 22 páginas para un dato que no cambia nunca. Ambos siguen donde se buscan: en
  Contacto, en el pie, en la home y en el menú de móvil.
- **Las cabeceras de página interior no llevan icono.** Estaba en un recuadro a la izquierda del H1
  y le robaba la salida al titular. El icono distingue un servicio de otro en las tarjetas y en el
  menú; dentro de la página del servicio no distingue nada.
- **Se confía en los proxies (`trustProxies(at: '*')` en `bootstrap/app.php`).** Detrás de un túnel
  la petición llega como HTTP plano desde 127.0.0.1 mientras el visitante tiene `https://` en la
  barra: sin esto los assets salen en `http://` dentro de una página `https://` y el navegador los
  bloquea, `request()->ip()` es siempre 127.0.0.1 —el límite del formulario pasaría a ser compartido
  entre todo el mundo— y la IP que se guarda por RGPD no vale nada. **En un hosting definitivo hay
  que sustituir el `'*'` por la IP real del proxy**, porque tal cual está, quien llegue directo puede
  falsear su `X-Forwarded-For`.
- **El mapa de Google no se carga hasta que se pide.** Ver `resources/views/paginas/contacto.blade.php`.
- **Los botones ámbar llevan tinta oscura**, no blanca: blanco sobre `#E0870B` da 2,75:1 y suspende
  el contraste AA. El token `--color-sobre-azafran` es fijo a propósito.
- **Sin AVIF**: el visor de la galería usa una sola `<img>` con `src` enlazado a Alpine, y en un
  `<picture>` el navegador resuelve los `<source>` antes de que Alpine actúe.
- **Dos familias tipográficas y solo dos.** Hubo una tercera, IBM Plex Mono, para las versalitas
  pequeñas; se leía como una terminal y se retiró. Ese papel lo hace ahora Public Sans a través de
  la utilidad `etiqueta`, cuyo `letter-spacing: 0.14em` es lo que hace el trabajo: una
  proporcional necesita mucho más aire en mayúsculas que una monoespaciada.
- **El rack se dibuja por código** (`rack-piezas.js` tiene las medidas reales: 600 mm de ancho,
  42U de 44,45 mm). Los agujeros de los raíles y las rejillas son **textura de canvas, no
  geometría**: a esa distancia no se distinguen y perforar la malla exigiría booleanas.
- **Las texturas van en pareja, color + normales** (`rack-texturas.js`). El mapa de normales lo
  genera `alturaANormal()` a partir de un mapa de alturas con un filtro Sobel, y es lo que hace que
  un agujero pintado tenga sombra dentro y brillo en el canto. Sin él, la luz pasaba por encima del
  relieve sin enterarse.
- **Todas las cajas llevan las aristas matadas** (`RoundedBoxGeometry` en `caja()`). Un canto de 90°
  exactos es de las cosas que más delatan que algo es 3D.
- **El aoMap necesita `uv1`.** Three.js lee la oclusión del segundo juego de coordenadas, no del
  primero; `conOclusion()` lo copia. Sin esa línea el mapa sencillamente no se ve.
- **La serigrafía va sobre un `PlaneGeometry`, no sobre una caja.** `RoundedBoxGeometry` reparte las
  UV de otra forma por culpa de los biseles y el rótulo salía troceado e ilegible.
- **Lo que hace que el metal parezca metal es el mapa de entorno**, no las luces. Un
  `MeshStandardMaterial` con metalness y sin nada alrededor que reflejar se dibuja como plástico
  gris. `RoomEnvironment` + `PMREMGenerator` lo resuelven; ACES y las sombras rematan.
- **Todos los frontales van enrasados en `Z_FRENTE`**, como en un rack real. Cuando cada pieza
  tenía su profundidad, los puertos flotaban delante del chasis y se veía el interior hueco.
- **El rack NO fija la página (`pin`).** Lo hizo, y se apropiaba de 2.520 px de scroll: durante dos
  pantallas y media la rueda no movía nada mientras por dentro se recorría el armario. Funcionaba,
  pero se sentía como si la web se hubiera colgado. Ahora el lienzo va con `position: sticky` y las
  tarjetas pasan por su lado con el scroll normal: mismo efecto, sin secuestrar el scroll.
- **Nada de `scroll-behavior: smooth`.** GSAP lo desaconseja expresamente: el navegador anima cada
  salto por su cuenta y ScrollTrigger, que lee la posición en cada fotograma, se pelea con esa
  animación. El resultado es un scroll a tirones.

## Enseñársela a alguien de fuera

```powershell
.\scripts\demo.ps1
```

Deja el servidor en `http://127.0.0.1:8000` listo para que un túnel —Dev Tunnels de Visual Studio,
`cloudflared tunnel --url http://localhost:8000`, ngrok— lo publique. Ctrl+C para terminar; no deja
nada que revertir, porque los ajustes van como variables de entorno del proceso y no editando el
`.env` (el repositorio de configuración de Laravel es inmutable, así que lo que ya está en el
entorno gana sobre el fichero).

Existe porque son cuatro cosas y se olvida una:

- **`public/hot` tiene que desaparecer.** Con `npm run dev` en marcha, Laravel escribe ahí la
  dirección del servidor de Vite y las páginas piden el CSS y el JS a `localhost:5173`, que en casa
  de quien mira **es su propio ordenador**. Se ve el texto sin un solo estilo. Es el fallo que más
  veces se comete.
- **Hay que compilar** (`npm run build`), que es de dónde salen los assets sin Vite.
- **`APP_DEBUG=false`**, o cualquier error le enseña al visitante las rutas de tu disco.
- **`DEMO_PUBLICA=true`**, que activa la cabecera noindex del middleware `NoIndexar`.

Lo que el guion no puede arreglar: el formulario **no envía correos** (`MAIL_MAILER=log`), así que
avisa antes o quien lo pruebe pensará que está roto; y en Dev Tunnels el puerto nace privado —hace
falta `devtunnel port create -p 8000 --allow-anonymous` para que se entre sin cuenta de Microsoft.

## Imágenes

```bash
node scripts/optimizar-imagenes.mjs
```

Genera el `.webp` de cada imagen de `public/images` y, para la galería de a3ERP, la grande más una
miniatura de 480 px. Los 38 originales de 1280×1024 viven en
`resources/imagenes-originales/a3erp-galeria/`, **fuera de `public/`**, para no subir 7,6 MB que
nadie descarga en cada despliegue.

## Comandos propios

```bash
php artisan sitemap:generar     # public/sitemap.xml desde config/servicios.php
php artisan consultas:purgar    # borra consultas de más de un año (RGPD)
```

Ambos están programados en `routes/console.php`. En producción necesitan un cron real que llame
cada minuto a `php artisan schedule:run`.

## Tests

```bash
php artisan test
```

56 tests. Cubren: las 22 rutas (200 y un solo `<h1>`), las 17 redirecciones 301, el formulario
(validación, consentimiento, honeypot, límite de envíos, guardado antes del correo), el horario
de jornada partida, la sección del rack (las seis unidades en el HTML sin depender del 3D) y la
tipografía (que no vuelva a colarse `font-mono`, que solo se autoalojen las dos familias).

Lo que un test de PHP no puede comprobar —que el 3D se vea bien, que nada se quede invisible al
bajar, que en móvil no se fije la sección— se revisó con Chrome en modo headless. Merece la pena
repetirlo tras tocar el rack o las animaciones:

- Con el JavaScript desactivado, recorrer la home: no puede quedar ni un elemento en `opacity: 0`.
- Con «reducir movimiento» activo: no debe descargarse el trozo de Three.js.
- Abrir la home sin bajar: `rack-*.js` no debe aparecer en la pestaña Red hasta llegar a la sección.

## Antes de publicar

- [ ] `APP_ENV=production`, `APP_DEBUG=false` y `APP_URL` con el dominio real.
- [ ] `MAIL_MAILER=smtp` y `MAIL_DESTINATARIO_AVISOS` a la cuenta que lee la empresa.
- [ ] `npm run build` y `php artisan optimize`.
- [ ] Regenerar `sitemap.xml` (usa `APP_URL`) y darlo de alta en Search Console.
- [ ] Sustituir las fotos: las del sitio antiguo son miniaturas (la mayor, 465×235).
- [ ] Revisar el aviso legal y la política de privacidad con quien lleve el asesoramiento.
