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
  ShieldCheck
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
      { label: 'Tipo de descuento', path: '/modulo-descuentos' },
      { label: 'Tipo de préstamo', path: '/modulo-prestamos' }
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
      { path: '/cotizaciones', label: 'Cotizaciones' },
      { path: '/ventas', label: 'Ventas' },
      { path: '/orden-servicio', label: 'Orden de servicio' },
      { path: '/generar-qr', label: 'Generar QRs' }
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
    label: 'Finanzas',
    Icon: Landmark,
    children: [
      { path: '/bancos', label: 'Bancos' },
      { path: '/movimientos-bancarios', label: 'Movimientos' },
      { path: '/estadocuenta-bancos', label: 'Estado de cuenta' }
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
      { path: '/modulos', label: 'Módulos' },
      { path: '/logs', label: 'Movimientos' }
    ]
  },
  { path: '/generador-reportes', label: 'Reportes', Icon: FileText },
  {
    path: '/cartera-vencida',
    label: 'Cartera vencida',
    Icon: Wallet
  },
  {
    path: '/ventas-historial',
    label: 'Historial de ventas',
    Icon: FolderClock
  }
]
