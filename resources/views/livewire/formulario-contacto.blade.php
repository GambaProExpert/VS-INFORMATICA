@php
    $claseCampo = 'w-full rounded-boton border border-linea bg-papel px-3.5 py-2.5 text-tinta '
                . 'placeholder:text-tenue/70 transition focus:border-azafran focus:outline-none '
                . 'focus:ring-2 focus:ring-azafran/25';
    $claseEtiqueta = 'block text-sm font-medium text-tinta';
    $claseError = 'mt-1.5 text-sm text-azafran-oscuro';
@endphp

<div>
    @if ($enviado)

        {{-- Estado de éxito. Sin recargar la página y sin perder de vista el
             teléfono: hay urgencias que no esperan a un correo. --}}
        <div class="rounded-tarjeta border border-activo/30 bg-activo/5 p-7 text-center">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-activo/15">
                <svg class="h-6 w-6 text-activo" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m5 12.5 4.5 4.5L19 7.5"/>
                </svg>
            </span>

            <p class="mt-4 font-display text-xl font-semibold text-tinta">Recibido.</p>
            <p class="mt-2 text-tenue">
                Te llamamos hoy mismo en horario comercial.
            </p>

            <div class="mt-5 flex flex-col items-center gap-3">
                <p class="text-sm text-tenue">
                    ¿Es urgente? Llámanos al
                    <a href="tel:{{ config('empresa.telefono.e164') }}"
                       class="font-sans font-medium tabular-nums text-azafran-oscuro underline underline-offset-2">
                        {{ config('empresa.telefono.legible') }}
                    </a>
                </p>
            </div>
        </div>

    @else

        <form wire:submit="enviar" novalidate class="space-y-5">

            {{-- Honeypot: invisible para personas, irresistible para bots.
                 aria-hidden y tabindex="-1" lo sacan del teclado y del lector
                 de pantalla, pero sigue estando en el DOM. --}}
            <div class="trampa" aria-hidden="true">
                <label for="apellidos">No rellenar este campo</label>
                <input type="text" id="apellidos" wire:model="apellidos" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="nombre" class="{{ $claseEtiqueta }}">
                        Nombre <span class="text-azafran-oscuro" aria-hidden="true">*</span>
                    </label>
                    <input type="text" id="nombre" wire:model.blur="nombre"
                           autocomplete="name" required
                           @error('nombre') aria-invalid="true" aria-describedby="error-nombre" @enderror
                           class="mt-1.5 {{ $claseCampo }}">
                    @error('nombre')
                        <p id="error-nombre" class="{{ $claseError }}">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="empresa" class="{{ $claseEtiqueta }}">
                        Empresa <span class="font-normal text-tenue">(opcional)</span>
                    </label>
                    <input type="text" id="empresa" wire:model.blur="empresa"
                           autocomplete="organization"
                           class="mt-1.5 {{ $claseCampo }}">
                    @error('empresa')
                        <p class="{{ $claseError }}">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telefono" class="{{ $claseEtiqueta }}">
                        Teléfono <span class="text-azafran-oscuro" aria-hidden="true">*</span>
                    </label>
                    <input type="tel" id="telefono" wire:model.blur="telefono"
                           autocomplete="tel" inputmode="tel" required
                           @error('telefono') aria-invalid="true" aria-describedby="error-telefono" @enderror
                           class="mt-1.5 {{ $claseCampo }}">
                    @error('telefono')
                        <p id="error-telefono" class="{{ $claseError }}">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="{{ $claseEtiqueta }}">
                        Email <span class="text-azafran-oscuro" aria-hidden="true">*</span>
                    </label>
                    <input type="email" id="email" wire:model.blur="email"
                           autocomplete="email" inputmode="email" required
                           @error('email') aria-invalid="true" aria-describedby="error-email" @enderror
                           class="mt-1.5 {{ $claseCampo }}">
                    @error('email')
                        <p id="error-email" class="{{ $claseError }}">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="mensaje" class="{{ $claseEtiqueta }}">
                    ¿Qué necesitas? <span class="text-azafran-oscuro" aria-hidden="true">*</span>
                </label>
                <textarea id="mensaje" wire:model.blur="mensaje" rows="5" required
                          placeholder="Cuéntanos qué te pasa o qué estás buscando. Si es una avería, dinos qué equipo es."
                          @error('mensaje') aria-invalid="true" aria-describedby="error-mensaje" @enderror
                          class="mt-1.5 {{ $claseCampo }} resize-y"></textarea>
                @error('mensaje')
                    <p id="error-mensaje" class="{{ $claseError }}">{{ $message }}</p>
                @enderror
            </div>

            {{-- Consentimiento sin premarcar, con enlace a la política. --}}
            <div>
                <label class="flex items-start gap-3">
                    <input type="checkbox" wire:model="consentimiento" required
                           class="mt-1 h-4 w-4 shrink-0 rounded-[3px] border-linea text-azafran
                                  focus:ring-2 focus:ring-azafran/25">
                    <span class="text-sm leading-relaxed text-tenue">
                        He leído y acepto la
                        <a href="{{ route('legal.privacidad') }}"
                           class="text-azafran-oscuro underline underline-offset-2">política de privacidad</a>.
                        Tus datos se usan solo para responderte, y se borran al año.
                    </span>
                </label>
                @error('consentimiento')
                    <p class="{{ $claseError }}">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 pt-1 sm:flex-row sm:items-center">
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-boton bg-azafran
                               px-6 py-3 font-medium text-sobre-azafran transition hover:bg-azafran-fuerte
                               disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove wire:target="enviar">Enviar consulta</span>
                    <span wire:loading wire:target="enviar" class="flex items-center gap-2">
                        <svg class="h-4 w-4 motion-safe:animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5" opacity=".25"/>
                            <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        Enviando…
                    </span>
                </button>

                <p class="font-medium text-xs text-tenue">
                    Los campos con <span class="text-azafran-oscuro">*</span> son obligatorios.
                </p>
            </div>
        </form>

    @endif
</div>
