import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig(({ mode }) => {
    // HMR-Host per .env steuerbar (lokal: VITE_HMR_HOST=localhost),
    // ohne Eintrag gilt weiterhin der Entwicklungsserver dev05.
    const env = loadEnv(mode, process.cwd(), "");

    return {
        server: {
            host: "0.0.0.0",
            port: 5173,
            strictPort: true,
            watch: {
                ignored: ["**/storage/**", "**/bootstrap/cache/**"],
            },
            hmr: {
                host: env.VITE_HMR_HOST || "dev05.akeni.net",
                clientPort: Number(env.VITE_HMR_CLIENT_PORT || 8087),
                path: "/vite-hmr",
            },
        },
        plugins: [
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: [
                    "resources/views/**",
                    "resources/js/**",
                    "resources/css/**",
                    "routes/**",
                    "app/Livewire/**",
                ],
            }),
        ],
    };
});
