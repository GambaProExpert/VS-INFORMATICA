@php
    use App\Contenido\Servicios;

    $secciones = Servicios::secciones();
    $empresa = config('empresa');
    $direccion = $empresa['direccion'];
@endphp

{{-- x-data vacío: Alpine necesita un ámbito para que $dispatch del botón de
     cookies funcione, aunque el pie no guarde ningún estado propio. --}}
<footer x-data class="mt-20 border-t border-linea bg-niebla">

    {{-- Franja de partners. En el sitio original vivía en una banda oscura
         justo encima del pie; aquí abre el pie, que es donde la gente busca
         "¿y estos de qué van?". --}}
    <x-logos-partners />

    <div class="contenedor py-14">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">

            {{-- Identidad + NAP. El mismo nombre, dirección y teléfono que en
                 Google y en el aviso legal: si divergen, el SEO local sufre. --}}
            <div class="lg:col-span-2">
                <img src="{{ asset('images/marca/logo.png') }}"
                     alt="{{ $empresa['nombre_largo'] }}"
                     width="180" height="180"
                     class="h-14 w-auto"
                     loading="lazy">

                <address class="mt-5 space-y-1 not-italic text-sm text-tenue">
                    <p class="font-medium text-tinta">{{ $empresa['razon_social'] }}</p>
                    <p>{{ $direccion['calle'] }}</p>
                    <p>{{ $direccion['cp'] }} {{ $direccion['localidad'] }} ({{ $direccion['provincia'] }})</p>
                    <p class="pt-2">
                        <a href="tel:{{ $empresa['telefono']['e164'] }}"
                           class="font-sans font-medium tabular-nums text-tinta transition hover:text-azafran-oscuro">
                            {{ $empresa['telefono']['legible'] }}
                        </a>
                    </p>
                    <p>
                        <a href="mailto:{{ $empresa['email'] }}"
                           class="transition hover:text-azafran-oscuro">{{ $empresa['email'] }}</a>
                    </p>
                </address>

                <p class="mt-5 flex items-start gap-2 text-sm text-tenue">
                    <x-icono nombre="reloj" class="mt-0.5 h-4 w-4 shrink-0"/>
                    <span>{{ $empresa['horario']['texto'] }}</span>
                </p>

                <div class="mt-6">
                    <p class="etiqueta text-[11px] text-tenue">Síguenos en la red</p>
                    <div class="mt-2 flex gap-2">
                        <a href="{{ $empresa['redes']['facebook'] }}"
                           target="_blank" rel="noopener noreferrer"
                           class="rounded-boton border border-linea bg-papel p-2 text-tenue transition hover:text-tinta"
                           aria-label="VS Informática en Facebook">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M14 8.5V6.8c0-.8.2-1.3 1.5-1.3h1.6V2.6c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.4-4 4.1v1.9H8.2v3h2.5V19H14v-8.5h2.5l.4-3z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- El mapa completo de servicios, igual que en el pie original --}}
            @foreach ($secciones as $seccion)
                <div>
                    <h2 class="font-display text-sm font-semibold text-tinta">
                        <a href="{{ $seccion['url'] }}" class="transition hover:text-azafran-oscuro">
                            {{ $seccion['nav'] }}
                        </a>
                    </h2>

                    @if (! empty($seccion['hijos']))
                        <ul class="mt-3 space-y-2">
                            @foreach ($seccion['hijos'] as $hijo)
                                <li>
                                    <a href="{{ $hijo['url'] }}"
                                       class="text-sm text-tenue transition hover:text-tinta">{{ $hijo['nav'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>

        <hr class="my-10 border-linea">

        <div class="flex flex-col gap-4 text-sm text-tenue lg:flex-row lg:items-center lg:justify-between">
            <p>
                © {{ $empresa['fundacion'] }}–{{ now()->year }}
                {{ $empresa['razon_social'] }} · CIF {{ $empresa['cif'] }}
            </p>

            <nav aria-label="Enlaces legales" class="flex flex-wrap items-center gap-x-5 gap-y-2">
                <a href="{{ route('legal.aviso') }}" class="transition hover:text-tinta">Aviso legal</a>
                <a href="{{ route('legal.privacidad') }}" class="transition hover:text-tinta">Privacidad</a>
                <a href="{{ route('legal.cookies') }}" class="transition hover:text-tinta">Cookies</a>
                <a href="{{ route('mapa') }}" class="transition hover:text-tinta">Mapa del sitio</a>
                <button type="button"
                        @click="$dispatch('abrir-cookies')"
                        class="transition hover:text-tinta">Cambiar consentimiento</button>
            </nav>
        </div>
    </div>
</footer>
