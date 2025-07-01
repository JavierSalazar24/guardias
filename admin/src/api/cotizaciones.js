import dayjs from 'dayjs'
import { apiClient } from './configAxios'
import { toFloat } from '../utils/numbers'

// Crear un registro
export const createCotizacion = async (data) => {
  try {
    const response = await apiClient.post('cotizaciones', data)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getCotizacion = async () => {
  try {
    const response = await apiClient.get('cotizaciones')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((cotizacion) => {
          const cliente_id = {
            label: cotizacion.sucursal.cliente.nombre_empresa,
            value: cotizacion.sucursal.cliente.id
          }

          const tiposServicios = cotizacion.servicios_cotizaciones.map(
            (s) => s.tipo_servicio
          )

          const tipo_servicio_id = tiposServicios.map((s) => ({
            value: s.id,
            label: s.nombre,
            costo: toFloat(s.costo)
          }))

          return {
            ...cotizacion,
            sucursal_id: cotizacion.sucursal.id,
            sucursal_cliente: cotizacion.sucursal.nombre_empresa,
            cliente_id,
            tipo_servicio_id,
            fecha_servicio_format: dayjs(cotizacion.fecha_servicio).format(
              'DD/MM/YYYY'
            ),
            total_servicio: `$${cotizacion.total}`,
            tipo_pago: cotizacion?.venta?.tipo_pago || null,
            metodo_pago: cotizacion?.venta?.metodo_pago || null,
            numero_factura: cotizacion?.venta?.numero_factura || null,
            fecha_emision: cotizacion?.venta?.fecha_emision || null,
            nota_credito: cotizacion?.venta?.nota_credito || null,
            nombre_sucursal: cotizacion.sucursal_empresa.nombre_sucursal,
            sucursal_empresa_id: {
              label: cotizacion.sucursal_empresa.nombre_sucursal,
              value: cotizacion.sucursal_empresa.id
            }
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
export const updateCotizacion = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`cotizaciones/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeCotizacion = async (id) => {
  try {
    const response = await apiClient.delete(`cotizaciones/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
