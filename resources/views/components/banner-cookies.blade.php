{{--
    Banner de cookies.

    Rechazar cuesta exactamente lo mismo que aceptar: mismo tamaño, mismo peso
    visual, mismo número de clics. Es lo que exige la AEPD y lo que evita el
    patrón oscuro del "Aceptar" gigante frente al "Configurar" en gris claro.

    Esta web no carga ninguna cookie de terceros hoy — ni analítica, ni mapas
    embebidos, ni tipografías de CDN — así que la decisión solo se guarda para
    cuando se añada alguna.
--}}
<div x-data="{
        visible: false,
        init() {
            this.visible = localStorage.getItem('cookies') === null;
            window.addEventListener('abrir-cookies', () => { this.visible = true });
        },
        decidir(valor) {
            localStorage.setItem('cookies', valor);
            this.visible = false;
        },
     }"
     x-show="visible"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-y-4 opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     role="dialog"
     aria-label="Consentimiento de cookies"
     class="fixed inset-x-0 bottom-0 z-50 p-4">

    <div class="contenedor">
        <div class="mx-auto max-w-3xl rounded-tarjeta border border-linea bg-tarjeta p-5 shadow-suave">
            <p class="text-sm text-tinta">
                Usamos cookies propias necesarias para que la web funcione. No usamos cookies de
                analítica ni de publicidad, y no compartimos tus datos con terceros.
                <a href="{{ route('legal.cookies') }}" class="text-azafran-oscuro underline underline-offset-2">
                    Más información
                </a>.
            </p>

            <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                <button type="button"
                        @click="decidir('aceptadas')"
                        class="rounded-boton bg-tinta px-4 py-2.5 text-sm font-medium text-papel transition hover:opacity-90">
                    Aceptar
                </button>
                <button type="button"
                        @click="decidir('rechazadas')"
                        class="rounded-boton border border-linea px-4 py-2.5 text-sm font-medium text-tinta transition hover:bg-niebla">
                    Rechazar
                </button>
            </div>
        </div>
    </div>
</div>
