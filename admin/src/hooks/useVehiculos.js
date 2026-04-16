import { toast } from 'sonner'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import { getGuardias } from '../api/guardias'
import {
  createVehiculo,
  getVehiculo,
  removeVehiculo,
  updateVehiculo
} from '../api/vehiculos'

export const useVehiculos = () => {
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isError, data, error, isLoading } = useQuery({
    queryKey: ['vehiculos'],
    queryFn: getVehiculo
  })

  const createMutation = useMutation({
    mutationFn: createVehiculo,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['vehiculos'] })
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
    mutationFn: updateVehiculo,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['vehiculos'] })
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
    mutationFn: removeVehiculo,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['vehiculos'] })
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
