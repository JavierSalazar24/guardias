import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import {
  getReportePatrullas,
  removeReportePatrullas
} from '../api/reportes-patrullas'
import { toast } from 'sonner'
import { useModalStore } from '../store/useModalStore'

export const useReportesPatrullas = () => {
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['reportes-patrullas'],
    queryFn: getReportePatrullas
  })

  const deleteMutation = useMutation({
    mutationFn: removeReportePatrullas,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['reportes-patrullas'] })
      toast.success('Registro eliminado')
    },
    onError: (error) => {
      toast.error(error.message)
    }
  })

  const handleDelete = (id) => {
    deleteMutation.mutate(id)
    closeModal()
  }

  return {
    data,
    error,
    isError,
    isLoading,
    handleDelete
  }
}
