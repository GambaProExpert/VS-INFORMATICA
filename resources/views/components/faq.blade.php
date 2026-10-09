@props(['preguntas' => []])

{{--
    Las preguntas y respuestas que ya estaban escritas así en el sitio original
    ("¿tengo que hacer las copias manualmente?"). Se mantienen en minúscula
    porque es como las escribieron, y funcionan: son las dudas reales que le
    plantea un cliente al técnico.

    Marcado como <dl> para que un lector de pantalla entienda que son pares
    pregunta/respuesta y no párrafos sueltos.
--}}
<dl data-anim="lista" {{ $attributes->class(['divide-y divide-linea rounded-tarjeta border border-linea bg-tarjeta']) }}>
    @foreach ($preguntas as $item)
        <div class="p-6 lg:p-7">
            <dt class="text-[17px] font-semibold text-azafran-oscuro">
                {{ $item['pregunta'] }}
            </dt>
            <dd class="medida mt-3 space-y-3 leading-relaxed text-tenue">
                @foreach ((array) $item['respuesta'] as $parrafo)
                    <p>{!! $parrafo !!}</p>
                @endforeach
            </dd>
        </div>
    @endforeach
</dl>
