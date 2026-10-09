/* Revisión visual final. Fichero temporal. */
import puppeteer from 'puppeteer-core';

const CHROME = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE = 'http://127.0.0.1:8123';
const SALIDA = 'C:\\Users\\Dell 5560\\.claude\\jobs\\9fd2d0f1\\tmp\\shots';
const espera = (ms) => new Promise((r) => setTimeout(r, ms));

const navegador = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--use-gl=angle', '--use-angle=swiftshader', '--enable-unsafe-swiftshader', '--no-sandbox'],
});

const errores = [];
const p = await navegador.newPage();
p.on('pageerror', (e) => errores.push(e.message));
p.on('response', (r) => { if (r.status() >= 400) errores.push(r.status() + ' -> ' + r.url()); });
p.on('console', (m) => { if (m.type() === 'error') errores.push(m.text()); });

await p.setViewport({ width: 1440, height: 900 });
await p.goto(BASE, { waitUntil: 'domcontentloaded' });
await p.evaluate(() => {
    localStorage.setItem('cookies', 'rechazadas');
    localStorage.setItem('tema', 'claro');
});

// Home, arriba
await p.goto(BASE, { waitUntil: 'networkidle0' });
await espera(1200);
await p.screenshot({ path: `${SALIDA}/final-home.png` });

// Home, tarjetas de servicio (para ver el reveal ya resuelto)
await p.evaluate(() => window.scrollTo(0, 1100));
await espera(1200);
await p.screenshot({ path: `${SALIDA}/final-tarjetas.png` });

// Una página de servicio
await p.goto(BASE + '/servicios/reparacion', { waitUntil: 'networkidle0' });
await espera(1200);
await p.screenshot({ path: `${SALIDA}/final-servicio.png` });

// Contacto (formulario + teléfono grande)
await p.goto(BASE + '/contacto', { waitUntil: 'networkidle0' });
await espera(1000);
await p.screenshot({ path: `${SALIDA}/final-contacto.png` });

// ¿Queda algo invisible después de que todo se haya revelado?
await p.goto(BASE, { waitUntil: 'networkidle0' });
await p.evaluate(async () => {
    for (let y = 0; y < document.body.scrollHeight; y += 400) {
        window.scrollTo(0, y);
        await new Promise((r) => setTimeout(r, 60));
    }
});
await espera(1500);
const invisibles = await p.evaluate(() =>
    Array.from(document.querySelectorAll('[data-anim], [data-anim="lista"] > *'))
        .filter((el) => getComputedStyle(el).opacity === '0')
        .map((el) => ({
            etiqueta: el.tagName,
            clases: (el.className || '').toString().slice(0, 70),
            padre: el.parentElement?.getAttribute('data-anim') ?? '-',
            texto: (el.innerText || '').replace(/\s+/g, ' ').slice(0, 45),
        })));
console.log('invisibles:', JSON.stringify(invisibles, null, 1));
console.log('errores:', errores.length ? errores.slice(0, 5) : 'ninguno');

await navegador.close();
