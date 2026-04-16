import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import {
  cancelarVenta,
  createVenta,
  getVenta,
  removeVenta,
  updateVenta
} from '../api/ventas'
import { toast } from 'sonner'

export const useVentas = () => {
  // Store de modal
  let toastId

  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['ventas'],
    queryFn: getVenta
  })

  const createMutation = useMutation({
    mutationFn: createVenta,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ventas'] })
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
    mutationFn: updateVenta,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ventas'] })
      toast.success('Registro actualizado')
      closeModal()
      Swal.close()
    },
    onError: (error) => {
      toast.error(error.message)
      Swal.close()
    }
  })

  const cancelarMutation = useMutation({
    mutationFn: cancelarVenta,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ventas'] })
      toast.dismiss(toastId)
      toast.warning('Venta cancelada')
      closeModal()
    },
    onError: (error) => {
      toast.dismiss(toastId)
      toast.error(error.message)
    }
  })

  const deleteMutation = useMutation({
    mutationFn: removeVenta,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ventas'] })
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
      cotizacion_id: formData.cotizacion_id.value,
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

  const handleCancel = (data) => {
    toastId = toast.loading('Cancelando venta...')
    cancelarMutation.mutate(data)
  }

  return {
    data,
    error,
    isError,
    isLoading,
    handleSubmit,
    handleDelete,
    handleCancel
  }
}
