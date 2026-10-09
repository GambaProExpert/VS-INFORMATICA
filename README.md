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

