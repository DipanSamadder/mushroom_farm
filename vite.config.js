import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
/*const host = 'https://projects.cilearningschool.com/galgotia-college/';*/
export default defineConfig({

    plugins: [
        laravel({

            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
   /* server: { 
        host, 
        hmr: { host }, 
    }, */
});
