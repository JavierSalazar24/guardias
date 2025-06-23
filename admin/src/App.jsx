import { Toaster } from 'sonner'
import { lazy, Suspense, useState } from 'react'
import { Routes, Route, Navigate } from 'react-router'
import { Sidebar } from './components/Sidebar'
import { Navbar } from './components/Navbar'
import Loading from './components/Loading'
import { useAuth } from './context/AuthContext'
import { PrivateRoute } from './components/PrivateRoute'

const AdminPage = lazy(() => import('./pages/AdminPage'))
const SucursalesEmpresaPage = lazy(() =>
  import('./pages/SucursalesEmpresaPage')
)
const GuardiasPage = lazy(() => import('./pages/GuardiasPage'))
const EquipamientoPage = lazy(() => import('./pages/EquipamientoPage'))
const BlackListPage = lazy(() => import('./pages/BlackListPage'))
const ClientesPage = lazy(() => import('./pages/ClientesPage'))
const SucursalesPage = lazy(() => import('./pages/SucursalesPage'))
const ProveedoresPage = lazy(() => import('./pages/ProveedoresPage'))
const CotizacionesPage = lazy(() => import('./pages/CotizacionesPage'))
const VentasPage = lazy(() => import('./pages/VentasPage'))
const OrdenesServiciosPage = lazy(() => import('./pages/OrdenesServiciosPage'))
const GenerarQRSPage = lazy(() => import('./pages/GenerarQRSPage'))
const RecorridosGuardiaPage = lazy(() =>
  import('./pages/RecorridosGuardiaPage')
)
const ArticulosPage = lazy(() => import('./pages/ArticulosPage'))
const VehiculosPage = lazy(() => import('./pages/VehiculosPage'))
const BoletasGasolinaPage = lazy(() => import('./pages/BoletasGasolinaPage'))
const AlmacenPage = lazy(() => import('./pages/AlmacenPage'))
const AlmacenEntradasPage = lazy(() => import('./pages/AlmacenEntradasPage'))
const AlmacenSalidasPage = lazy(() => import('./pages/AlmacenSalidasPage'))
const BancosPage = lazy(() => import('./pages/BancosPage'))
const MovimientosBancariosPage = lazy(() =>
  import('./pages/MovimientosBancariosPage')
)
const OrdenesComprasPage = lazy(() => import('./pages/OrdenesComprasPage'))
const ComprasPage = lazy(() => import('./pages/ComprasPage'))
const GastosPage = lazy(() => import('./pages/GastosPage'))
const ReportesPage = lazy(() => import('./pages/ReportesPage'))
const ReporteCarteraVencidaPage = lazy(() =>
  import('./pages/ReporteCarteraVencidaPage')
)
const UsuariosPage = lazy(() => import('./pages/UsuariosPage'))
const RolesPage = lazy(() => import('./pages/RolesPage'))
const ModulosPage = lazy(() => import('./pages/ModulosPage'))
const LogsPage = lazy(() => import('./pages/LogsPage'))
const VentasHistorialPage = lazy(() => import('./pages/VentasHistorialPage'))

const IncapacidadesPage = lazy(() => import('./pages/IncapacidadesPage'))
const TiempoExtraPage = lazy(() => import('./pages/TiempoExtraPage'))
const FaltasPage = lazy(() => import('./pages/FaltasPage'))
const DescuentosPage = lazy(() => import('./pages/DescuentosPage'))
const VacacionesPage = lazy(() => import('./pages/VacacionesPage'))
const PrestamosPage = lazy(() => import('./pages/PrestamosPage'))
const AbonosPrestamosPage = lazy(() => import('./pages/AbonosPrestamosPage'))
const PagosEmpleadosPage = lazy(() => import('./pages/PagosEmpleadosPage'))

const ModuloPrestamosPage = lazy(() => import('./pages/ModuloPrestamosPage'))
const ModuloDescuentosPage = lazy(() => import('./pages/ModuloDescuentosPage'))
const ModuloConceptosPage = lazy(() => import('./pages/ModuloConceptosPage'))

const CheckGuardiasPage = lazy(() => import('./pages/CheckGuardiasPage'))
const ReportesBitacorasPage = lazy(() =>
  import('./pages/ReportesBitacorasPage')
)
const ReportesIncidentesGuardiaPage = lazy(() =>
  import('./pages/ReportesIncidentesGuardiaPage')
)
const ReporteGuardiasPage = lazy(() => import('./pages/ReporteGuardiasPage'))
const ReporteSupervisoresPage = lazy(() =>
  import('./pages/ReporteSupervisoresPage')
)
const ReportesPatrullasPage = lazy(() =>
  import('./pages/ReportesPatrullasPage')
)

const EstadoCuentaGuardiaPage = lazy(() =>
  import('./pages/EstadoCuentaGuardiaPage')
)
const EstadoCuentaClientePage = lazy(() =>
  import('./pages/EstadoCuentaClientePage')
)
const EstadoCuentaProveedorPage = lazy(() =>
  import('./pages/EstadoCuentaProveedorPage')
)
const EstadoCuentaBancoPage = lazy(() =>
  import('./pages/EstadoCuentaBancoPage')
)
const ReportesRHPage = lazy(() => import('./pages/ReportesRHPage'))

const PerfilPage = lazy(() => import('./pages/PerfilPage'))
const LoginPage = lazy(() => import('./pages/LoginPage'))

export default function App() {
  const { isAuthenticated, loading } = useAuth()
  const [sidebarOpen, setSidebarOpen] = useState(false)

  const toggleSidebar = () => setSidebarOpen(!sidebarOpen)

  if (loading) return <Loading />
  if (isAuthenticated === null) return <Loading />

  return (
    <Suspense fallback={<Loading />}>
      {isAuthenticated ? (
        <div className='flex h-screen bg-gray-100'>
          <Toaster richColors position='bottom-right' />
          <Sidebar sidebarOpen={sidebarOpen} toggleSidebar={toggleSidebar} />
          <div className='flex-1 flex flex-col overflow-hidden'>
            <Navbar toggleSidebar={toggleSidebar} />
            <main className='flex-1 overflow-auto p-4'>
              <Routes>
                <Route
                  index
                  path='/'
                  element={
                    <PrivateRoute>
                      <AdminPage />
                    </PrivateRoute>
                  }
                />

                <Route
                  path='/sucursales-empresa'
                  element={
                    <PrivateRoute>
                      <SucursalesEmpresaPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/guardias'
                  element={
                    <PrivateRoute>
                      <GuardiasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/equipo'
                  element={
                    <PrivateRoute>
                      <EquipamientoPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/blacklist'
                  element={
                    <PrivateRoute>
                      <BlackListPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/incapacidades'
                  element={
                    <PrivateRoute>
                      <IncapacidadesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/tiempo-extra'
                  element={
                    <PrivateRoute>
                      <TiempoExtraPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/faltas'
                  element={
                    <PrivateRoute>
                      <FaltasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/descuentos'
                  element={
                    <PrivateRoute>
                      <DescuentosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/vacaciones'
                  element={
                    <PrivateRoute>
                      <VacacionesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/prestamos'
                  element={
                    <PrivateRoute>
                      <PrestamosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/abonos-prestamo'
                  element={
                    <PrivateRoute>
                      <AbonosPrestamosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/pagos-empleados'
                  element={
                    <PrivateRoute>
                      <PagosEmpleadosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/estadocuenta-guardias'
                  element={
                    <PrivateRoute>
                      <EstadoCuentaGuardiaPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/reportes-guardias'
                  element={
                    <PrivateRoute>
                      <ReportesRHPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/modulo-prestamos'
                  element={
                    <PrivateRoute>
                      <ModuloPrestamosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/modulo-descuentos'
                  element={
                    <PrivateRoute>
                      <ModuloDescuentosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/clientes'
                  element={
                    <PrivateRoute>
                      <ClientesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/estadocuenta-clientes'
                  element={
                    <PrivateRoute>
                      <EstadoCuentaClientePage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/sucursales'
                  element={
                    <PrivateRoute>
                      <SucursalesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/proveedores'
                  element={
                    <PrivateRoute>
                      <ProveedoresPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/check-guardia'
                  element={
                    <PrivateRoute>
                      <CheckGuardiasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/reporte-bitacoras'
                  element={
                    <PrivateRoute>
                      <ReportesBitacorasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/reporte-incidente-guardia'
                  element={
                    <PrivateRoute>
                      <ReportesIncidentesGuardiaPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/reporte-guardia'
                  element={
                    <PrivateRoute>
                      <ReporteGuardiasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/reporte-supervisor'
                  element={
                    <PrivateRoute>
                      <ReporteSupervisoresPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/reporte-patrullas'
                  element={
                    <PrivateRoute>
                      <ReportesPatrullasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/estadocuenta-proveedores'
                  element={
                    <PrivateRoute>
                      <EstadoCuentaProveedorPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/cotizaciones'
                  element={
                    <PrivateRoute>
                      <CotizacionesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/ventas'
                  element={
                    <PrivateRoute>
                      <VentasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/orden-servicio'
                  element={
                    <PrivateRoute>
                      <OrdenesServiciosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/generar-qr'
                  element={
                    <PrivateRoute>
                      <GenerarQRSPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/recorridos-guardia'
                  element={
                    <PrivateRoute>
                      <RecorridosGuardiaPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/vehiculos'
                  element={
                    <PrivateRoute>
                      <VehiculosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/boletas-gasolina'
                  element={<BoletasGasolinaPage />}
                />
                <Route
                  path='/articulos'
                  element={
                    <PrivateRoute>
                      <ArticulosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/almacen'
                  element={
                    <PrivateRoute>
                      <AlmacenPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/almacen-entradas'
                  element={
                    <PrivateRoute>
                      <AlmacenEntradasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/almacen-salidas'
                  element={
                    <PrivateRoute>
                      <AlmacenSalidasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/bancos'
                  element={
                    <PrivateRoute>
                      <BancosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/movimientos-bancarios'
                  element={
                    <PrivateRoute>
                      <MovimientosBancariosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/estadocuenta-bancos'
                  element={
                    <PrivateRoute>
                      <EstadoCuentaBancoPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/modulo-conceptos'
                  element={
                    <PrivateRoute>
                      <ModuloConceptosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/ordenes-compra'
                  element={
                    <PrivateRoute>
                      <OrdenesComprasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/compras'
                  element={
                    <PrivateRoute>
                      <ComprasPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/gastos'
                  element={
                    <PrivateRoute>
                      <GastosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/generador-reportes'
                  element={
                    <PrivateRoute>
                      <ReportesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/cartera-vencida'
                  element={
                    <PrivateRoute>
                      <ReporteCarteraVencidaPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/usuarios'
                  element={
                    <PrivateRoute>
                      <UsuariosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/roles'
                  element={
                    <PrivateRoute>
                      <RolesPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/modulos'
                  element={
                    <PrivateRoute>
                      <ModulosPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/logs'
                  element={
                    <PrivateRoute>
                      <LogsPage />
                    </PrivateRoute>
                  }
                />
                <Route
                  path='/ventas-historial'
                  element={
                    <PrivateRoute>
                      <VentasHistorialPage />
                    </PrivateRoute>
                  }
                />

                <Route
                  path='/perfil'
                  element={
                    <PrivateRoute>
                      <PerfilPage />
                    </PrivateRoute>
                  }
                />
                <Route path='/login' element={<Navigate to='/' />} />
              </Routes>
            </main>
          </div>
        </div>
      ) : (
        <Routes>
          <Route path='/login' element={<LoginPage />} />
          <Route path='*' element={<Navigate to='/login' />} />
        </Routes>
      )}
    </Suspense>
  )
}
