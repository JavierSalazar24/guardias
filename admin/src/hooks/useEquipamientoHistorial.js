import { useQuery } from '@tanstack/react-query'
import { getEquipamiento } from '../api/equipamiento-historial'
import { getArticuloAsignar } from '../api/articulos'
import { getGuardias } from '../api/guardias'
import { getVehiculosDisponibles } from '../api/vehiculos'

export const useEquipamientoHistorial = () => {
  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['equipamiento-historial'],
    queryFn: getEquipamiento
  })

  const {
    isLoading: loadArti,
    isError: errorArti,
    data: articulos
  } = useQuery({
    queryKey: ['articulos-asignar'],
    queryFn: getArticuloAsignar
  })

  const loadOptionsGuardia = async () => {
    try {
      const response = await getGuardias()

      return response.map((guardia) => ({
        value: guardia.id,
        label: guardia.nombre_completo
      }))
    } catch (error) {
      console.error('Error cargando empleados:', error)
      return []
    }
  }

  const loadOptionsVehiculo = async () => {
    try {
      const response = await getVehiculosDisponibles()

      return response.map((vehiculo) => ({
        value: vehiculo.id,
        label: `${vehiculo.tipo_vehiculo} - ${vehiculo.marca} (${vehiculo.placas})`
      }))
    } catch (error) {
      console.error('Error cargando empleados:', error)
      return []
    }
  }

  return {
    data,
    error,
    isError,
    isLoading,
    loadArti,
    errorArti,
    articulos,
    loadOptionsGuardia,
    loadOptionsVehiculo
  }
}
