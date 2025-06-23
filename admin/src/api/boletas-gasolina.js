import dayjs from 'dayjs'
import { formatearMonedaMXN } from '../utils/formattedCurrancy'
import { apiClient } from './configAxios'

// Crear un registro
export const createBoletaGasolina = async (data) => {
  try {
    const response = await apiClient.post('boletas-gasolina', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getBoletaGasolina = async () => {
  try {
    const response = await apiClient.get('boletas-gasolina')
    const { data } = response

    return data.map((boleta) => ({
      ...boleta,
      vehiculo_id: {
        label: `${boleta.vehiculo.tipo_vehiculo} (${boleta.vehiculo.placas})`,
        value: boleta.vehiculo.id
      },
      vehiculo_tipo: `${boleta.vehiculo.tipo_vehiculo} (${boleta.vehiculo.placas})`,
      costo_litro_format: `${formatearMonedaMXN(boleta.costo_litro)}`,
      costo_total_format: `${formatearMonedaMXN(boleta.costo_total)}`,
      fecha: dayjs(boleta.created_at).format('DD/MM/YYYY'),
      banco_id: {
        label: boleta.banco.nombre,
        value: boleta.banco.id
      },
      banco: boleta.banco.nombre
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateBoletaGasolina = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`boletas-gasolina/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeBoletaGasolina = async (id) => {
  try {
    const response = await apiClient.delete(`boletas-gasolina/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
