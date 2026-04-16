import { getVentaById } from '../api/ventas'

export const obetenerGuardiasOrdenes = async ({
  id,
  setSucursalGuardiasId,
  setReloadGuardias
}) => {
  const ventas = await getVentaById(id)

  const sucursal_id = ventas.cotizacion.sucursal_empresa.id

  setSucursalGuardiasId(sucursal_id)
  setReloadGuardias((prev) => prev + 1)
}
