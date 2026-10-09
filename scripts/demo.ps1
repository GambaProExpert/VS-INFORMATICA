<#
    Deja la web lista para enseñársela a alguien de fuera por un túnel.

        .\scripts\demo.ps1

    Un túnel (Dev Tunnels de Visual Studio, Cloudflare, ngrok) publica una URL
    https:// que reenvía a este ordenador. Lo que no hace es preparar la web
    para que aguante ese viaje, y hay cuatro cosas que hay que tocar. De ahí
    este guion: son cuatro, se olvida una y la demostración se ve rota.

      1. QUITAR public/hot. Con `npm run dev` en marcha, Laravel escribe ahí la
         dirección del servidor de Vite y las páginas piden el CSS y el JS a
         localhost:5173 — que en casa de quien mira ES SU PROPIO ORDENADOR. Se
         ve el texto sin un solo estilo. Es, con diferencia, el fallo que más
         veces se comete.

      2. COMPILAR. Sin el servidor de Vite hay que servir los ficheros del
         manifiesto, así que toca `npm run build`.

      3. APAGAR EL DEPURADOR. Con APP_DEBUG=true cualquier fallo le enseña al
         visitante una pantalla con las rutas de tu disco y tu configuración.

      4. NOINDEX. La URL del túnel es pública. Si un buscador la encuentra,
         VS Informática acaba con una copia de su web compitiendo contra ella
         misma. Lo pone el middleware NoIndexar al ver DEMO_PUBLICA=true.

    Los ajustes 3 y 4 van como variables de entorno de este proceso, no
    editando el .env: el repositorio de configuración de Laravel es inmutable,
    así que lo que ya existe en el entorno gana sobre el fichero. Cuando cierres
    el servidor no queda nada que deshacer ni ningún .env a medio revertir.

    Para volver a desarrollar: `npm run dev` y a seguir.
#>

param(
    [int] $Puerto = 8000,
    [switch] $SinCompilar
)

$ErrorActionPreference = 'Stop'
$raiz = Split-Path $PSScriptRoot -Parent

function Paso($texto) { Write-Host "`n>> $texto" -ForegroundColor Cyan }
function Aviso($texto) { Write-Host "   $texto" -ForegroundColor Yellow }
function Bien($texto)  { Write-Host "   $texto" -ForegroundColor Green }

# --- 1. El servidor de Vite no puede estar mandando -------------------------
Paso 'Comprobando el servidor de Vite'

$hot = Join-Path $raiz 'public\hot'
if (Test-Path $hot) {
    Aviso "Estaba activo y apuntaba a $((Get-Content $hot -Raw).Trim())"
    Aviso 'Se retira public/hot: con él, tu cliente buscaría los estilos en su propio ordenador.'
    Remove-Item $hot -Force
    Aviso 'Si tienes `npm run dev` abierto en otra terminal, ciérralo: al reiniciarse volvería a crearlo.'
} else {
    Bien 'No está activo.'
}

# --- 2. Compilar ------------------------------------------------------------
if ($SinCompilar) {
    Paso 'Compilación omitida (-SinCompilar)'
} else {
    Paso 'Compilando los assets'
    Push-Location $raiz
    try { npm run build } finally { Pop-Location }
    if ($LASTEXITCODE -ne 0) { throw 'Ha fallado npm run build.' }
}

if (-not (Test-Path (Join-Path $raiz 'public\build\manifest.json'))) {
    throw 'No hay manifest.json en public/build. Sin él la web se sirve sin estilos.'
}
Bien 'Manifiesto en su sitio.'

# --- 3. Configuración de la demostración ------------------------------------
Paso 'Preparando la configuración'

$env:APP_DEBUG    = 'false'   # nada de trazas de error delante de un cliente
$env:DEMO_PUBLICA = 'true'    # activa la cabecera noindex
$env:APP_ENV      = 'local'

Push-Location $raiz
try {
    php artisan config:clear | Out-Null
    php artisan view:cache   | Out-Null
} finally { Pop-Location }
Bien 'Depurador apagado y noindex activo.'

# --- 4. Recordatorios que no puede resolver un guion ------------------------
Paso 'Antes de pasarle el enlace a nadie'
Write-Host @"
   - El formulario de contacto NO envía correos (MAIL_MAILER=log). Si lo prueba,
     verá el mensaje de recibido pero no llegará nada. Las consultas sí se
     guardan en la base de datos. Avísale antes o pensará que está roto.
   - En Dev Tunnels, el puerto nace privado y quien entre verá una pantalla de
     inicio de sesión de Microsoft. Para que pase sin cuenta:
        devtunnel port create -p $Puerto --allow-anonymous
   - Mientras dure la demostración este ordenador tiene que estar encendido y
     esta ventana abierta.
"@ -ForegroundColor DarkGray

# --- 5. En marcha -----------------------------------------------------------
Paso "Sirviendo en http://127.0.0.1:$Puerto  (Ctrl+C para terminar)"
Write-Host "   Ahora abre el túnel contra el puerto $Puerto desde Visual Studio," -ForegroundColor DarkGray
Write-Host "   o con:  cloudflared tunnel --url http://localhost:$Puerto" -ForegroundColor DarkGray
Write-Host ''

Push-Location $raiz
try {
    php artisan serve --port=$Puerto
} finally {
    Pop-Location
    Write-Host "`nDemostración terminada. Para volver a desarrollar: npm run dev" -ForegroundColor Cyan
}
