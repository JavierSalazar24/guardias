import { apiClient } from './configAxios'

// Crear un registro
export const createBlackList = async (data) => {
  try {
    const response = await apiClient.post('blacklist', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getBlackList = async () => {
  try {
    const response = await apiClient.get('blacklist')
    const { data } = response

    return data.map((balcklist) => ({
      ...balcklist,
      nombre: `${balcklist.guardia.nombre} ${balcklist.guardia.apellido_p} ${balcklist.guardia.apellido_m}`,
      guardia: {
        ...balcklist.guardia,
        sucursal_empresa_id: {
          label: balcklist.guardia.sucursal_empresa.nombre_sucursal,
          value: balcklist.guardia.sucursal_empresa.id
        }
      }
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateBlackList = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`blacklist/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeBlackList = async (id) => {
  try {
    const response = await apiClient.delete(`blacklist/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
