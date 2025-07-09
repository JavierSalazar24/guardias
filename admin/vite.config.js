import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react-swc'
import tailwindcss from '@tailwindcss/vite'
import { VitePWA } from 'vite-plugin-pwa'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    react(),
    tailwindcss(),
    VitePWA({
      registerType: 'autoUpdate',
      includeAssets: [
        'favicon.ico',
        'pwa/apple-touch-icon.png',
        'pwa/pwa-96x96.png',
        'pwa/pwa-192x192.png',
        'pwa/pwa-512x512.png'
      ],
      manifest: {
        name: 'Guardias Admin Arcanix',
        short_name: 'Arcanix',
        description:
          'Panel administrativo realizado por Arcanix para empresas de seguridad privada, con control de guardias, ordenes de servicio, entre otras',
        theme_color: '#1e3a8a',
        background_color: '#ffffff',
        display: 'standalone',
        orientation: 'portrait',
        scope: '/',
        start_url: '/',
        lang: 'es-MX',
        icons: [
          {
            src: '/pwa/pwa-96x96.png',
            sizes: '96x96',
            type: 'image/png'
          },
          {
            src: '/pwa/pwa-192x192.png',
            sizes: '192x192',
            type: 'image/png'
          },
          {
            src: '/pwa/pwa-512x512.png',
            sizes: '512x512',
            type: 'image/png'
          },
          {
            src: '/pwa/pwa-512x512.png',
            sizes: '512x512',
            type: 'image/png',
            purpose: 'any maskable'
          },
          {
            src: '/pwa/apple-touch-icon.png',
            sizes: '180x180',
            type: 'image/png',
            purpose: 'apple touch icon'
          }
        ]
      }
    })
  ]
})
