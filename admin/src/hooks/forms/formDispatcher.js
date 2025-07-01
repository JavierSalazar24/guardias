import { cotizacionesForm } from './cotizacionesForm'
import { ordenCompraForm } from './ordenCompraForm'
import { gastosForm } from './gastosForm'
import { almacenForm } from './almacenForm'
import { ordenesServicioForm } from './ordenesServicioForm'
import { tiempoExtraForm } from './tiempoExtraForm'
import { boletasGasolinaForm } from './boletasGasolinaForm'
import { usuariosForm } from './usuariosForm'
import { pagosEmpleadosForm } from './pagosEmpleadosForm'
import { faltasForm } from './faltasForm'

// Puedes agregar aquí todos tus formularios por módulo
const FORM_HANDLERS = {
  '/cotizaciones': cotizacionesForm,
  '/ordenes-compra': ordenCompraForm,
  '/gastos': gastosForm,
  '/almacen-entradas': almacenForm,
  '/almacen-salidas': almacenForm,
  '/orden-servicio': ordenesServicioForm,
  '/tiempo-extra': tiempoExtraForm,
  '/boletas-gasolina': boletasGasolinaForm,
  '/pagos-empleados': pagosEmpleadosForm,
  '/usuarios': usuariosForm,
  '/faltas': faltasForm
}

export async function dispatchFormLogic(pathname, props) {
  const fn = FORM_HANDLERS[pathname]
  if (fn) return await fn(props)
  return null
}
