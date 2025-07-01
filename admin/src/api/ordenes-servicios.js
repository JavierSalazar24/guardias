import dayjs from 'dayjs'
import { apiClient } from './configAxios'

// Crear un registro
export const createOrdenServicio = async (data) => {
  try {
    const response = await apiClient.post('orden-servicio', data)
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
      const guardias = orden.ordenes_servicio_guardias
        .filter((g) => g.guardia.rango === 'Guardia')
        .map((g) => g.guardia)

      const guardias_id = guardias.map((g) => ({
        value: g.id,
        label: `${g.nombre} ${g.apellido_p} ${g.apellido_m}`
      }))

      // Si existe supervisor
      const supervisor = orden.ordenes_servicio_guardias.find(
        (g) => g.guardia.rango === 'Supervisor'
      )

      const supervisor_id = supervisor ? supervisor.guardia.id : null

      // Si existe jefe de turno
      const jefeTurno = orden.ordenes_servicio_guardias.find(
        (g) => g.guardia.rango === 'Jefe de turno'
      )
      const jefe_turno_id = jefeTurno ? jefeTurno.guardia.id : null

      const nombre_empresa = orden.venta.cotizacion.sucursal.nombre_empresa

      const venta_id = {
        label: `${nombre_empresa} (${orden.venta.numero_factura})`,
        value: orden.venta.id
      }

      const guardiasAsignados = `${guardias.length} guardia(s)`
      const supervisorAsignado = `${
        supervisor && orden.venta.cotizacion.supervisor === 'SI' ? 1 : 0
      } supervisor(es)`
      const jefeTurnoAsignado = `${
        jefeTurno && orden.venta.cotizacion.jefe_turno === 'SI' ? 1 : 0
      } jefe(s) de turno`

      const asignados = `${guardiasAsignados}, ${supervisorAsignado} y ${jefeTurnoAsignado}`

      console.log(jefeTurno, supervisor)

      return {
        ...orden,
        venta_id,
        guardias_id,
        supervisor_id,
        jefe_turno_id,
        supervisor: orden.venta.cotizacion.supervisor,
        jefe_turno: orden.venta.cotizacion.jefe_turno,
        nombre_empresa,
        asignados,
        inicio_format: dayjs(orden.fecha_inicio).format('DD/MM/YYYY')
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
      const asignados = orden.ordenes_servicio_guardias
        .map(
          (g) =>
            `${g.guardia.nombre} ${g.guardia.apellido_p} (${g.guardia.rango})`
        )
        .toString()
        .replaceAll(',', ', ')

      const guardias = orden.ordenes_servicio_guardias
        .filter((g) => g.guardia.rango === 'Guardia')
        .map((g) => g.guardia)

      const guardias_id = guardias.map((g) => ({
        value: g.id,
        label: `${g.nombre} ${g.apellido_p} ${g.apellido_m}`
      }))

      // Si existe supervisor
      const supervisor = orden.ordenes_servicio_guardias.find(
        (g) => g.guardia.rango === 'Supervisor'
      )

      const supervisor_id = supervisor ? supervisor.guardia.id : null

      // Si existe jefe de turno
      const jefeTurno = orden.ordenes_servicio_guardias.find(
        (g) => g.guardia.rango === 'Jefe de turno'
      )
      const jefe_turno_id = jefeTurno ? jefeTurno.guardia.id : null

      const nombre_empresa = orden.venta?.cotizacion?.sucursal
        ? orden.venta?.cotizacion?.sucursal?.nombre_empresa
        : orden.venta?.cotizacion?.nombre_empresa

      const venta_id = {
        label: `${nombre_empresa} (${orden.venta.numero_factura})`,
        value: orden.venta.id
      }

      return {
        ...orden,
        venta_id,
        guardias_id,
        supervisor_id,
        jefe_turno_id,
        supervisor: orden.venta.cotizacion.supervisor,
        jefe_turno: orden.venta.cotizacion.jefe_turno,
        nombre_empresa,
        asignados,
        inicio_format: dayjs(orden.fecha_inicio).format('DD/MM/YYYY')
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

    const response = await apiClient.put(`orden-servicio/${id}`, data)
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
