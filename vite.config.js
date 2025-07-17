import { defineConfig } from 'vite';

export default defineConfig({
  root: 'resources',
  base: '/',
  build: {
    outDir: '../public/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: 'resources/js/app.js',
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