@props(['migas' => []])

<nav aria-label="Migas de pan" {{ $attributes }}>
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 etiqueta text-[11px] text-tenue">
        @foreach ($migas as $miga)
            <li class="flex items-center gap-2">
                @if ($miga['url'])
                    <a href="{{ $miga['url'] }}" class="transition hover:text-tinta">{{ $miga['titulo'] }}</a>
                    <span aria-hidden="true" class="text-linea-fuerte">/</span>
                @else
                    <span class="text-tinta" aria-current="page">{{ $miga['titulo'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
