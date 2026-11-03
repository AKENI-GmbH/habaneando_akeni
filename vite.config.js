import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0",
        port: 5173,
        strictPort: true,
        watch: {
            ignored: ["**/storage/**", "**/bootstrap/cache/**"],
        },
        hmr: {
            host: process.env.VITE_HMR_HOST || "dev05.akeni.net",
            clientPort: Number(process.env.VITE_HMR_PORT) || 8087,
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
});
