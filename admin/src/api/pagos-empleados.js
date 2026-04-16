import dayjs from 'dayjs'
import { apiClient } from './configAxios'
import { formatearMonedaMXN } from '../utils/formattedCurrancy'

// Crear un registro
export const createPagoEmpleado = async (data) => {
  try {
    const response = await apiClient.post('pagos-empleados', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getPagoEmpleado = async () => {
  try {
    const response = await apiClient.get('pagos-empleados')
    const { data } = response
    return data.map((pago) => ({
      ...pago,
      nombre: `${pago.guardia.nombre} ${pago.guardia.apellido_p} (${pago.guardia.numero_empleado})`,
      fecha_inicio: dayjs(pago.periodo_inicio).format('DD/MM/YYYY'),
      fecha_fin: dayjs(pago.periodo_fin).format('DD/MM/YYYY'),
      sueldo: formatearMonedaMXN(pago.sueldo_base),
      ingresos: formatearMonedaMXN(pago.total_ingresos),
      egresos: formatearMonedaMXN(pago.total_egresos),
      retenciones: formatearMonedaMXN(pago.total_retenciones),
      bruto: formatearMonedaMXN(pago.pago_bruto),
      total: formatearMonedaMXN(pago.pago_final),
      guardia_id: {
        value: pago.guardia.id,
        label: `${pago.guardia.nombre} ${pago.guardia.apellido_p} ${pago.guardia.apellido_m}`
      },
      banco_id: {
        label: pago.banco.nombre,
        value: pago.banco.id
      }
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updatePagoEmpleado = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`pagos-empleados/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removePagoEmpleado = async (id) => {
  try {
    const response = await apiClient.delete(`pagos-empleados/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
