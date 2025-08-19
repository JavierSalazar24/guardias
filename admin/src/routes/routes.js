import {
  Archive,
  BarChart3,
  Landmark,
  ShieldUser,
  UserRoundPen,
  UsersRound,
  ArrowRightLeft,
  FolderClock,
  Handshake,
  Settings,
  FileText,
  Wallet,
  ClipboardList,
  Building,
  Car,
  ShieldCheck,
  Database,
  MonitorSmartphone
} from 'lucide-react'

export const routes = [
  { path: '/', label: 'Dashboard', Icon: BarChart3 },
  { path: '/sucursales-empresa', label: 'Sucursales', Icon: Building },
  {
    label: 'Personal',
    Icon: ShieldUser,
    children: [
      { label: 'Guardias', path: '/guardias' },
      { label: 'Equipo asignado', path: '/equipo' },
      { label: 'Lista negra', path: '/blacklist' }
    ]
  },
  {
    label: 'Recursos Humanos',
    Icon: ClipboardList,
    children: [
      { label: 'Incapacidades', path: '/incapacidades' },
      { label: 'Tiempo extra', path: '/tiempo-extra' },
      { label: 'Faltas', path: '/faltas' },
      { label: 'Descuentos', path: '/descuentos' },
      { label: 'Vacaciones', path: '/vacaciones' },
      { label: 'Préstamos', path: '/prestamos' },
      { label: 'Abonos', path: '/abonos-prestamo' },
      { label: 'Pagos a guardias', path: '/pagos-empleados' },
      { label: 'Estado de cuenta', path: '/estadocuenta-guardias' },
      { label: 'Reportes', path: '/reportes-guardias' },
      { label: 'Mótivo de descuento', path: '/modulo-descuentos' },
      { label: 'Mótivo de préstamo', path: '/modulo-prestamos' }
    ]
  },
  {
    label: 'Finanzas',
    Icon: Landmark,
    children: [
      { path: '/bancos', label: 'Bancos' },
      { path: '/movimientos-bancarios', label: 'Movimientos' },
      { path: '/estadocuenta-bancos', label: 'Estado de cuenta' }
    ]
  },
  {
    label: 'Clientes',
    Icon: UserRoundPen,
    children: [
      { path: '/clientes', label: 'Clientes' },
      { path: '/sucursales', label: 'Sucursales' },
      { label: 'Estado de cuenta', path: '/estadocuenta-clientes' }
    ]
  },
  {
    label: 'Proveedores',
    Icon: UsersRound,
    children: [
      { path: '/proveedores', label: 'Proveedores' },
      { label: 'Estado de cuenta', path: '/estadocuenta-proveedores' }
    ]
  },
  {
    label: 'Reporte servicios',
    Icon: ShieldCheck,
    children: [
      { path: '/check-guardia', label: 'Check-in/out' },
      { path: '/reporte-bitacoras', label: 'Bitácoras' },
      { path: '/reporte-incidente-guardia', label: 'Incidentes' },
      { path: '/reporte-guardia', label: 'Guardias' },
      { path: '/reporte-supervisor', label: 'Supervisores' },
      { path: '/reporte-patrullas', label: 'Patrullas' },
      { path: '/recorridos-guardia', label: 'Recorridos' }
    ]
  },
  {
    label: 'Servicios',
    Icon: Handshake,
    children: [
      { path: '/tipos-servicios', label: 'Tipos de servicios' },
      { path: '/cotizaciones', label: 'Cotizaciones' },
      { path: '/ventas', label: 'Ventas' },
      { path: '/orden-servicio', label: 'Orden de servicio' },
      { path: '/generar-qr', label: 'Generar QRs' }
    ]
  },
  {
    label: 'Inventario',
    Icon: Archive,
    children: [
      { path: '/articulos', label: 'Artículos' },
      { path: '/almacen', label: 'Almacen' },
      { path: '/almacen-entradas', label: 'Entradas' },
      { path: '/almacen-salidas', label: 'Salidas' }
    ]
  },
  {
    label: 'Vehículos',
    Icon: Car,
    children: [
      { path: '/vehiculos', label: 'Vehículos' },
      { path: '/boletas-gasolina', label: 'Boletas de gasolina' }
    ]
  },
  {
    label: 'Operaciones',
    Icon: ArrowRightLeft,
    children: [
      { path: '/modulo-conceptos', label: 'Tipos de concepto' },
      { path: '/ordenes-compra', label: 'Ordenes de compra' },
      { path: '/compras', label: 'Compras' },
      { path: '/gastos', label: 'Gastos' }
    ]
  },
  {
    label: 'Configuración',
    Icon: Settings,
    children: [
      { path: '/usuarios', label: 'Usuarios' },
      { path: '/roles', label: 'Roles' },
      // { path: '/modulos', label: 'Módulos' },
      { path: '/logs', label: 'Logs' }
    ]
  },
  {
    label: 'Historial',
    Icon: FolderClock,
    children: [
      { path: '/ventas-historial', label: 'Ventas' },
      { path: '/orden-servicio-eliminadas', label: 'Ordenes de servicio' }
    ]
  },
  {
    label: 'Limpieza',
    Icon: Database,
    children: [
      { path: '/limpiezas-programadas', label: 'Limpieza programada' },
      { path: '/limpieza-logs', label: 'Registros limpiados' }
    ]
  },
  { path: '/generador-reportes', label: 'Reportes', Icon: FileText },
  { path: '/cartera-vencida', label: 'Cartera vencida', Icon: Wallet },
  { path: '/descargar-app', label: 'Descargar App', Icon: MonitorSmartphone }
]
