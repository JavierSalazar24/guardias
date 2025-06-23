import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getReporteCarteraVencida = async () => {
  try {
    const response = await apiClient.get('cartera-vencida')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((historial) => {
          const nombre_empresa = historial?.cotizacion?.sucursal
            ? historial?.cotizacion?.sucursal?.nombre_empresa
            : historial?.cotizacion?.nombre_empresa

          const cliente =
            historial?.cotizacion?.sucursal?.cliente.nombre_empresa || 'N/A'
          const sucursal =
            typeof nombre_empresa === 'string' ? nombre_empresa : 'N/A'

          return {
            ...historial,
            cotizacion_id: {
              label: nombre_empresa,
              value: historial.cotizacion.id
            },
            cliente,
            sucursal,
            numero_factura: historial.numero_factura,
            fecha_emision: historial.fecha_emision,
            fecha_vencimiento: historial.fecha_vencimiento,
            total: historial.total,
            nota_credito: historial.nota_credito,
            tipo_pago: historial.tipo_pago,
            metodo_pago: historial.metodo_pago,
            estatus: historial.estatus,
            credito_dias: historial.cotizacion.credito_dias,

            fecha_vencimiento_format: dayjs(historial.fecha_vencimiento).format(
              'DD/MM/YYYY'
            ),
            atraso: dayjs().diff(dayjs(historial.fecha_vencimiento), 'day'),
            total_format: `$${historial.total}`
          }
        })
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}
