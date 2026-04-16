import { useQuery } from '@tanstack/react-query'
import { getReporteCarteraVencida } from '../api/reporte-cartera-vencida'

export const useReporteCarteraVencida = () => {
  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['reporte-cartera-vencida'],
    queryFn: getReporteCarteraVencida
  })

  return {
    data,
    error,
    isError,
    isLoading
  }
}
