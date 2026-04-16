import { useQuery } from '@tanstack/react-query'
import { getGuardiasTotales } from '../api/guardias'

export const useGuardiasTotales = () => {
  const { isLoading, isError, data } = useQuery({
    queryKey: ['guardias-totales'],
    queryFn: getGuardiasTotales
  })

  return { data, isLoading, isError }
}
