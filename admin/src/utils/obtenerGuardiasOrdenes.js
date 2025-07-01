import { getJefeBySucursal, getSupervisorBySucursal } from '../api/guardias'
import { getVentaById } from '../api/ventas'

export const obetenerGuardiasOrdenes = async ({
  id,
  setSelectSupervisorBySucursal,
  setSelectJefeBySucursal,
  setSucursalGuardiasId,
  setReloadGuardias
}) => {
  const ventas = await getVentaById(id)

  const sucursal_id = ventas.cotizacion.sucursal_empresa.id

  const supervisores = await getSupervisorBySucursal(sucursal_id)

  supervisores.unshift({ label: 'Selecciona una opción', value: '' })
  setSelectSupervisorBySucursal(supervisores)

  const jefes = await getJefeBySucursal(sucursal_id)
  jefes.unshift({ label: 'Selecciona una opción', value: '' })
  setSelectJefeBySucursal(jefes)

  setSucursalGuardiasId(sucursal_id)
  setReloadGuardias((prev) => prev + 1)
}
