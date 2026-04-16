import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import {
  getReporteGuardia,
  removeReporteGuardia
} from '../api/reportes-guardias'
import { toast } from 'sonner'
import { useModalStore } from '../store/useModalStore'

export const useReportesGuardia = () => {
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['reportes-guardias'],
    queryFn: getReporteGuardia
  })

  const deleteMutation = useMutation({
    mutationFn: removeReporteGuardia,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['reportes-guardias'] })
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
