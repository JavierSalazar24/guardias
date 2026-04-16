import dayjs from 'dayjs'
import { apiClient } from './configAxios'
import { formatearMonedaMXN } from '../utils/formattedCurrancy'

// Crear un registro
export const createMantenimiento = async (data) => {
  try {
    const response = await apiClient.post('mantenimientos', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getMantenimiento = async () => {
  try {
    const response = await apiClient.get('mantenimientos')
    const { data } = response

    return data.map((mantenimeinto) => ({
      ...mantenimeinto,
      taller_nombre: mantenimeinto.taller.nombre,
      taller_id: {
        label: mantenimeinto.taller.nombre,
        value: mantenimeinto.taller.id
      },
      vehiculo_nombre: `${mantenimeinto.vehiculo.tipo_vehiculo} (${mantenimeinto.vehiculo.placas})`,
      vehiculo_id: {
        label: `${mantenimeinto.vehiculo.tipo_vehiculo} - ${mantenimeinto.vehiculo.marca} ${mantenimeinto.vehiculo.modelo} (${mantenimeinto.vehiculo.placas})`,
        value: mantenimeinto.vehiculo.id
      },
      fecha_ingreso_format: dayjs(mantenimeinto.fecha_ingreso).format(
        'DD/MM/YYYY'
      ),
      fecha_salida_format: mantenimeinto.fecha_salida
        ? dayjs(mantenimeinto.fecha_salida).format('DD/MM/YYYY')
        : 'N/A',
      costo_format: formatearMonedaMXN(mantenimeinto.costo_final)
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateMantenimiento = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`mantenimientos/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeMantenimiento = async (id) => {
  try {
    const response = await apiClient.delete(`mantenimientos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
