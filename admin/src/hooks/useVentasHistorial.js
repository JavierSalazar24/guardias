import { useQuery } from '@tanstack/react-query'
import { getVentaHistorial } from '../api/ventas-historial'

export const useVentasHistorial = () => {
  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['ventas-historial'],
    queryFn: getVentaHistorial
  })

  return {
    data,
    error,
    isError,
    isLoading
  }
}
