import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import {
  getReporteBitacora,
  removeReporteBitacora
} from '../api/reportes-bitacora'
import { toast } from 'sonner'
import { useModalStore } from '../store/useModalStore'

export const useReportesBitacoras = () => {
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['reportes-bitacora'],
    queryFn: getReporteBitacora
  })

  const deleteMutation = useMutation({
    mutationFn: removeReporteBitacora,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['reportes-bitacora'] })
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
