import react from '@vitejs/plugin-react'
import { defineConfig } from 'vitest/config'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    host: true, // expõe a rede para fora do container
    port: 5173,
    watch: {
      usePolling: true // garante que o HMR detecte mudanças no Linux/Ubuntu
    }
  },
  test: {
    globals: true,
    environment: 'jsdom',
    setupFiles: './setupTests.ts',
  }
})
