import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import {
  createActaAdministrativa,
  getActaAdministrativa,
  removeActaAdministrativa,
  updateActaAdministrativa
} from '../api/actas-administrativas'
import { toast } from 'sonner'

export const useActasAdministrativas = () => {
  // Store de modal
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['incidencias'],
    queryFn: getActaAdministrativa
  })

  const createMutation = useMutation({
    mutationFn: createActaAdministrativa,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['incidencias'] })
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
    mutationFn: updateActaAdministrativa,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['incidencias'] })
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
    mutationFn: removeActaAdministrativa,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['incidencias'] })
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
      empleado_id: formData.empleado_id.value,
      supervisor_id: formData.supervisor_id.value,
      testigo1_id: formData.testigo1_id.value,
      testigo2_id: formData.testigo2_id.value,
      motivo_id: formData.motivo_id.value
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
