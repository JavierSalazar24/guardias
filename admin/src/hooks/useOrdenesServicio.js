import { toast } from 'sonner'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import {
  createOrdenServicio,
  getOrdenServicio,
  removeOrdenServicio,
  updateOrdenServicio
} from '../api/ordenes-servicios'
import dayjs from 'dayjs'
import { ordenServicioSchema } from '../zod/schemas'

export const useOrdenesServicio = () => {
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isError, data, error, isLoading } = useQuery({
    queryKey: ['ordenes-servicios'],
    queryFn: getOrdenServicio
  })

  const createMutation = useMutation({
    mutationFn: createOrdenServicio,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ordenes-servicios'] })
      toast.success('Registro agregado')
      closeModal()
      Swal.close()
    },
    onError: (error) => {
      toast.error(error.message)
      Swal.close()
    }
  })

  const updateMutation = useMutation({
    mutationFn: updateOrdenServicio,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ordenes-servicios'] })
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
    mutationFn: removeOrdenServicio,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['ordenes-servicios'] })
      toast.success('Registro eliminado')
    },
    onError: (error) => {
      toast.error(error.message)
    }
  })

  const handleSubmit = (e) => {
    e.preventDefault()

    // Validación con Zod
    const parsed = ordenServicioSchema.safeParse(formData)

    if (!parsed.success) {
      const errors = parsed.error.flatten().fieldErrors
      const firstError = Object.values(errors)[0][0]
      toast.error(firstError)
      return
    }

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

    if (dayjs(formData.fecha_inicio).isAfter(dayjs(formData.fecha_fin))) {
      toast.warning('La fecha de fin no puede ser antes que la fecha de inicio')
      Swal.close()
      return
    }

    const newData = {
      ...formData,
      venta_id: formData.venta_id.value
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
    isLoading,
    isError,
    data,
    error,
    createMutation,
    updateMutation,
    deleteMutation,
    handleSubmit,
    handleDelete
  }
}
