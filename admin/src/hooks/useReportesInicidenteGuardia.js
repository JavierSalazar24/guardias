import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import {
  getReporteIncidenteGuardia,
  removeReporteIncidenteGuardia,
  updateReporteIncidenteGuardia
} from '../api/reportes-incidente-guardia'
import { toast } from 'sonner'
import Swal from 'sweetalert2'
import { useModalStore } from '../store/useModalStore'

export const useReportesInicidenteGuardia = () => {
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['reportes-incidentes-guardia'],
    queryFn: getReporteIncidenteGuardia
  })

  const updateMutation = useMutation({
    mutationFn: updateReporteIncidenteGuardia,
    onSuccess: () => {
      queryClient.invalidateQueries({
        queryKey: ['reportes-incidentes-guardia']
      })
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
    mutationFn: removeReporteIncidenteGuardia,
    onSuccess: () => {
      queryClient.invalidateQueries({
        queryKey: ['reportes-incidentes-guardia']
      })
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

    if (modalType === 'edit') {
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
