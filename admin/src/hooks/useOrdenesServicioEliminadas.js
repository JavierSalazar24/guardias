import { useQuery } from '@tanstack/react-query'
import { getOrdenServicioEliminadas } from '../api/ordenes-servicios'

export const useOrdenesServicioEliminadas = () => {
  const { isError, data, error, isLoading } = useQuery({
    queryKey: ['ordenes-servicio-eliminadas'],
    queryFn: getOrdenServicioEliminadas
  })

  return {
    isLoading,
    isError,
    data,
    error
  }
}
