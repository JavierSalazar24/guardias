import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createVehiculo = async (data) => {
  try {
    const formData = new FormData()
    formData.append('tipo_vehiculo', data.tipo_vehiculo)
    formData.append('marca', data.marca)
    formData.append('modelo', data.modelo)
    formData.append('color', data.color)
    formData.append('placas', data.placas)

    formData.append('rotulado', data.rotulado)
    formData.append('gps', data.gps)
    formData.append('torreta', data.torreta)
    formData.append('impuestos_pagados', data.impuestos_pagados)

    formData.append('aseguradora', data.aseguradora)
    formData.append('telefono_aseguradora', data.telefono_aseguradora)
    formData.append('archivo_seguro', data.archivo_seguro)
    formData.append('numero_poliza', data.numero_poliza)
    formData.append('fecha_vencimiento', data.fecha_vencimiento)

    for (const file of data.fotos_vehiculo) {
      formData.append('fotos_vehiculo[]', file)
    }

    const response = await apiClientForm.post('vehiculos', formData)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getVehiculo = async () => {
  try {
    const response = await apiClient.get('vehiculos')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getVehiculosDisponibles = async () => {
  try {
    const response = await apiClient.get('vehiculos-disponibles')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateVehiculo = async (data) => {
  try {
    const { id } = data

    const formData = new FormData()
    formData.append('_method', 'PUT')

    formData.append('tipo_vehiculo', data.tipo_vehiculo)
    formData.append('marca', data.marca)
    formData.append('modelo', data.modelo)
    formData.append('color', data.color)
    formData.append('placas', data.placas)
    formData.append('estado', data.estado)

    formData.append('rotulado', data.rotulado)
    formData.append('gps', data.gps)
    formData.append('torreta', data.torreta)
    formData.append('impuestos_pagados', data.impuestos_pagados)

    formData.append('aseguradora', data.aseguradora)
    formData.append('telefono_aseguradora', data.telefono_aseguradora)
    formData.append('numero_poliza', data.numero_poliza)
    formData.append('fecha_vencimiento', data.fecha_vencimiento)

    if (data.archivo_seguro instanceof File) {
      formData.append('archivo_seguro', data.archivo_seguro)
    }

    if (
      Array.isArray(data.fotos_vehiculo) &&
      data.fotos_vehiculo.every((item) => item instanceof File)
    ) {
      for (const file of data.fotos_vehiculo) {
        formData.append('fotos_vehiculo[]', file)
      }
    }

    const response = await apiClientForm.post(`vehiculos/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeVehiculo = async (id) => {
  try {
    const response = await apiClient.delete(`vehiculos/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
