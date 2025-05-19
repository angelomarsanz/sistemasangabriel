import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import {resolve} from 'path';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  build: {
    manifest: true,
    rollupOptions: {
      input: {
          'main-script': resolve(__dirname, 'src/main.jsx'),
          'main-style': resolve(__dirname, 'src/index.css')
      },
      external: ['jQuery'],
      globals: {
          jQuery: 'jQuery',
      },
      output: {
          entryFileNames: '[name].js',
          assetFileNames: (assetInfo) => { 
              const extension = assetInfo.name.split('.').pop();
              if (extension === 'css') return `${assetInfo.name}`;
              return assetInfo.name;
          },
      },
    },
    root: 'src',
    chunkSizeWarningLimit: 10000,
  }
})