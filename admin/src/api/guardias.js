import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createGuardia = async (data) => {
  try {
    const formData = new FormData()
    formData.append('foto', data.foto)
    formData.append('nombre', data.nombre)
    formData.append('apellido_p', data.apellido_p)
    formData.append('apellido_m', data.apellido_m)
    formData.append('fecha_nacimiento', data.fecha_nacimiento)
    formData.append('telefono', data.telefono)
    formData.append('correo', data.correo)
    formData.append('enfermedades', data.enfermedades)
    formData.append('alergias', data.alergias)
    formData.append('curp', data.curp)
    formData.append('clave_elector', data.clave_elector)
    formData.append('calle', data.calle)
    formData.append('numero', data.numero)
    formData.append('entre_calles', data.entre_calles)
    formData.append('colonia', data.colonia)
    formData.append('cp', data.cp)
    formData.append('estado', data.estado)
    formData.append('municipio', data.municipio)
    formData.append('pais', data.pais)
    formData.append('contacto_emergencia', data.contacto_emergencia)
    formData.append('telefono_emergencia', data.telefono_emergencia)
    formData.append('sucursal_empresa_id', data.sucursal_empresa_id)
    formData.append('numero_empleado', data.numero_empleado)
    formData.append('cargo', data.cargo)
    formData.append('cuip', data?.cuip || '')
    formData.append('numero_cuenta', data.numero_cuenta)
    formData.append('clabe', data.clabe)
    formData.append('banco', data.banco)
    formData.append('nombre_propietario', data.nombre_propietario)
    formData.append('comentarios_generales', data?.comentarios_generales || '')
    formData.append('sueldo_base', data.sueldo_base)
    formData.append('dias_laborales', data.dias_laborales)
    formData.append('aguinaldo', data.aguinaldo)
    formData.append('imss', data.imss)
    formData.append('infonavit', data.infonavit)
    formData.append('fonacot', data.fonacot)
    formData.append('retencion_isr', data.retencion_isr)
    formData.append('fecha_alta', data.fecha_alta)
    formData.append('rango_id', data.rango_id)
    formData.append('fecha_baja', data?.fecha_baja || '')
    formData.append('motivo_baja', data?.motivo_baja || '')
    formData.append('sucursal_id', data?.sucursal_id || '')

    if (data?.fecha_antidoping) {
      formData.append('fecha_antidoping', data.fecha_antidoping)
    }
    if (data?.antidoping) {
      formData.append('antidoping', data.antidoping)
    }

    const response = await apiClientForm.post('guardias', formData)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getGuardias = async () => {
  try {
    const response = await apiClient.get('guardias')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((guardia) => ({
          ...guardia,
          nombre_completo: `${guardia.nombre} ${guardia.apellido_p} ${guardia.apellido_m}`,
          nombre_sucursal: guardia.sucursal_empresa.nombre_sucursal,
          sucursal_empresa_id: {
            label: guardia.sucursal_empresa.nombre_sucursal,
            value: guardia.sucursal_empresa.id
          },
          rango_nombre: guardia.rango.nombre,
          rango_id: {
            label: guardia.rango.nombre,
            value: guardia.rango.id
          },
          sucursal_id: {
            label: guardia?.sucursal?.nombre_empresa || null,
            value: guardia?.sucursal?.id || null
          },
          sucursal_cliente: guardia?.sucursal?.nombre_empresa || 'N/A'
        }))
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getGuardiasTotales = async () => {
  try {
    const response = await apiClient.get('guardias-totales')
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getGuardiasBySucursal = async (id) => {
  try {
    const response = await apiClient.get('guardias-sucursal?id=' + id)
    const { data } = response

    return data.map((guardia) => ({
      ...guardia,
      id: guardia.id,
      nombre_completo: `${guardia.nombre} ${guardia.apellido_p} ${guardia.apellido_m}`
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getGuardiaById = async (id) => {
  try {
    const response = await apiClient.get('guardias/' + id)
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateGuardia = async (data) => {
  try {
    const { id } = data

    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('nombre', data.nombre)
    formData.append('apellido_p', data.apellido_p)
    formData.append('apellido_m', data.apellido_m)
    formData.append('fecha_nacimiento', data.fecha_nacimiento)
    formData.append('telefono', data.telefono)
    formData.append('correo', data.correo)
    formData.append('enfermedades', data.enfermedades)
    formData.append('alergias', data.alergias)
    formData.append('curp', data.curp)
    formData.append('clave_elector', data.clave_elector)
    formData.append('calle', data.calle)
    formData.append('numero', data.numero)
    formData.append('entre_calles', data.entre_calles)
    formData.append('colonia', data.colonia)
    formData.append('cp', data.cp)
    formData.append('estado', data.estado)
    formData.append('municipio', data.municipio)
    formData.append('pais', data.pais)
    formData.append('contacto_emergencia', data.contacto_emergencia)
    formData.append('telefono_emergencia', data.telefono_emergencia)
    formData.append('sucursal_empresa_id', data.sucursal_empresa_id)
    formData.append('numero_empleado', data.numero_empleado)
    formData.append('cargo', data.cargo)
    formData.append('cuip', data?.cuip || '')
    formData.append('numero_cuenta', data.numero_cuenta)
    formData.append('clabe', data.clabe)
    formData.append('banco', data.banco)
    formData.append('nombre_propietario', data.nombre_propietario)
    formData.append('comentarios_generales', data?.comentarios_generales || '')
    formData.append('sueldo_base', data.sueldo_base)
    formData.append('dias_laborales', data.dias_laborales)
    formData.append('aguinaldo', data.aguinaldo)
    formData.append('imss', data.imss)
    formData.append('infonavit', data.infonavit)
    formData.append('fonacot', data.fonacot)
    formData.append('retencion_isr', data.retencion_isr)
    formData.append('fecha_alta', data.fecha_alta)
    formData.append('estatus', data.estatus)
    formData.append('rango_id', data.rango_id)
    formData.append('fecha_baja', data?.fecha_baja || '')
    formData.append('motivo_baja', data?.motivo_baja || '')
    formData.append('sucursal_id', data?.sucursal_id || '')

    if (data.foto instanceof File) {
      formData.append('foto', data.foto)
    }
    if (data?.fecha_antidoping) {
      formData.append('fecha_antidoping', data.fecha_antidoping)
    }
    if (data.antidoping instanceof File) {
      formData.append('antidoping', data.antidoping)
    }

    const response = await apiClientForm.post(`guardias/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeGuardia = async (id) => {
  try {
    const response = await apiClient.delete(`guardias/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}

export const blackList = async (data) => {
  try {
    const response = await apiClient.post('blacklist', data)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}

export const checkBlackList = async (data) => {
  try {
    const response = await apiClient.post('check-blacklist', data)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
