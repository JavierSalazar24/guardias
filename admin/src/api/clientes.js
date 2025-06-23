import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createCliente = async (data) => {
  try {
    const formData = new FormData()
    formData.append('nombre_empresa', data.nombre_empresa)
    formData.append('calle', data.calle)
    formData.append('numero', data.numero)
    formData.append('colonia', data.colonia)
    formData.append('cp', data.cp)
    formData.append('municipio', data.municipio)
    formData.append('estado', data.estado)
    formData.append('pais', data.pais)
    formData.append('telefono_empresa', data.telefono_empresa)

    formData.append('nombre_contacto_admin', data.nombre_contacto_admin)
    formData.append('telefono_contacto_admin', data.telefono_contacto_admin)
    formData.append('whatsapp_contacto_admin', data.whatsapp_contacto_admin)
    formData.append('correo_contacto_admin', data.correo_contacto_admin)

    formData.append('nombre_contacto_opera', data.nombre_contacto_opera)
    formData.append('telefono_contacto_opera', data.telefono_contacto_opera)
    formData.append('whatsapp_contacto_opera', data.whatsapp_contacto_opera)
    formData.append('correo_contacto_opera', data.correo_contacto_opera)

    formData.append('credito_dias', data.credito_dias)
    formData.append('metodo_pago', data.metodo_pago)
    formData.append('orden_compra', data.orden_compra)

    formData.append('rfc', data.rfc)
    formData.append('razon_social', data.razon_social)
    formData.append('uso_cfdi', data.uso_cfdi)
    formData.append('regimen_fiscal', data.regimen_fiscal)
    formData.append('situacion_fiscal', data.situacion_fiscal)

    if (data?.extension_empresa) {
      formData.append('extension_empresa', data.extension_empresa)
    }
    if (data?.pagina_web) {
      formData.append('pagina_web', data.pagina_web)
    }
    if (data?.plataforma_facturas) {
      formData.append('plataforma_facturas', data.plataforma_facturas)
    }

    const response = await apiClientForm.post('clientes', formData)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getCliente = async () => {
  try {
    const response = await apiClient.get('clientes')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateCliente = async (data) => {
  try {
    const { id } = data

    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('nombre_empresa', data.nombre_empresa)
    formData.append('calle', data.calle)
    formData.append('numero', data.numero)
    formData.append('colonia', data.colonia)
    formData.append('cp', data.cp)
    formData.append('municipio', data.municipio)
    formData.append('estado', data.estado)
    formData.append('pais', data.pais)
    formData.append('telefono_empresa', data.telefono_empresa)

    formData.append('nombre_contacto_admin', data.nombre_contacto_admin)
    formData.append('telefono_contacto_admin', data.telefono_contacto_admin)
    formData.append('whatsapp_contacto_admin', data.whatsapp_contacto_admin)
    formData.append('correo_contacto_admin', data.correo_contacto_admin)

    formData.append('nombre_contacto_opera', data.nombre_contacto_opera)
    formData.append('telefono_contacto_opera', data.telefono_contacto_opera)
    formData.append('whatsapp_contacto_opera', data.whatsapp_contacto_opera)
    formData.append('correo_contacto_opera', data.correo_contacto_opera)

    formData.append('credito_dias', data.credito_dias)
    formData.append('metodo_pago', data.metodo_pago)
    formData.append('orden_compra', data.orden_compra)

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
    if (data?.pagina_web) {
      formData.append('pagina_web', data.pagina_web)
    }
    if (data?.plataforma_facturas) {
      formData.append('plataforma_facturas', data.plataforma_facturas)
    }

    const response = await apiClientForm.post(`clientes/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeCliente = async (id) => {
  try {
    const response = await apiClient.delete(`clientes/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
