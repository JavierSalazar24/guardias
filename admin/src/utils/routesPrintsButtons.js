import { API_HOST } from '../config'

export const routesPrintsButtons = {
  '/cotizaciones': {
    title: 'Imprimir cotización',
    href: (data) => `${API_HOST}/api/pdf/cotizacion/${data.id}`
  },
  '/generar-qr': {
    title: 'Imprimir QRs',
    href: (data) =>
      `${API_HOST}/ordenes-servicio/${data.orden_servicio?.id}/pdf-qrs`
  },
  '/pagos-empleados': {
    title: 'Imprimir comprobante de pago',
    href: (data) => `${API_HOST}/api/pdf/pagos-empleados/${data.id}`
  },
  '/check-guardia': {
    href: (data) => `${API_HOST}/api/pdf/reporte-check-guardia/${data.id}`
  },
  '/reporte-incidente-guardia': {
    href: (data) => `${API_HOST}/api/pdf/reporte-incidente-guardia/${data.id}`
  },
  '/reporte-guardia': {
    href: (data) => `${API_HOST}/api/pdf/reporte-guardia/${data.id}`
  },
  '/reporte-supervisor': {
    href: (data) => `${API_HOST}/api/pdf/reporte-supervisor/${data.id}`
  },
  '/reporte-bitacoras': {
    href: (data) => `${API_HOST}/api/pdf/reporte-bitacoras/${data.id}`
  },
  '/reporte-patrullas': {
    href: (data) => `${API_HOST}/api/pdf/reporte-patrullas/${data.id}`
  }
}
