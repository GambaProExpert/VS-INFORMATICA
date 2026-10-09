@props(['nombre' => 'caja'])

{{--
    Todos los iconos de la web en un solo sitio. Trazo de 1.5 sobre una rejilla
    de 24, heredando currentColor, para que combinen entre sí venga de donde
    venga el color. Los de marca (Windows, Apple) van rellenos porque su
    logotipo es así.
--}}

@php
    $comunes = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" '
             . 'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';
@endphp

@switch($nombre)

    @case('software')
        <svg {!! $comunes !!} {{ $attributes }}>
            <rect x="2.5" y="3.5" width="19" height="15" rx="2"/>
            <path d="M2.5 8h19M5.5 5.75h.01M8 5.75h.01M7 20.5h10"/>
            <path d="M7 12h4M7 15h7"/>
        </svg>
        @break

    @case('servidor')
        <svg {!! $comunes !!} {{ $attributes }}>
            <rect x="2.5" y="3" width="19" height="7" rx="1.5"/>
            <rect x="2.5" y="14" width="19" height="7" rx="1.5"/>
            <path d="M6 6.5h.01M6 17.5h.01M9.5 6.5h.01M9.5 17.5h.01"/>
            <path d="M18.5 6.5h-2M18.5 17.5h-2"/>
        </svg>
        @break

    @case('nube')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M6.5 18.5a4.5 4.5 0 0 1-.5-8.97 6 6 0 0 1 11.6 1.55A4 4 0 0 1 17.5 18.5z"/>
        </svg>
        @break

    @case('nube-servidor')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M7 11.5a4 4 0 0 1 7.8-1.3A3.5 3.5 0 0 1 17 12"/>
            <path d="M6.5 12.5a3 3 0 0 0 0 6h11a3 3 0 0 0 0-6"/>
            <path d="M9 15.5h.01M12 15.5h.01"/>
            <path d="M12 3v3.5M9.5 5l2.5-2 2.5 2"/>
        </svg>
        @break

    @case('caja')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M20.5 8.5v7a1.5 1.5 0 0 1-.8 1.33l-7 3.6a1.5 1.5 0 0 1-1.4 0l-7-3.6a1.5 1.5 0 0 1-.8-1.33v-7"/>
            <path d="M3.5 8.5 12 4l8.5 4.5L12 13z"/>
            <path d="M12 13v7.6"/>
        </svg>
        @break

    @case('red')
        <svg {!! $comunes !!} {{ $attributes }}>
            <rect x="9" y="2.5" width="6" height="5" rx="1"/>
            <rect x="2.5" y="16.5" width="6" height="5" rx="1"/>
            <rect x="15.5" y="16.5" width="6" height="5" rx="1"/>
            <path d="M12 7.5v4M5.5 16.5v-2a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v2"/>
        </svg>
        @break

    @case('escudo')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M12 2.5 4.5 5.5v6c0 4.6 3.1 8.3 7.5 10 4.4-1.7 7.5-5.4 7.5-10v-6z"/>
            <path d="m9 11.8 2.2 2.2 4-4.2"/>
        </svg>
        @break

    @case('llave')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M14.5 6.5a4 4 0 0 0 5.2 5.2l-8 8a2.5 2.5 0 0 1-3.6-3.6l8-8a4 4 0 0 0-5.2-5.2l3 3-2.1 2.1-3-3a4 4 0 0 0 5.7-1.5"/>
        </svg>
        @break

    @case('copia')
        <svg {!! $comunes !!} {{ $attributes }}>
            <ellipse cx="12" cy="5.5" rx="7.5" ry="3"/>
            <path d="M4.5 5.5v6c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-6"/>
            <path d="M4.5 11.5v6c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-6"/>
        </svg>
        @break

    @case('sobre')
        <svg {!! $comunes !!} {{ $attributes }}>
            <rect x="2.5" y="4.5" width="19" height="15" rx="2"/>
            <path d="m3 6 8.07 5.66a1.6 1.6 0 0 0 1.86 0L21 6"/>
        </svg>
        @break

    @case('globo')
        <svg {!! $comunes !!} {{ $attributes }}>
            <circle cx="12" cy="12" r="9.5"/>
            <path d="M2.5 12h19"/>
            <path d="M12 2.5a14.5 14.5 0 0 1 0 19 14.5 14.5 0 0 1 0-19z"/>
        </svg>
        @break

    @case('portatil')
        <svg {!! $comunes !!} {{ $attributes }}>
            <rect x="4" y="4" width="16" height="11" rx="1.5"/>
            <path d="M2 18.5h20M9.5 18.5l.5-1.5h4l.5 1.5"/>
        </svg>
        @break

    @case('impresora')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M7 8.5V3.5h10v5"/>
            <rect x="2.5" y="8.5" width="19" height="8" rx="1.5"/>
            <path d="M7 13.5h10v7H7z"/>
            <path d="M5.5 11.5h.01"/>
        </svg>
        @break

    @case('telefono')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M8.4 3.5H5.6A2.1 2.1 0 0 0 3.5 5.8c0 8.1 6.6 14.7 14.7 14.7a2.1 2.1 0 0 0 2.3-2.1v-2.8l-4.6-1.5-1.9 2.3a14.9 14.9 0 0 1-6.2-6.2L10 8.1z"/>
        </svg>
        @break

    @case('reloj')
        <svg {!! $comunes !!} {{ $attributes }}>
            <circle cx="12" cy="12" r="9.5"/>
            <path d="M12 6.5V12l3.5 2"/>
        </svg>
        @break

    @case('mapa')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M12 21.5s7-5.7 7-11a7 7 0 1 0-14 0c0 5.3 7 11 7 11z"/>
            <circle cx="12" cy="10.5" r="2.5"/>
        </svg>
        @break

    @case('descarga')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M12 3.5v11M8 11l4 4 4-4"/>
            <path d="M4 16.5v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
        </svg>
        @break

    @case('flecha')
        <svg {!! $comunes !!} {{ $attributes }}>
            <path d="M4.5 12h15M13.5 6l6 6-6 6"/>
        </svg>
        @break

    @case('windows')
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false" {{ $attributes }}>
            <path d="M3 5.6l7.2-1v6.9H3zM11.2 4.4L21 3v8.5h-9.8zM3 12.5h7.2v6.9L3 18.4zM11.2 12.5H21V21l-9.8-1.4z"/>
        </svg>
        @break

    @case('apple')
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false" {{ $attributes }}>
            <path d="M16.4 12.7c0-2.4 2-3.6 2.1-3.7-1.1-1.7-2.9-1.9-3.5-1.9-1.5-.2-2.9.9-3.6.9s-1.9-.9-3.1-.8c-1.6 0-3.1.9-3.9 2.4-1.7 2.9-.4 7.2 1.2 9.5.8 1.1 1.7 2.4 3 2.4 1.2 0 1.6-.8 3.1-.8s1.9.8 3.1.7c1.3 0 2.1-1.1 2.9-2.3.9-1.3 1.3-2.6 1.3-2.7 0 0-2.5-1-2.6-3.7zM14 5.5c.6-.8 1.1-1.9 1-3-.9 0-2.1.6-2.8 1.5-.6.7-1.2 1.8-1 2.9 1 0 2.1-.5 2.8-1.4z"/>
        </svg>
        @break

    @default
        <svg {!! $comunes !!} {{ $attributes }}>
            <circle cx="12" cy="12" r="9.5"/>
        </svg>
@endswitch
