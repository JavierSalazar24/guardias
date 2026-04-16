export const EXCLUDE_GENERAL = [
  '/ventas-historial',
  '/asignamiento-historial',
  '/cartera-vencida',
  '/logs',
  '/limpieza-logs'
]

export const EXCLUDE_EDIT = [
  '/check-guardia',
  '/reporte-bitacoras',
  '/reporte-incidente-guardia',
  '/reporte-guardia',
  '/reporte-supervisor',
  '/reporte-patrullas',
  '/recorridos-guardia',
  '/movimientos-bancarios',
  '/orden-servicio-eliminadas'
]

export const EXCLUDE_DELETE = [
  '/almacen-salidas',
  '/almacen-entradas',
  '/blacklist-guardias',
  '/movimientos-bancarios',
  '/orden-servicio-eliminadas'
]

export const EXCLUDE_CREATE = [
  '/compras',
  '/almacen',
  ...EXCLUDE_GENERAL,
  ...EXCLUDE_EDIT,
  '/recorridos-guardia',
  '/movimientos-bancarios',
  '/ventas'
]
