import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  root: 'resources',
  base: '/',
  plugins: [vue()],
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js', 
    },
  },
  build: {
    outDir: '../public/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: [
        'resources/js/app.js',
      ],
    },
  },
  server: {
    host: 'localhost',
    port: 2137,
    strictPort: true,
    hmr: {
        host: 'localhost',
    }
  }
});