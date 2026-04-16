import { obetenerGuardiasOrdenes } from '../../utils/obtenerGuardiasOrdenes'

export const ordenesServicioForm = async ({
  name,
  setFormData,
  value,
  setSucursalGuardiasId,
  setReloadGuardias
}) => {
  if (name === 'venta_id') {
    setFormData('domicilio_servicio', value.direccion)
    setFormData('fecha_inicio', `${value.fecha_servicio}T00:00:00`)
    setFormData('nombre_responsable_sitio', value.nombre_contacto)
    setFormData('telefono_responsable_sitio', value.telefono_contacto)

    const id = value.value
    await obetenerGuardiasOrdenes({
      id,
      setSucursalGuardiasId,
      setReloadGuardias
    })
  }
}
