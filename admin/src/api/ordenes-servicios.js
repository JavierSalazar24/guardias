import dayjs from 'dayjs'
import { apiClient } from './configAxios'

const transformEquipamientoData = (data) => {
  const transformed = {
    venta_id: data.venta_id,
    domicilio_servicio: data.domicilio_servicio,
    codigo_orden_servicio: data.codigo_orden_servicio,
    nombre_responsable_sitio: data.nombre_responsable_sitio,
    telefono_responsable_sitio: data.telefono_responsable_sitio,
    fecha_inicio: data.fecha_inicio,
    fecha_fin: data.fecha_fin,
    observaciones: data.observaciones || '',
    guardias_id: data.guardias_id,
    estatus: data.estatus || '',
    seleccionados: []
  }

  // Procesar artículos y seleccionados juntos
  Object.entries(data).forEach(([key, value]) => {
    if (key.startsWith('articulo-')) {
      const [_, nombre, id] = key.split('-')
      const nombreLower = nombre.toLowerCase()

      // Solo agregar al objeto si está activo (true)
      if (value === true) {
        transformed[nombreLower] = true

        // Buscar el número de serie correspondiente si existe
        const serieKey = `seleccionado-numero_serie-${id}`
        const numeroSerie = data[serieKey]

        if (numeroSerie && numeroSerie.trim() !== '') {
          transformed.seleccionados.push({
            numero_serie: numeroSerie,
            id: parseInt(id) || 0
          })
        }
      }
    }
  })

  return transformed
}

// Crear un registro
export const createOrdenServicio = async (data) => {
  try {
    const transformedData = transformEquipamientoData(data)
    const response = await apiClient.post('orden-servicio', transformedData)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getOrdenServicio = async () => {
  try {
    const response = await apiClient.get('orden-servicio')
    const { data } = response

    return data.map((orden) => {
      const guardias_id = orden.ordenes_servicio_guardias.map((g) => ({
        value: g.guardia.id,
        label: `${g.guardia.nombre} ${g.guardia.apellido_p} ${g.guardia.apellido_m} (${g.guardia.numero_empleado} - ${g.guardia.rango.nombre})`
      }))

      const nombre_empresa = orden.venta.cotizacion.sucursal.nombre_empresa

      const venta_id = {
        label: `${nombre_empresa} (${orden.venta.numero_factura})`,
        value: orden.venta.id
      }

      const asignados = orden.ordenes_servicio_guardias
        .map(
          (g) =>
            `${g.guardia.nombre} ${g.guardia.apellido_p} (${g.guardia.rango.nombre})`
        )
        .join(', ')

      return {
        ...orden,
        venta_id,
        guardias_id,
        nombre_empresa,
        asignados,
        inicio_format: dayjs(orden.fecha_inicio).format('DD/MM/YYYY'),
        fin_format: orden.fecha_fin
          ? dayjs(orden.fecha_fin).format('DD/MM/YYYY')
          : 'N/A'
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(
      error.response?.data?.message || 'Error al obtener los datos'
    )
  }
}

// Leer registros
export const getOrdenServicioEliminadas = async () => {
  try {
    const response = await apiClient.get('orden-servicio-eliminadas')
    const { data } = response

    return data.map((orden) => {
      const guardias_id = orden.ordenes_servicio_guardias.map((g) => ({
        value: g.guardia.id,
        label: `${g.guardia.nombre} ${g.guardia.apellido_p} ${g.guardia.apellido_m} (${g.guardia.numero_empleado} - ${g.guardia.rango.nombre})`
      }))

      const nombre_empresa = orden.venta.cotizacion.sucursal.nombre_empresa

      const venta_id = {
        label: `${nombre_empresa} (${orden.venta.numero_factura})`,
        value: orden.venta.id
      }

      const asignados = orden.ordenes_servicio_guardias
        .map(
          (g) =>
            `${g.guardia.nombre} ${g.guardia.apellido_p} (${g.guardia.rango.nombre})`
        )
        .join(', ')

      return {
        ...orden,
        venta_id,
        guardias_id,
        nombre_empresa,
        asignados,
        inicio_format: dayjs(orden.fecha_inicio).format('DD/MM/YYYY'),
        fin_format: orden.fecha_fin
          ? dayjs(orden.fecha_fin).format('DD/MM/YYYY')
          : 'N/A'
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(
      error.response?.data?.message || 'Error al obtener los datos'
    )
  }
}

// Actualizar un registro
export const updateOrdenServicio = async (data) => {
  try {
    const { id } = data

    const transformedData = transformEquipamientoData(data)
    const response = await apiClient.put(
      `orden-servicio/${id}`,
      transformedData
    )
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeOrdenServicio = async (id) => {
  try {
    const response = await apiClient.delete(`orden-servicio/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
