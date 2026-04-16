import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import {
  createModuloConcepto,
  getModuloConcepto,
  removeModuloConcepto,
  updateModuloConcepto
} from '../api/modulo-conceptos'
import { toast } from 'sonner'

export const useModuloConcepto = () => {
  // Store de modal
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['modulo-conceptos'],
    queryFn: getModuloConcepto
  })

  const createMutation = useMutation({
    mutationFn: createModuloConcepto,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['modulo-conceptos'] })
      toast.success('Registro agregado')
      Swal.close()
      closeModal()
    },
    onError: (error) => {
      Swal.close()
      toast.error(error.message)
    }
  })

  const updateMutation = useMutation({
    mutationFn: updateModuloConcepto,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['modulo-conceptos'] })
      toast.success('Registro actualizado')
      closeModal()
      Swal.close()
    },
    onError: (error) => {
      toast.error(error.message)
      Swal.close()
    }
  })

  const deleteMutation = useMutation({
    mutationFn: removeModuloConcepto,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['modulo-conceptos'] })
      toast.success('Registro eliminado')
    },
    onError: (error) => {
      toast.error(error.message)
    }
  })

  const handleSubmit = (e) => {
    e.preventDefault()
    Swal.fire({
      title:
        '<h2 style="font-family: "sans-serif";">Guardando registro, por favor espere...</h2>',
      allowEscapeKey: false,
      allowOutsideClick: false,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
      }
    })

    if (modalType === 'add') {
      createMutation.mutate(formData)
    } else if (modalType === 'edit') {
      updateMutation.mutate(formData)
    }
  }

  const handleDelete = (id) => {
    deleteMutation.mutate(id)
    closeModal()
  }

  return {
    data,
    error,
    isError,
    isLoading,
    handleSubmit,
    handleDelete
  }
}
