import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createSucursal = async (data) => {
  try {
    const formData = new FormData()
    formData.append('cliente_id', data.cliente_id)
    formData.append('nombre_empresa', data.nombre_empresa)
    formData.append('calle', data.calle)
    formData.append('numero', data.numero)
    formData.append('colonia', data.colonia)
    formData.append('cp', data.cp)
    formData.append('municipio', data.municipio)
    formData.append('estado', data.estado)
    formData.append('pais', data.pais)
    formData.append('telefono_empresa', data.telefono_empresa)

    formData.append('nombre_contacto', data.nombre_contacto)
    formData.append('telefono_contacto', data.telefono_contacto)
    formData.append('whatsapp_contacto', data.whatsapp_contacto)
    formData.append('correo_contacto', data.correo_contacto)

    formData.append('rfc', data.rfc)
    formData.append('razon_social', data.razon_social)
    formData.append('uso_cfdi', data.uso_cfdi)
    formData.append('regimen_fiscal', data.regimen_fiscal)
    formData.append('situacion_fiscal', data.situacion_fiscal)

    if (data?.extension_empresa) {
      formData.append('extension_empresa', data.extension_empresa)
    }

    const response = await apiClientForm.post('sucursales', formData)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getSucursal = async () => {
  try {
    const response = await apiClient.get('sucursales')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((sucursal) => ({
          ...sucursal,
          cliente_id: {
            label: sucursal.cliente.nombre_empresa,
            value: sucursal.cliente.id
          },
          empresa: sucursal.cliente.nombre_empresa
        }))
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getSucursalByCliente = async (id) => {
  try {
    const response = await apiClient.get('sucursales-cliente', {
      params: { cliente_id: id }
    })
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((sucursal) => ({
          ...sucursal,
          sucursal_id: {
            label: sucursal.cliente.nombre_empresa,
            value: sucursal.cliente.id
          }
        }))
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateSucursal = async (data) => {
  try {
    const { id } = data

    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('cliente_id', data.cliente_id)
    formData.append('nombre_empresa', data.nombre_empresa)
    formData.append('calle', data.calle)
    formData.append('numero', data.numero)
    formData.append('colonia', data.colonia)
    formData.append('cp', data.cp)
    formData.append('municipio', data.municipio)
    formData.append('estado', data.estado)
    formData.append('pais', data.pais)
    formData.append('telefono_empresa', data.telefono_empresa)

    formData.append('nombre_contacto', data.nombre_contacto)
    formData.append('telefono_contacto', data.telefono_contacto)
    formData.append('whatsapp_contacto', data.whatsapp_contacto)
    formData.append('correo_contacto', data.correo_contacto)

    formData.append('rfc', data.rfc)
    formData.append('razon_social', data.razon_social)
    formData.append('uso_cfdi', data.uso_cfdi)
    formData.append('regimen_fiscal', data.regimen_fiscal)

    if (data.situacion_fiscal instanceof File) {
      formData.append('situacion_fiscal', data.situacion_fiscal)
    }

    if (data?.extension_empresa) {
      formData.append('extension_empresa', data.extension_empresa)
    }

    const response = await apiClientForm.post(`sucursales/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeSucursal = async (id) => {
  try {
    const response = await apiClient.delete(`sucursales/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
