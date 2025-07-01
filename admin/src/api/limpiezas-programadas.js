import { getLabelByValue } from '../utils/obtenerTablaEstilizada'
import { apiClient } from './configAxios'

// Crear un registro
export const createLimpiezaProgramada = async (data) => {
  try {
    const response = await apiClient.post('limpiezas-programadas', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getLimpiezaProgramada = async () => {
  try {
    const response = await apiClient.get('limpiezas-programadas')
    console.log(response)

    const { data } = response

    return data.map((limpieza) => ({
      ...limpieza,
      usuario: limpieza.usuario.nombre_completo,
      periodo_completo: `${limpieza.periodo_cantidad} ${limpieza.periodo_tipo}`,
      estatus: limpieza.activa ? 'Activado' : 'Desactivado',
      activa: limpieza.activa ? 'true' : 'false',
      tabla_format: getLabelByValue(limpieza.tabla)
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateLimpiezaProgramada = async (data) => {
  try {
    const { id } = data

    data.activa = data.activa === 'true' ? 1 : 0

    const response = await apiClient.put(`limpiezas-programadas/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeLimpiezaProgramada = async (id) => {
  try {
    const response = await apiClient.delete(`limpiezas-programadas/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
