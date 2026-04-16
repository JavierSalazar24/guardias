import { toast } from 'sonner'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import { getGuardias } from '../api/guardias'
import {
  createCotizacion,
  getCotizacion,
  removeCotizacion,
  updateCotizacion
} from '../api/cotizaciones'

export const useCotizaciones = () => {
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isError, data, error, isLoading } = useQuery({
    queryKey: ['cotizaciones'],
    queryFn: getCotizacion
  })

  const createMutation = useMutation({
    mutationFn: createCotizacion,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['cotizaciones'] })
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
    mutationFn: updateCotizacion,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['cotizaciones'] })
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
    mutationFn: removeCotizacion,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['cotizaciones'] })
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
      sucursal_empresa_id: formData.sucursal_empresa_id.value
    }

    if (modalType === 'add') {
      createMutation.mutate(newData)
    } else if (modalType === 'edit') {
      updateMutation.mutate(newData)
    }
  }

  const loadOptions = async () => {
    try {
      const response = await getGuardias()

      return response.map((rh) => ({
        value: rh.id,
        label: `${rh.nombre} ${rh.apellido_p} ${rh.apellido_m}`
      }))
    } catch (error) {
      console.error('Error cargando empleados:', error)
      return []
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
    handleDelete,
    loadOptions
  }
}
