{{--
    El cuadrito de tema: claro · sistema · oscuro.

    Es un radiogroup de verdad (no tres botones sueltos) para que un lector de
    pantalla anuncie "1 de 3" y las flechas del teclado funcionen como se espera.
--}}
<div x-data="selectorTema()"
     role="radiogroup"
     aria-label="Tema de la web"
     @keydown.arrow-right.prevent="mover(1)"
     @keydown.arrow-left.prevent="mover(-1)"
     @keydown.arrow-down.prevent="mover(1)"
     @keydown.arrow-up.prevent="mover(-1)"
     {{ $attributes->class(['inline-flex items-center gap-0.5 rounded-boton border border-linea bg-niebla p-0.5']) }}>

    <button type="button"
            role="radio"
            x-ref="claro"
            @click="elegir('claro')"
            :aria-checked="tema === 'claro'"
            :tabindex="tema === 'claro' ? 0 : -1"
            :class="clases('claro')"
            class="rounded-[4px] p-1.5 transition"
            title="Tema claro">
        <span class="sr-only">Tema claro</span>
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor"
             stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
            <circle cx="10" cy="10" r="3.5"/>
            <path d="M10 2v1.5M10 16.5V18M18 10h-1.5M3.5 10H2M15.7 4.3l-1 1M5.3 14.7l-1 1M15.7 15.7l-1-1M5.3 5.3l-1-1"/>
        </svg>
    </button>

    <button type="button"
            role="radio"
            x-ref="sistema"
            @click="elegir('sistema')"
            :aria-checked="tema === 'sistema'"
            :tabindex="tema === 'sistema' ? 0 : -1"
            :class="clases('sistema')"
            class="rounded-[4px] p-1.5 transition"
            title="Seguir al sistema">
        <span class="sr-only">Seguir al sistema</span>
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor"
             stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="2.5" y="3.5" width="15" height="10" rx="1.5"/>
            <path d="M7 17h6M10 13.5V17"/>
        </svg>
    </button>

    <button type="button"
            role="radio"
            x-ref="oscuro"
            @click="elegir('oscuro')"
            :aria-checked="tema === 'oscuro'"
            :tabindex="tema === 'oscuro' ? 0 : -1"
            :class="clases('oscuro')"
            class="rounded-[4px] p-1.5 transition"
            title="Tema oscuro">
        <span class="sr-only">Tema oscuro</span>
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor"
             stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M16.5 11.8A7 7 0 1 1 8.2 3.5a5.5 5.5 0 0 0 8.3 8.3z"/>
        </svg>
    </button>
</div>
