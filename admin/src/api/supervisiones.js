import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createSupervision = async (data) => {
  try {
    const formData = new FormData()
    formData.append('asistencia', data.asistencia)
    formData.append('falta', data?.falta || '')
    formData.append('uniforme', data.uniforme)
    formData.append('uniforme_incompleto', data?.uniforme_incompleto || '')
    formData.append('equipamiento', data.equipamiento)
    formData.append(
      'equipamiento_incompleto',
      data?.equipamiento_incompleto || ''
    )
    formData.append('lugar_trabajo', data.lugar_trabajo)
    formData.append('motivo_ausente', data?.motivo_ausente || '')
    formData.append(
      'comentarios_adicionales',
      data?.comentarios_adicionales || ''
    )
    formData.append('guardia_id', data.guardia_id)

    if (data?.evidencia) {
      formData.append('evidencia', data.evidencia)
    }

    const response = await apiClientForm.post('supervisiones', formData)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getSupervision = async () => {
  try {
    const response = await apiClient.get('supervisiones')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((supervision) => ({
          ...supervision,
          supervisor_nombre: supervision.usuario.nombre_completo,
          guardia_nombre: `${supervision.guardia.nombre} ${supervision.guardia.apellido_p} ${supervision.guardia.apellido_m}`,
          guardia_id: {
            value: supervision.guardia.id,
            label: `${supervision.guardia.nombre} ${supervision.guardia.apellido_p} ${supervision.guardia.apellido_m}`
          },
          nombre_sucursal: supervision.guardia.sucursal_empresa.nombre_sucursal,
          sucursal_cliente:
            supervision?.guardia?.sucursal?.nombre_empresa || 'N/A'
        }))
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateSupervision = async (data) => {
  try {
    const { id } = data

    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('asistencia', data.asistencia)
    formData.append('uniforme', data.uniforme)
    formData.append('botas', data.botas)
    formData.append('pantalon', data.pantalon)
    formData.append('playera', data.playera)
    formData.append('pr24', data.pr24)
    formData.append('gas', data.gas)
    formData.append('gorra', data.gorra)
    formData.append('gafete', data.gafete)
    formData.append('lugar_trabajo', data.lugar_trabajo)
    formData.append(
      'comentarios_adicionales',
      data?.comentarios_adicionales || ''
    )
    formData.append('guardia_id', data.guardia_id)

    if (data.evidencia instanceof File) {
      formData.append('evidencia', data.evidencia)
    }

    const response = await apiClientForm.post(`supervisiones/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeSupervision = async (id) => {
  try {
    const response = await apiClient.delete(`supervisiones/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
