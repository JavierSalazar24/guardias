import { apiClient } from './configAxios'

// Crear un registro
export const createSucursalEmpresa = async (data) => {
  try {
    const response = await apiClient.post('sucursales-empresa', data)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getSucursalEmpresa = async () => {
  try {
    const response = await apiClient.get('sucursales-empresa')
    const { data } = response

    return data.map((sucursal) => {
      const direccion = `${sucursal.calle} #${sucursal.numero}, ${sucursal.colonia} C.P. ${sucursal.cp}, ${sucursal.municipio}, ${sucursal.estado}, ${sucursal.pais}.`
      return { ...sucursal, direccion }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getSucursalEmpresaById = async (id) => {
  try {
    const response = await apiClient.get('sucursales-empresa/' + id)
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateSucursalEmpresa = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`sucursales-empresa/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeSucursalEmpresa = async (id) => {
  try {
    const response = await apiClient.delete(`sucursales-empresa/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
