import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createVenta = async (data) => {
  try {
    const response = await apiClient.post('ventas', data)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getVenta = async () => {
  try {
    const response = await apiClient.get('ventas')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((venta) => {
          const nombre_empresa = venta?.cotizacion?.sucursal
            ? venta?.cotizacion?.sucursal?.nombre_empresa
            : venta?.cotizacion?.nombre_empresa

          const cotizacion_aceptada = dayjs(venta.fecha_emision).format(
            'DD/MM/YYYY'
          )

          const fecha_venc = dayjs(venta.fecha_vencimiento).format('DD/MM/YYYY')

          const fecha_limite =
            venta.tipo_pago === 'Contado' ? 'N/A' : fecha_venc

          const fecha_vencimiento =
            venta.tipo_pago === 'Contado' ? null : venta.fecha_vencimiento

          const banco_id = venta?.banco
            ? { label: venta.banco.nombre, value: venta.banco.id }
            : ''

          return {
            ...venta,
            cotizacion_id: {
              label: nombre_empresa,
              value: venta.cotizacion.id
            },
            banco_id,
            sucursal: typeof nombre_empresa === 'string' ? nombre_empresa : '',
            total: `$${venta.total}`,
            cotizacion_aceptada,
            fecha_vencimiento_format: fecha_limite,
            fecha_vencimiento,
            credito_dias: venta.cotizacion.credito_dias
          }
        })
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getVentaById = async (id) => {
  try {
    const response = await apiClient.get('ventas/' + id)
    const { data } = response

    return data
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

export const getVentaOrdenServicio = async () => {
  try {
    const response = await apiClient.get('ventas-orden-servicio')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((venta) => {
          const nombre_empresa = venta?.cotizacion?.sucursal
            ? venta?.cotizacion?.sucursal?.nombre_empresa
            : venta?.cotizacion?.nombre_empresa

          const cotizacion_aceptada = dayjs(
            venta.fecha_emision,
            'YYYY-MM-DD'
          ).format('DD/MM/YYYY')

          const fecha_vencimiento = dayjs(
            venta.fecha_vencimiento,
            'YYYY-MM-DD'
          ).format('DD/MM/YYYY')

          const sucursal = venta?.cotizacion?.sucursal || null

          const direccion = sucursal
            ? `${sucursal.calle} #${sucursal.numero} ${sucursal.colonia}, C.P. ${sucursal.cp}, ${sucursal.municipio}, ${sucursal.estado}, ${sucursal.pais}`
            : `${venta.cotizacion.calle} #${venta.cotizacion.numero} ${venta.cotizacion.colonia}, C.P. ${venta.cotizacion.cp}, ${venta.cotizacion.municipio}, ${venta.cotizacion.estado}, ${venta.cotizacion.pais}`

          return {
            ...venta,
            cotizacion_id: {
              label: nombre_empresa,
              value: venta.cotizacion.id
            },
            sucursal: typeof nombre_empresa === 'string' ? nombre_empresa : '',
            total: `$${venta.total}`,
            cotizacion_aceptada,
            fecha_vencimiento,
            credito_dias: venta.cotizacion.credito_dias,
            nombre_empresa,
            direccion,
            fecha_servicio: venta.cotizacion.fecha_servicio
          }
        })
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateVenta = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`ventas/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

export const cancelarVenta = async (data) => {
  try {
    data.estatus = 'Cancelada'

    const response = await apiClient.put('cancelar-venta', data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeVenta = async (id) => {
  try {
    const response = await apiClient.delete(`ventas/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
