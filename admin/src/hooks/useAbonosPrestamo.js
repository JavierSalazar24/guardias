import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import {
  createAbonoPrestamo,
  getAbonoPrestamo,
  removeAbonoPrestamo,
  updateAbonoPrestamo
} from '../api/abonos-prestamo'
import { toast } from 'sonner'

export const useAbonosPrestamo = () => {
  // Store de modal
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['abonos-prestamo'],
    queryFn: getAbonoPrestamo
  })

  const createMutation = useMutation({
    mutationFn: createAbonoPrestamo,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['abonos-prestamo'] })
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
    mutationFn: updateAbonoPrestamo,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['abonos-prestamo'] })
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
    mutationFn: removeAbonoPrestamo,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['abonos-prestamo'] })
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

    const newData = {
      ...formData,
      prestamo_id: formData.prestamo_id.value,
      banco_id: formData.banco_id.value
    }

    if (modalType === 'add') {
      createMutation.mutate(newData)
    } else if (modalType === 'edit') {
      updateMutation.mutate(newData)
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
