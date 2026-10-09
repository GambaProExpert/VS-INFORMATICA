@props([
    'titulo' => null,
    'descripcion' => 'Informática para empresas en La Roda y Albacete: a3ERP, servidores, redes, '
                   . 'seguridad, copias de seguridad y reparación con taller propio.',
    'imagen' => null,
])

@php
    $tituloCompleto = $titulo
        ? $titulo . ' | ' . config('empresa.nombre')
        : 'Informática para empresas en La Roda | ' . config('empresa.nombre');

    $imagenCompartir = $imagen ? asset($imagen) : asset('images/empresa/taller-mostrador.jpg');
@endphp

<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--
        Este script va ANTES de la hoja de estilos y sin defer, a propósito, por
        dos motivos:

        1. Aplica el tema antes del primer pintado. Si se ejecutase después,
           quien tenga el tema oscuro vería un fogonazo blanco en cada carga.
        2. Define selectorTema() como función global. Alpine viaja dentro del
           paquete de Livewire, que es un <script> clásico al final del body y
           por tanto se ejecuta ANTES que nuestro app.js (que Vite emite como
           módulo, y los módulos van diferidos). Registrar el componente con
           Alpine.data() en 'alpine:init' llegaría tarde; una función global
           declarada aquí está disponible seguro.

        Es el único JavaScript bloqueante de la web.
    --}}
    <script>
        (() => {
            const TEMAS = ['claro', 'sistema', 'oscuro'];
            const consulta = window.matchMedia('(prefers-color-scheme: dark)');

            const aplicar = (tema) => {
                const oscuro = tema === 'oscuro' || (tema === 'sistema' && consulta.matches);
                document.documentElement.classList.toggle('dark', oscuro);
            };

            const leer = () => localStorage.getItem('tema') ?? 'sistema';

            // Antes de pintar nada.
            aplicar(leer());

            /*
             * Marca que se pueden animar cosas. El CSS esconde los elementos
             * con [data-anim] solo bajo html.anim, así que:
             *   - sin JavaScript, esta línea no corre y todo se ve;
             *   - con movimiento reducido, tampoco, y el contenido nace
             *     visible en vez de aparecer y corregirse a medio camino.
             */
            if (! window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.documentElement.classList.add('anim');

                /*
                 * Red de seguridad. La clase esconde el contenido hasta que
                 * GSAP lo revela; si el paquete no llega a cargar (una red que
                 * se corta, un bloqueador, un error), la página se quedaría en
                 * blanco para siempre. A los 4 segundos sin señal de vida se
                 * quita la clase y todo aparece.
                 */
                setTimeout(() => {
                    if (! window.__animacionesListas) {
                        document.documentElement.classList.remove('anim');
                    }
                }, 4000);
            }

            window.selectorTema = () => ({
                tema: leer(),
                opciones: TEMAS,
                alCambiarSistema: null,

                init() {
                    // Quien lo deja en "sistema" espera que la web siga al
                    // sistema operativo aunque cambie con la web abierta.
                    this.alCambiarSistema = () => {
                        if (this.tema === 'sistema') aplicar(this.tema);
                    };
                    consulta.addEventListener('change', this.alCambiarSistema);
                },

                destroy() {
                    consulta.removeEventListener('change', this.alCambiarSistema);
                },

                elegir(valor) {
                    this.tema = valor;
                    localStorage.setItem('tema', valor);
                    aplicar(valor);
                },

                /* Flechas del teclado dentro del grupo, como manda un radiogroup. */
                mover(paso) {
                    const i = TEMAS.indexOf(this.tema);
                    const siguiente = TEMAS[(i + paso + TEMAS.length) % TEMAS.length];

                    this.elegir(siguiente);
                    this.$refs[siguiente]?.focus();
                },

                clases(valor) {
                    return this.tema === valor
                        ? 'bg-papel text-tinta shadow-suave'
                        : 'text-tenue hover:text-tinta';
                },
            });

            window.cabecera = () => ({
                menuMovil: false,
                oscuro: document.documentElement.classList.contains('dark'),
                observer: null,

                init() {
                    this.observer = new MutationObserver(() => {
                        this.oscuro = document.documentElement.classList.contains('dark');
                    });
                    this.observer.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['class'],
                    });
                },

                destroy() {
                    this.observer?.disconnect();
                },
            });

            window.partnersLogos = () => ({
                oscuro: document.documentElement.classList.contains('dark'),
                observer: null,

                init() {
                    this.observer = new MutationObserver(() => {
                        this.oscuro = document.documentElement.classList.contains('dark');
                    });
                    this.observer.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['class'],
                    });
                },

                destroy() {
                    this.observer?.disconnect();
                },
            });
        })();
    </script>

    <title>{{ $tituloCompleto }}</title>
    <meta name="description" content="{{ $descripcion }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{--
        Las dos fuentes que aparecen en el primer pintado. La mono no: solo la
        usan las etiquetas pequeñas y puede esperar.

        Van por Vite::asset y no por asset(): los .woff2 viven en resources/ y
        los sirve Vite, que en producción les pone huella para poder cachearlos
        para siempre. Si estuvieran en public/, con `npm run dev` la hoja de
        estilos se sirve desde el servidor de Vite y las rutas absolutas
        /fuentes/… se resolverían contra ÉL, devolviendo 404 y dejando la web
        con las fuentes del sistema.
    --}}
    @foreach (['public-sans-latin', 'bricolage-grotesque-latin'] as $fuente)
        <link rel="preload" href="{{ Vite::asset("resources/fuentes/{$fuente}.woff2") }}"
              as="font" type="font/woff2" crossorigin>
    @endforeach

    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_ES">
    <meta property="og:site_name" content="{{ config('empresa.nombre_largo') }}">
    <meta property="og:title" content="{{ $tituloCompleto }}">
    <meta property="og:description" content="{{ $descripcion }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $imagenCompartir }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="{{ asset('images/marca/logo.png') }}" type="image/png">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f1216" media="(prefers-color-scheme: dark)">

    <x-schema-local-business />

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-papel font-sans text-tinta antialiased">
    <a href="#contenido"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50
              focus:rounded-boton focus:bg-tinta focus:px-4 focus:py-2 focus:text-papel">
        Saltar al contenido
    </a>

    <x-cabecera />

    <main id="contenido">
        {{ $slot }}
    </main>

    <x-pie />

    <x-banner-cookies />

    {{--
        Se cargan siempre, no solo donde hay un componente Livewire: Alpine
        viaja dentro de este paquete y lo necesitan el selector de tema, los
        desplegables del menú y el aviso de cookies, que están en todas las
        páginas. Livewire solo auto-inyecta cuando renderiza un componente,
        así que aquí se declara a mano.
    --}}
    @livewireScripts
</body>
</html>
