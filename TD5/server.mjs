// Petit serveur Node.js qui fait tourner les fichiers PHP du TD
// avec PHP WebAssembly (npm install @php-wasm/node).
//
// On le demarre avec : npm start
// puis on ouvre http://localhost:8080/menu.html

import http from "node:http";
import { PHP, loadPHPRuntime, PHPRequestHandler } from "@php-wasm/universal";
import { getPHPLoaderModule, createNodeFsMountHandler } from "@php-wasm/node";

const PORT = Number(process.env.PORT || 8080);
const DOCROOT = "/www";

console.log("Demarrage de PHP WebAssembly...");

// 1. On charge PHP (version 8.3) compile en WebAssembly
const runtime = await loadPHPRuntime(await getPHPLoaderModule("8.3"));
const php = new PHP(runtime);

// 2. On branche le dossier courant du projet dans le disque de PHP
php.mkdirTree(DOCROOT);
php.mount(DOCROOT, createNodeFsMountHandler(process.cwd()));

// 3. cookieStore: false => les cookies du navigateur sont envoyes
//    directement a PHP (indispensable pour les sessions et les cookies du TD)
const handler = new PHPRequestHandler({
    php,
    documentRoot: DOCROOT,
    absoluteUrl: `http://127.0.0.1:${PORT}`,
    cookieStore: false,
});

const server = http.createServer(async (req, res) => {
    try {
        const url = new URL(req.url, `http://127.0.0.1:${PORT}`);

        // On lit le corps de la requete (formulaires POST)
        const chunks = [];
        for await (const chunk of req) chunks.push(chunk);
        const body = chunks.length ? Buffer.concat(chunks) : undefined;

        const response = await handler.request({
            method: req.method || "GET",
            url: url.pathname + url.search,
            headers: {
                ...req.headers,
                host: `127.0.0.1:${PORT}`,
            },
            body,
        });

        res.writeHead(response.httpStatusCode || 200, response.headers || {});
        res.end(Buffer.from(response.bytes));
    } catch (error) {
        console.error(error);
        res.writeHead(500, { "Content-Type": "text/plain; charset=utf-8" });
        res.end("Erreur du serveur PHP : " + error.message);
    }
});

server.listen(PORT, "0.0.0.0", () => {
    console.log(`Serveur pret : http://localhost:${PORT}/menu.html`);
});
