import { useLocation } from 'react-router'
import { useEffect, useState } from 'react'
import { useModalStore } from '../store/useModalStore'
import { useCalculosTotales } from './useCalculosTotales'
import { dispatchFormLogic } from './forms/formDispatcher'
import { makeLoaderGuardiasBySucursal } from './useCatalogLoaders'
import { obetenerGuardiasOrdenes } from '../utils/obtenerGuardiasOrdenes'
import { getSucursalByCliente } from '../api/sucursales'
import { toast } from 'sonner'
import { equipoEffects } from './equipoEffects'

export const useModal = () => {
  const { pathname } = useLocation()

  const [initialLoad, setInitialLoad] = useState(false)
  const [articulosDisponibles, setArticulosDisponibles] = useState({})
  const [selectOptions, setSelectOptions] = useState([
    { label: 'Selecciona una opción', value: '' }
  ])
  const [sucursalGuardiasId, setSucursalGuardiasId] = useState(null)
  const [selectSupervisorBySucursal, setSelectSupervisorBySucursal] = useState(
    []
  )
  const [selectJefeBySucursal, setSelectJefeBySucursal] = useState([])
  const [reloadGuardias, setReloadGuardias] = useState(0)

  const getArtDis = useModalStore((state) => state.getArtDis)
  const modalType = useModalStore((state) => state.modalType)
  const setFormData = useModalStore((state) => state.setFormData)
  const formData = useModalStore((state) => state.formData)
  const openModal = useModalStore((state) => state.openModal)
  const closeModal = useModalStore((state) => state.closeModal)
  const currentItem = useModalStore((state) => state.currentItem)

  const view = modalType === 'view'
  const add = modalType === 'add'
  const edit = modalType === 'edit'
  const deleteModal = modalType === 'delete'
  const document = view || edit

  const {
    recalcularTotales,
    calcularGuardiasTotal,
    calcularTotalGastosCompras,
    actualizarTotal
  } = useCalculosTotales({ formData, setFormData })

  const handleInputChange = async (e, actionMeta) => {
    let name, value

    if (e.target) {
      ;({ name, value } = e.target)
    } else {
      name = actionMeta.name
      value = e || []
    }

    setFormData(name, value)

    await dispatchFormLogic(pathname, {
      name,
      value,
      setFormData,
      formData,
      pathname,
      // Helpers de los forms
      recalcularTotales,
      calcularGuardiasTotal,
      actualizarTotal,
      calcularTotalGastosCompras,
      setSelectSupervisorBySucursal,
      setSelectJefeBySucursal,
      setSucursalGuardiasId,
      setReloadGuardias,
      setArticulosDisponibles,
      setSelectOptions
    })
  }

  const handleCheckboxChange = async (e) => {
    const { name, checked, value } = e.target
    setFormData(name, checked)

    if (pathname === '/equipo') {
      const [nombreArticulo, id] = value.split('-')
      const key = `articulo-${nombreArticulo}-${id}`
      const serieKey = `seleccionado-numero_serie-${id}`

      if (!checked) {
        setArticulosDisponibles((prev) => {
          const updated = { ...prev }
          delete updated[key]
          return updated
        })

        setFormData(serieKey, '')
        return
      }

      try {
        const disponibles = await getArtDis(id)
        if (disponibles.length === 0) {
          toast.warning('Artículo no disponible en almacén')
          setFormData(name, false)
          return
        }

        setArticulosDisponibles((prev) => ({
          ...prev,
          [key]: disponibles
        }))
      } catch (err) {
        console.error('Error al cargar artículos disponibles:', err)
        setFormData(name, false)
      }
    }
  }

  const handleFileChange = (e) => {
    const { name, files } = e.target
    if (!files.length) return

    const file = files[0]
    setFormData(name, file)

    const previewURL = URL.createObjectURL(file)
    setFormData('preview', previewURL)
  }

  const handleMultipleFilesChange = (e) => {
    const { name, files } = e.target
    if (!files.length) return

    const fileArray = Array.from(files)

    // Guardamos los archivos en el estado
    setFormData(name, fileArray)
  }

  useEffect(() => {
    if ((edit || view) && currentItem && pathname === '/equipo') {
      setInitialLoad(true)
    }
  }, [currentItem, edit, view, pathname])

  useEffect(() => {
    if (pathname === '/equipo') {
      equipoEffects({
        currentItem,
        pathname,
        setInitialLoad,
        initialLoad,
        setFormData,
        setArticulosDisponibles,
        getArtDis
      })
    }
  }, [initialLoad, pathname])

  useEffect(() => {
    if (
      (edit || view) &&
      formData.cliente_id?.value &&
      pathname === '/cotizaciones'
    ) {
      const getSucursalesByCliente = async () => {
        await updateSucursalesByCliente(formData.cliente_id.value)
      }

      getSucursalesByCliente()
    }
  }, [edit, formData.cliente_id?.value, pathname, view])

  const updateSucursalesByCliente = async (clienteId) => {
    try {
      const response = await getSucursalByCliente(clienteId)
      const data = response.map((sucursal) => ({
        value: sucursal.id,
        label: sucursal.nombre_empresa
      }))

      const options = [{ label: 'Selecciona una opción', value: '' }, ...data]

      setSelectOptions(options)
    } catch (error) {
      console.error('Error al obtener sucursales:', error)
      setSelectOptions([])
    }
  }

  useEffect(() => {
    if ((view || edit) && pathname === '/orden-servicio') {
      const cargarGuardias = async () => {
        await obetenerGuardiasOrdenes({
          id: formData.venta.id,
          setSelectSupervisorBySucursal,
          setSelectJefeBySucursal,
          setSucursalGuardiasId,
          setReloadGuardias
        })
      }

      cargarGuardias()
    }
  }, [formData, view, edit, pathname])

  const loadOptionsGuardiasBySucursal =
    makeLoaderGuardiasBySucursal(sucursalGuardiasId)

  return {
    view,
    add,
    edit,
    deleteModal,
    document,
    modalType,
    setFormData,
    formData,
    openModal,
    closeModal,
    currentItem,
    handleInputChange,
    handleFileChange,
    handleMultipleFilesChange,
    handleCheckboxChange,
    loadOptionsGuardiasBySucursal,
    selectOptions,
    articulosDisponibles,
    selectSupervisorBySucursal,
    selectJefeBySucursal,
    reloadGuardias
  }
}
