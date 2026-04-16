import dayjs from 'dayjs'
import { apiClient } from './configAxios'
import customParseFormat from 'dayjs/plugin/customParseFormat'
dayjs.extend(customParseFormat)

// Crear un registro
export const createActaAdministrativa = async (data) => {
  try {
    const response = await apiClient.post('actas-administrativas', data)
    return response.data
  } catch (error) {
    console.error('Error al agregar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getActaAdministrativa = async () => {
  try {
    const response = await apiClient.get('actas-administrativas')
    const { data } = response

    return data.map((acta) => ({
      ...acta,
      empleado_nombre: `${acta.empleado.nombre} ${acta.empleado.apellido_p} ${acta.empleado.apellido_m}`,
      empleado_id: {
        label: `${acta.empleado.nombre} ${acta.empleado.apellido_p} ${acta.empleado.apellido_m} (${acta.empleado.numero_empleado} - ${acta.empleado.rango.nombre})`,
        value: acta.empleado.id
      },
      supervisor_nombre: `${acta.supervisor.nombre} ${acta.supervisor.apellido_p} ${acta.supervisor.apellido_m}`,
      supervisor_id: {
        label: `${acta.supervisor.nombre} ${acta.supervisor.apellido_p} ${acta.supervisor.apellido_m} (${acta.supervisor.numero_empleado} - ${acta.supervisor.rango.nombre})`,
        value: acta.supervisor.id
      },
      testigo1_nombre: `${acta.testigo1.nombre} ${acta.testigo1.apellido_p} ${acta.testigo1.apellido_m}`,
      testigo1_id: {
        label: `${acta.testigo1.nombre} ${acta.testigo1.apellido_p} ${acta.testigo1.apellido_m} (${acta.testigo1.numero_empleado} - ${acta.testigo1.rango.nombre})`,
        value: acta.testigo1.id
      },
      testigo2_nombre: `${acta.testigo2.nombre} ${acta.testigo2.apellido_p} ${acta.testigo2.apellido_m}`,
      testigo2_id: {
        label: `${acta.testigo2.nombre} ${acta.testigo2.apellido_p} ${acta.testigo2.apellido_m} (${acta.testigo2.numero_empleado} - ${acta.testigo2.rango.nombre})`,
        value: acta.testigo2.id
      },
      fecha_hora_format: dayjs(acta.fecha_hora).format('DD/MM/YYYY hh:mm A'),
      motivo_nombre: acta.motivo_acta.motivo,
      motivo_id: {
        label: acta.motivo_acta.motivo,
        value: acta.motivo_acta.id
      }
    }))
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateActaAdministrativa = async (data) => {
  try {
    const { id } = data

    const response = await apiClient.put(`actas-administrativas/${id}`, data)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeActaAdministrativa = async (id) => {
  try {
    const response = await apiClient.delete(`actas-administrativas/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
