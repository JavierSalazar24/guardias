import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import {
  getReporteSupervisor,
  removeReporteSupervisor
} from '../api/reportes-supervisor'
import { toast } from 'sonner'
import { useModalStore } from '../store/useModalStore'

export const useReportesSupervisor = () => {
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['reportes-supervisor'],
    queryFn: getReporteSupervisor
  })

  const deleteMutation = useMutation({
    mutationFn: removeReporteSupervisor,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['check-guardia'] })
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
