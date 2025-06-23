import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { useModalStore } from '../store/useModalStore'
import Swal from 'sweetalert2'
import {
  createEquipamiento,
  getEquipamiento,
  removeEquipamiento,
  updateEquipamiento
} from '../api/equipamiento'
import { toast } from 'sonner'
import { getArticuloAsignar } from '../api/articulos'
import { getGuardias } from '../api/guardias'
import { getVehiculosDisponibles } from '../api/vehiculos'

export const useEquipamiento = () => {
  // Store de modal
  const modalType = useModalStore((state) => state.modalType)
  const formData = useModalStore((state) => state.formData)
  const closeModal = useModalStore((state) => state.closeModal)
  const firma = useModalStore((state) => state.firma)
  const editFirma = useModalStore((state) => state.editFirma)

  const queryClient = useQueryClient()

  const { isLoading, isError, data, error } = useQuery({
    queryKey: ['equipamiento'],
    queryFn: getEquipamiento
  })

  const {
    isLoading: loadArti,
    isError: errorArti,
    data: articulos
  } = useQuery({
    queryKey: ['articulos-asignar'],
    queryFn: getArticuloAsignar
  })

  const createMutation = useMutation({
    mutationFn: createEquipamiento,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['equipamiento'] })
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
    mutationFn: updateEquipamiento,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['equipamiento'] })
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
    mutationFn: removeEquipamiento,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['equipamiento'] })
      toast.success('Registro eliminado')
    },
    onError: (error) => {
      toast.error(error.message)
    }
  })

  const handleSubmit = (e) => {
    e.preventDefault()

    let signatureFirma = null
    if (firma === null && modalType === 'add') {
      toast.warning('La firma es obligatoría.')
      return
    } else if (firma === null && modalType === 'edit') {
      signatureFirma = formData.firma_guardia
    } else if (firma !== null) {
      signatureFirma = firma
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

    const newData = {
      ...formData,
      guardia_id: formData.guardia_id.value,
      vehiculo_id: formData.vehiculo_id.value,
      firma_guardia: signatureFirma
    }

    if (modalType === 'add') {
      createMutation.mutate(newData)
    } else if (modalType === 'edit') {
      updateMutation.mutate(newData)
    }

    editFirma(null)
  }

  const handleDelete = (id) => {
    deleteMutation.mutate(id)
    closeModal()
  }

  const loadOptionsGuardia = async () => {
    try {
      const response = await getGuardias()

      return response.map((guardia) => ({
        value: guardia.id,
        label: guardia.nombre_completo
      }))
    } catch (error) {
      console.error('Error cargando empleados:', error)
      return []
    }
  }

  const loadOptionsVehiculo = async () => {
    try {
      const response = await getVehiculosDisponibles()

      return response.map((vehiculo) => ({
        value: vehiculo.id,
        label: `${vehiculo.tipo_vehiculo} - ${vehiculo.marca} (${vehiculo.placas})`
      }))
    } catch (error) {
      console.error('Error cargando empleados:', error)
      return []
    }
  }

  return {
    data,
    error,
    isError,
    isLoading,
    loadArti,
    errorArti,
    articulos,
    handleSubmit,
    handleDelete,
    loadOptionsGuardia,
    loadOptionsVehiculo
  }
}
