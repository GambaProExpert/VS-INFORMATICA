<x-mail::message>
# Nueva consulta desde la web

**{{ $consulta->nombre }}**@if ($consulta->empresa) · {{ $consulta->empresa }}@endif

- **Teléfono:** [{{ $consulta->telefono }}](tel:{{ preg_replace('/\s+/', '', $consulta->telefono) }})
- **Email:** [{{ $consulta->email }}](mailto:{{ $consulta->email }})
- **Recibida:** {{ $consulta->created_at->timezone(config('empresa.zona_horaria'))->format('d/m/Y \a \l\a\s H:i') }}

---

{{ $consulta->mensaje }}

---

<x-mail::button :url="'tel:' . preg_replace('/\s+/', '', $consulta->telefono)">
Llamar a {{ $consulta->nombre }}
</x-mail::button>

Consentimiento de privacidad aceptado el
{{ $consulta->consentido_en->timezone(config('empresa.zona_horaria'))->format('d/m/Y H:i') }}
desde la IP {{ $consulta->ip ?? 'desconocida' }}.

{{ config('empresa.nombre_largo') }}
</x-mail::message>
