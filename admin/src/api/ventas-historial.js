import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getVentaHistorial = async () => {
  try {
    const response = await apiClient.get('ventas-historial')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((historial) => {
          const nombre_empresa = historial?.cotizacion?.sucursal
            ? historial?.cotizacion?.sucursal?.nombre_empresa
            : historial?.cotizacion?.nombre_empresa

          const cotizacion_aceptada = dayjs(
            historial.fecha_emision,
            'YYYY-MM-DD'
          ).format('DD/MM/YYYY')

          const fecha_emision_format = dayjs(
            historial.fecha_emision,
            'YYYY-MM-DD'
          ).format('DD/MM/YYYY')

          const banco_id = historial?.banco
            ? { label: historial.banco.nombre, value: historial.banco.id }
            : ''

          return {
            ...historial,
            nombre: `${historial.usuario.nombre_completo} (${historial.usuario.rol.nombre})`,
            nombre_admin: historial.usuario.nombre_completo,
            nombre_rol: historial.usuario.rol.nombre,
            cotizacion_id: {
              label: nombre_empresa,
              value: historial.cotizacion.id
            },
            banco_id,
            cotizacion: historial.cotizacion.id,
            sucursal: typeof nombre_empresa === 'string' ? nombre_empresa : '',
            total_format: `$${historial.total}`,
            cotizacion_aceptada,
            fecha_emision_format,
            credito_dias: historial.credito_dias,

            banco_actualizado: historial.venta?.banco?.nombre || '',
            numero_factura_actualizado: historial.venta.numero_factura,
            fecha_emision_actualizado: historial.venta.fecha_emision,
            fecha_vencimiento_actualizado: historial.venta.fecha_vencimiento,
            total_actualizado: historial.venta.total,
            nota_credito_actualizado: historial.venta.nota_credito,
            tipo_pago_actualizado: historial.venta.tipo_pago,
            metodo_pago_actualizado: historial.venta.metodo_pago,
            estatus_actualizado: historial.venta.estatus,
            motivo_cancelada_actualizado: historial.venta.motivo_cancelada,
            credito_dias_actualizado: historial.venta.cotizacion.credito_dias,
            fecha_modificacion: dayjs(historial.created_at).format(
              'DD/MM/YYYY hh:mm:ss A'
            )
          }
        })
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}
