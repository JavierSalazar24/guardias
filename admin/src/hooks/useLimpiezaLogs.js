import { useQuery } from '@tanstack/react-query'
import { getLimpiezaLog } from '../api/limpieza-logs'

export const useLimpiezaLogs = () => {
  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['limpieza-logs'],
    queryFn: getLimpiezaLog
  })

  return {
    data,
    error,
    isError,
    isLoading
  }
}
