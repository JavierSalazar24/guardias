import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Leer registros
export const getEquipamiento = async () => {
  try {
    const response = await apiClient.get('equipamiento-completo')
    const { data } = response
    return data.map((equipo) => {
      const fecha_devuelto_format = equipo.fecha_devuelto
        ? dayjs(equipo.fecha_devuelto).format('DD/MM/YYYY')
        : 'Sin devolver'

      const equipo_asignado = equipo.detalles
        .map(
          (detalle) => `${detalle.articulo.nombre} (${detalle.numero_serie})`
        )
        .toString()
        .replaceAll(',', ', ')

      return {
        ...equipo,
        guardia_id: {
          label: `${equipo.guardia.nombre} ${equipo.guardia.apellido_p} ${equipo.guardia.apellido_m}`,
          value: equipo.guardia.id
        },
        vehiculo_id: {
          label: `${equipo.vehiculo.tipo_vehiculo} - ${equipo.vehiculo.marca} (${equipo.vehiculo.placas})`,
          value: equipo.vehiculo.id
        },
        guardia: `${equipo.guardia.nombre} ${equipo.guardia.apellido_p}`,
        vehiculo: `${equipo.vehiculo.tipo_vehiculo} (${equipo.vehiculo.placas})`,
        equipo: equipo_asignado,
        fecha_entrega_format: dayjs(equipo.fecha_entrega).format('DD/MM/YYYY'),
        fecha_devuelto_format
      }
    })
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}
