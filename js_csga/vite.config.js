import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

/**
 * Configuración de Vite para el proyecto js_csga.
 * Se definen múltiples puntos de entrada para integrar con CakePHP.
 */
export default defineConfig({
  plugins: [react()],
  build: {
    manifest: true,
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        'main-script': resolve(__dirname, 'src/main.jsx'),
        'main-style': resolve(__dirname, 'src/index.css')
      },
      external: ['jQuery'],
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: (assetInfo) => {
          const extension = assetInfo.name.split('.').pop();
          if (extension === 'css') {
            return '[name].[ext]';
          }
          return assetInfo.name;
        },
        globals: {
          jQuery: 'jQuery',
        },
      },
    },
    chunkSizeWarningLimit: 10000,
  }
});