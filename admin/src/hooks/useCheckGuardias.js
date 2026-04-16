import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { getCheckGuardia, removeCheckGuardia } from '../api/check-guardia'
import { toast } from 'sonner'
import { useModalStore } from '../store/useModalStore'

export const useCheckGuardias = () => {
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['check-guardia'],
    queryFn: getCheckGuardia
  })

  const deleteMutation = useMutation({
    mutationFn: removeCheckGuardia,
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
