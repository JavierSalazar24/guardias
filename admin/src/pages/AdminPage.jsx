import { AdminCards } from '../components/AdminCards'
import { InventarioPanel } from '../components/dashboard/InventarioPanel'
import { CarteraVencidaTable } from '../components/dashboard/CarteraVencidaTable'
import { GuardiasChart } from '../components/dashboard/GuardiasChart'
import AccionesRapidas from '../components/dashboard/AccionesRapidas'
import { IngresosVsEgresos } from '../components/dashboard/IngresosVsEgresos'
import { SucursalesChart } from '../components/dashboard/SucursalesChart'
import { useAuth } from '../context/AuthContext'
import { useDashboard } from '../hooks/useDashboard'
import Loading from '../components/Loading'
import { OrdenesServicioTable } from '../components/dashboard/OrdenesServicioTable'

const AdminPage = () => {
  const { user } = useAuth()
  const { data, isLoading, isError } = useDashboard()

  if (isLoading) return <Loading />
  if (isError)
    return (
      <div className='text-red-600 font-bold text-center text-lg'>
        Ah ocurrido un error, comunicate con sistemas.
      </div>
    )

  return (
    <>
      <div className='flex flex-wrap items-center justify-between mb-6 bg-white py-4 px-5 rounded-lg shadow-lg'>
        <div>
          <h1 className='text-2xl font-bold text-foreground'>
            Panel de Control
          </h1>
          <p className='text-muted-foreground text-sm'>
            Bienvenido de vuelta, {user.nombre_completo}.
          </p>
        </div>
        <div className='mt-4 sm:mt-0 flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 shadow-md'>
          <div className='h-2 w-2 animate-pulse rounded-full bg-success' />
          <span className='text-sm text-muted-foreground'>
            Sistema operando correctamente
          </span>
        </div>
      </div>

      <AdminCards />

      <AccionesRapidas />

      <div className='grid gap-4 grid-cols-1 md:grid-cols-2 mt-6'>
        <IngresosVsEgresos ingresosEgresos={data.ingresosEgresos} />
        <SucursalesChart sucursalesVentas={data.sucursalesVentas} />
      </div>

      <div className='grid gap-6 grid-cols-1 mt-6'>
        <OrdenesServicioTable ordenesServicio={data.ordenesServicio} />
        <CarteraVencidaTable
          carteraVencida={data.carteraVencida.data}
          total={data.carteraVencida.total}
        />
      </div>

      <div className='grid gap-4 grid-cols-1 md:grid-cols-2 mt-6'>
        <GuardiasChart guardiasData={data.guardiasData} />
        <InventarioPanel inventarioAlerta={data.inventarioAlerta} />
      </div>
    </>
  )
}
export default AdminPage
