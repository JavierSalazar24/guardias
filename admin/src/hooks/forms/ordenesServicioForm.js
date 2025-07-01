import { obetenerGuardiasOrdenes } from '../../utils/obtenerGuardiasOrdenes'

export const ordenesServicioForm = async ({
  name,
  setSelectSupervisorBySucursal,
  setFormData,
  setSelectJefeBySucursal,
  value,
  setSucursalGuardiasId,
  setReloadGuardias
}) => {
  if (name === 'venta_id') {
    setFormData('domicilio_servicio', value.direccion)
    setFormData('supervisor', value.supervisor)
    setFormData('jefe_turno', value.jefe_turno)
    setFormData('fecha_inicio', `${value.fecha_servicio}T00:00:00`)

    const id = value.value
    await obetenerGuardiasOrdenes({
      id,
      setSelectSupervisorBySucursal,
      setSelectJefeBySucursal,
      setSucursalGuardiasId,
      setReloadGuardias
    })
  }
}
