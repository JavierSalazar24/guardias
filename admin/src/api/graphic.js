import { apiClient } from './configAxios'

// Leer registros
export const getIngresosMensuales = async () => {
  try {
    const response = await apiClient.get('ventas-ingresos-mensuales')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getEgresosMensuales = async () => {
  try {
    const response = await apiClient.get('ventas-egresos-mensuales')
    return response.data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}
