import { getSucursalByCliente } from '../../api/sucursales'
import { toFloat, toInt } from '../../utils/numbers'

export const cotizacionesForm = async ({
  name,
  recalcularTotales,
  setFormData,
  calcularGuardiasTotal,
  value,
  formData,
  actualizarTotal,
  setSelectOptions
}) => {
  if (name === 'cliente_id') {
    try {
      const response = await getSucursalByCliente(value.value)
      const data = response.map((sucursal) => ({
        value: sucursal.id,
        label: sucursal.nombre_empresa
      }))

      const options = [{ label: 'Selecciona una opción', value: '' }, ...data]

      setSelectOptions(options)
      setFormData('credito_dias', value.credito_dias)
    } catch (error) {
      console.error('Error al obtener sucursales:', error)
      setSelectOptions([])
    }
  }

  if (name === 'tipo_servicio_id') {
    const costoTotal = value.reduce((a, b) => a + b.costo, 0)
    setFormData('precio_total_servicios', costoTotal)

    recalcularTotales({
      precioTotalServicios: costoTotal
    })
  }

  if (['guardias_dia', 'guardias_noche'].includes(name)) {
    const dia =
      name === 'guardias_dia' ? toInt(value) : toInt(formData.guardias_dia) || 0
    const noche =
      name === 'guardias_noche'
        ? toInt(value)
        : toInt(formData.guardias_noche) || 0

    setFormData('cantidad_guardias', calcularGuardiasTotal(dia, noche))

    recalcularTotales({
      guardiasDia: dia,
      guardiasNoche: noche
    })
  }

  if (['precio_guardias_dia', 'precio_guardias_noche'].includes(name)) {
    const precioDia =
      name === 'precio_guardias_dia'
        ? toFloat(value)
        : toFloat(formData.precio_guardias_dia) || 0
    const precioNoche =
      name === 'precio_guardias_noche'
        ? toFloat(value)
        : toFloat(formData.precio_guardias_noche) || 0

    recalcularTotales({
      precioDia,
      precioNoche
    })
  }

  if (
    [
      'precio_jefe_turno',
      'precio_supervisor',
      'descuento_porcentaje',
      'costo_extra'
    ].includes(name)
  ) {
    const precioJefe =
      name === 'precio_jefe_turno'
        ? toFloat(value)
        : toFloat(formData.precio_jefe_turno) || 0
    const precioSupervisor =
      name === 'precio_supervisor'
        ? toFloat(value)
        : toFloat(formData.precio_supervisor) || 0

    const descuentoPor =
      name === 'descuento_porcentaje'
        ? toFloat(value)
        : toFloat(formData.descuento_porcentaje) || 0
    const costoExtra =
      name === 'costo_extra'
        ? toFloat(value)
        : toFloat(formData.costo_extra) || 0

    recalcularTotales({
      precioJefe,
      precioSupervisor,
      descuentoPor,
      costoExtra
    })
  }

  if (name === 'impuesto') {
    actualizarTotal(
      toFloat(formData.subtotal) || 0,
      toFloat(formData.descuento_porcentaje) || 0,
      toFloat(formData.costo_extra) || 0,
      toFloat(value)
    )
  }

  if (name === 'subtotal') {
    const subtotal = toFloat(value) || 0
    setFormData('subtotal', subtotal)
    actualizarTotal(
      subtotal,
      toFloat(formData.descuento_porcentaje) || 0,
      toFloat(formData.costo_extra) || 0
    )
  }
}
