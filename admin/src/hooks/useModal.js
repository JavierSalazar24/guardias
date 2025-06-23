import { useLocation } from 'react-router'
import { useState, useEffect } from 'react'
import { useModalStore } from '../store/useModalStore'
import estadosData from '../utils/estados.json'
import estadosMunicipiosData from '../utils/municipios.json'
import { getCliente } from '../api/clientes'
import { getBanco } from '../api/bancos'
import { getProveedor } from '../api/proveedores'
import { getArticulo, getArticuloById } from '../api/articulos'
import { getSucursalByCliente } from '../api/sucursales'
import { getCotizacion } from '../api/cotizaciones'
import { toast } from 'sonner'
import { getVentaById, getVentaOrdenServicio } from '../api/ventas'
import {
  getGuardiaById,
  getGuardias,
  getGuardiasBySucursal,
  getJefeBySucursal,
  getSupervisorBySucursal,
  getSupervisores
} from '../api/guardias'
import { getRol } from '../api/roles'
import { getModulo } from '../api/modulos'
import { getPrestamoPendiente } from '../api/prestamos'
import { getSucursalEmpresa } from '../api/sucursales-empresa'
import { toFloat, toInt } from '../utils/numbers'
import { getModuloDescuento } from '../api/modulo-descuentos'
import { getModuloPrestamo } from '../api/modulo-prestamos'
import { getVehiculo } from '../api/vehiculos'
import { getOrdenServicio } from '../api/ordenes-servicios'
import dayjs from 'dayjs'
import { getEstadoCuentaGuardia } from '../api/reportes'
import { getModuloConcepto } from '../api/modulo-conceptos'

export const useModal = () => {
  const { pathname } = useLocation()

  const [initialLoad, setInitialLoad] = useState(false)
  const [articulosDisponibles, setArticulosDisponibles] = useState({})
  const [estados, setEstados] = useState([])
  const [municipios, setMunicipios] = useState([])
  const [estadosMunicipios, setEstadosMunicipios] = useState({})
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
  const setNestedFormData = useModalStore((state) => state.setNestedFormData)
  const formData = useModalStore((state) => state.formData)
  const openModal = useModalStore((state) => state.openModal)
  const closeModal = useModalStore((state) => state.closeModal)
  const currentItem = useModalStore((state) => state.currentItem)

  const view = modalType === 'view'
  const add = modalType === 'add'
  const edit = modalType === 'edit'
  const deleteModal = modalType === 'delete'
  const document = view || edit

  const aplicarImpuesto = (totalBase, porcentaje) => {
    const impuesto = toFloat(porcentaje) || 0
    return totalBase + totalBase * (impuesto / 100)
  }

  const actualizarTotal = (
    subtotal,
    descuentoPorcentaje = 0,
    costoExtra = 0,
    impuestoPorcentaje = formData?.impuesto
  ) => {
    const base = subtotal + costoExtra

    const descuento = (base * descuentoPorcentaje) / 100
    const baseConDescuento = base - descuento

    setFormData('total_base', baseConDescuento)

    const total = aplicarImpuesto(baseConDescuento, impuestoPorcentaje)
    setFormData('total', total.toFixed(2))
  }

  const calcularGuardiasTotal = (dia, noche) =>
    (toInt(dia) || 0) + (toInt(noche) || 0)

  const calcularPrecioGuardiasDiaTotal = (precio, cantidad) =>
    (toFloat(precio) || 0) * (toInt(cantidad) || 0)

  const calcularSubtotalGuardias = ({
    totalDia,
    totalNoche,
    precioJefe,
    precioSupervisor
  }) =>
    (toFloat(totalDia) || 0) +
    (toFloat(totalNoche) || 0) +
    (toFloat(precioJefe) || 0) +
    (toFloat(precioSupervisor) || 0)

  const recalcularTotales = ({
    precioDia = formData.precio_guardias_dia,
    precioNoche = formData.precio_guardias_noche,
    guardiasDia = formData.guardias_dia,
    guardiasNoche = formData.guardias_noche,
    precioJefe = formData.precio_jefe_turno,
    precioSupervisor = formData.precio_supervisor,
    descuentoPor = formData.descuento_porcentaje,
    costoExtra = formData.costo_extra
  } = {}) => {
    const totalDia = calcularPrecioGuardiasDiaTotal(precioDia, guardiasDia)
    const totalNoche = calcularPrecioGuardiasDiaTotal(
      precioNoche,
      guardiasNoche
    )

    setFormData('precio_guardias_dia_total', totalDia)
    setFormData('precio_guardias_noche_total', totalNoche)

    const subtotal = calcularSubtotalGuardias({
      totalDia,
      totalNoche,
      precioJefe,
      precioSupervisor
    })

    setFormData('subtotal', subtotal)
    actualizarTotal(subtotal, descuentoPor, costoExtra)
  }

  const calcularTotalGastosCompras = ({
    subtotal,
    descuento_monto,
    impuesto
  }) => {
    // Valores a float, por seguridad
    const sub = toFloat(subtotal) || 0
    const desc = toFloat(descuento_monto) || 0
    const imp = toFloat(impuesto) || 0

    // Evita que el descuento sea mayor que el subtotal
    const subMenosDesc = Math.max(0, sub - desc)
    const impuestoCalculado = subMenosDesc * (imp / 100)
    const total = subMenosDesc + impuestoCalculado

    return {
      subtotal: sub,
      descuento_monto: desc,
      impuesto: imp,
      total: total.toFixed(2)
    }
  }

  const handleInputChange = async (e, actionMeta) => {
    let name, value

    if (e.target) {
      ;({ name, value } = e.target)
    } else {
      name = actionMeta.name
      value = e || []
    }

    setFormData(name, value)

    if (['guardias_dia', 'guardias_noche'].includes(name)) {
      const dia =
        name === 'guardias_dia'
          ? toInt(value)
          : toInt(formData.guardias_dia) || 0
      const noche =
        name === 'guardias_noche'
          ? toInt(value)
          : toInt(formData.guardias_noche) || 0

      setFormData('cantidad_guardias', calcularGuardiasTotal(dia, noche))

      recalcularTotales({
        guardiasDia: dia,
        guardiasNoche: noche
      })
    }
    if (['precio_guardias_dia', 'precio_guardias_noche'].includes(name)) {
      const precioDia =
        name === 'precio_guardias_dia'
          ? toFloat(value)
          : toFloat(formData.precio_guardias_dia) || 0
      const precioNoche =
        name === 'precio_guardias_noche'
          ? toFloat(value)
          : toFloat(formData.precio_guardias_noche) || 0

      recalcularTotales({
        precioDia,
        precioNoche
      })
    }
    if (
      [
        'precio_jefe_turno',
        'precio_supervisor',
        'descuento_porcentaje',
        'costo_extra'
      ].includes(name)
    ) {
      const precioJefe =
        name === 'precio_jefe_turno'
          ? toFloat(value)
          : toFloat(formData.precio_jefe_turno) || 0
      const precioSupervisor =
        name === 'precio_supervisor'
          ? toFloat(value)
          : toFloat(formData.precio_supervisor) || 0

      const descuentoPor =
        name === 'descuento_porcentaje'
          ? toFloat(value)
          : toFloat(formData.descuento_porcentaje) || 0
      const costoExtra =
        name === 'costo_extra'
          ? toFloat(value)
          : toFloat(formData.costo_extra) || 0

      recalcularTotales({
        precioJefe,
        precioSupervisor,
        descuentoPor,
        costoExtra
      })
    }

    if (name === 'impuesto') {
      actualizarTotal(
        toFloat(formData.subtotal) || 0,
        toFloat(formData.descuento_porcentaje) || 0,
        toFloat(formData.costo_extra) || 0,
        toFloat(value)
      )
    }

    if (name === 'articulo_id') {
      if (pathname === '/almacen-salidas') {
        setFormData('numero_serie', value.numero_serie)
      } else {
        const data = await getArticuloById(value.value)
        const precio = toFloat(data.precio_compra) || 0
        setFormData('precio_articulo', precio)
      }
    }
    if (name === 'cantidad_articulo') {
      const precio = formData?.precio_articulo || 0
      const cantidad = toInt(value) || 0
      const subtotal = precio * cantidad

      setFormData('subtotal', subtotal)
      actualizarTotal(
        subtotal,
        toFloat(formData.descuento_porcentaje) || 0,
        toFloat(formData.costo_extra) || 0
      )
    }
    if (name === 'subtotal') {
      const subtotal = toFloat(value) || 0
      setFormData('subtotal', subtotal)
      actualizarTotal(
        subtotal,
        toFloat(formData.descuento_porcentaje) || 0,
        toFloat(formData.costo_extra) || 0
      )
    }
    if (name === 'cliente_id') {
      await updateSucursalesByCliente(value.value)
    }
    if (name === 'monto_por_hora' || name === 'horas') {
      const valor = name === 'monto_por_hora' ? toFloat(value) : toInt(value)

      const monto =
        name === 'monto_por_hora' ? valor : formData.monto_por_hora || 0
      const horas = name === 'horas' ? valor : formData.horas || 0

      const monto_total = monto * horas

      setFormData('monto_total', monto_total)
    }
    if (name === 'venta_id') {
      setFormData('domicilio_servicio', value.direccion)
      setFormData('supervisor', value.supervisor)
      setFormData('jefe_turno', value.jefe_turno)
      setFormData('fecha_inicio', `${value.fecha_servicio}T00:00:00`)

      const id = value.value
      const ventas = await getVentaById(id)
      const sucursal_id = ventas.cotizacion.sucursal_empresa.id

      const supervisor = await getSupervisorBySucursal(sucursal_id)
      supervisor.unshift({ label: 'Selecciona una opción', value: '' })
      setSelectSupervisorBySucursal(supervisor)

      const jefe = await getJefeBySucursal(sucursal_id)
      jefe.unshift({ label: 'Selecciona una opción', value: '' })
      setSelectJefeBySucursal(jefe)

      setSucursalGuardiasId(sucursal_id)
      setReloadGuardias((prev) => prev + 1)
    }
    if (name === 'litros' || name === 'costo_litro') {
      const litros =
        name === 'litros' ? toFloat(value) : toFloat(formData.litros) || 0
      const costoLitro =
        name === 'costo_litro'
          ? toFloat(value)
          : toFloat(formData.costo_litro) || 0

      const costoTotal = litros * costoLitro

      setFormData('costo_total', costoTotal)
    }

    if (['periodo_inicio', 'periodo_fin', 'guardia_id'].includes(name)) {
      const guardia_id =
        name === 'guardia_id' ? value.value : formData.guardia_id.value || null
      const fechaInicio =
        name === 'periodo_inicio' ? value : formData.periodo_inicio || null
      const fechaFin =
        name === 'periodo_fin' ? value : formData.periodo_fin || null

      if (guardia_id) {
        const data = await getGuardiaById(guardia_id)

        const sueldoBase = toFloat(data.sueldo_base)
        const imss = toFloat(data.imss)
        const infonavit = toFloat(data.infonavit)
        const fonacot = toFloat(data.fonacot)
        const retencionISR = toFloat(data.retencion_isr)

        setFormData('sueldo_base', sueldoBase.toFixed(2))
        setFormData('imss', imss.toFixed(2))
        setFormData('infonavit', infonavit.toFixed(2))
        setFormData('fonacot', fonacot.toFixed(2))
        setFormData('retencion_isr', retencionISR.toFixed(2))
      }

      if (fechaInicio && fechaFin) {
        if (dayjs(fechaInicio).isAfter(fechaFin)) {
          toast.warning(
            'El periodo de inicio no puede ser después del periodo de fin'
          )
          setFormData('periodo_fin', null)
          return
        }
      }

      if (guardia_id && fechaInicio && fechaFin) {
        const info = {
          guardia_id,
          fecha_inicio: fechaInicio,
          fecha_fin: fechaFin
        }

        const data = await getEstadoCuentaGuardia(info)

        // Ingresos
        const diasTrabajados = toFloat(data.ingresos.pago_dias_trabajados)
        const tiempoExtra = toFloat(data.ingresos.tiempo_extra)
        const primaVacacional = toFloat(data.ingresos.prima_vacacional)
        const incaPagada = toFloat(data.ingresos.incapacidades_pagadas)

        setFormData('dias_trabajados', diasTrabajados.toFixed(2))
        setFormData('tiempo_extra', tiempoExtra.toFixed(2))
        setFormData('prima_vacacional', primaVacacional.toFixed(2))
        setFormData('incapacidades_pagadas', incaPagada.toFixed(2))

        // Egresos
        const descuentos = toFloat(data.egresos.descuentos)
        const faltas = toFloat(data.egresos.faltas)
        const incaNoPagada = toFloat(data.egresos.incapacidades_no_pagadas)

        setFormData('descuentos', descuentos.toFixed(2))
        setFormData('faltas', faltas.toFixed(2))
        setFormData('incapacidades_no_pagadas', incaNoPagada.toFixed(2))

        // Totales
        const totalIngresos = toFloat(data.pagos.total_ingresos)
        const totalEgresos = toFloat(data.pagos.total_egresos)
        const totalRetenciones = toFloat(data.pagos.total_prestaciones)
        const pagoBruto = toFloat(data.pagos.pago_bruto)
        const pagoFinal = toFloat(data.pagos.pago_neto)

        setFormData('total_ingresos', totalIngresos.toFixed(2))
        setFormData('total_egresos', totalEgresos.toFixed(2))
        setFormData('total_retenciones', totalRetenciones.toFixed(2))
        setFormData('pago_bruto', pagoBruto.toFixed(2))
        setFormData('pago_final', pagoFinal.toFixed(2))
      }
    }

    if (
      ['sueldo_base', 'imss', 'infonavit', 'fonacot', 'retencion_isr'].includes(
        name
      )
    ) {
      const valor = toFloat(value)
      const imss = name === 'imss' ? valor : toFloat(formData.imss) || 0
      const infonavit =
        name === 'infonavit' ? valor : toFloat(formData.infonavit) || 0
      const fonacot =
        name === 'fonacot' ? valor : toFloat(formData.fonacot) || 0
      const retencionISR =
        name === 'retencion_isr' ? valor : toFloat(formData.retencion_isr) || 0

      const retenciones = imss + infonavit + fonacot + retencionISR
      setFormData('total_retenciones', retenciones.toFixed(2))

      const bruto = toFloat(formData.pago_bruto)
      const pagoFinal = bruto - retenciones
      setFormData('pago_final', pagoFinal.toFixed(2))
    }

    if (name === 'supervisor_id') {
      const nombre = value.nombre_completo
      const email = value.email
      const numeroEmpleado = value.numero_empleado

      setFormData('nombre_completo', nombre)
      setFormData('email', email)
      setFormData('password', numeroEmpleado)
    }

    if (
      ['/ordenes-compra', '/gastos'].includes(pathname) &&
      ['subtotal', 'descuento_monto', 'impuesto'].includes(name)
    ) {
      const newSubtotal = name === 'subtotal' ? value : formData.subtotal
      const newDescuento =
        name === 'descuento_monto' ? value : formData.descuento_monto
      const newImpuesto = name === 'impuesto' ? value : formData.impuesto

      const resultado = calcularTotalGastosCompras({
        subtotal: newSubtotal,
        descuento_monto: newDescuento,
        impuesto: newImpuesto
      })

      setFormData('total', resultado.total)
    }
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

  useEffect(() => {
    if ((edit || view) && currentItem && pathname === '/equipo') {
      // Campos generales
      setFormData('guardia_id', currentItem.guardia_id)
      setFormData('vehiculo_id', currentItem.vehiculo_id)
      setFormData('fecha_entrega', currentItem.fecha_entrega)
      setFormData('devuelto', currentItem.devuelto)
      setFormData('fecha_devuelto', currentItem.fecha_devuelto)
      setFormData('otro', currentItem.otro)

      // Equipamiento básico (checkboxes)
      setFormData('fornitura', currentItem.fornitura === 1)
      setFormData('celular', currentItem.celular === 1)
      setFormData('radio', currentItem.radio === 1)
      setFormData('garret', currentItem.garret === 1)
      setFormData('impermeable', currentItem.impermeable === 1)
      setFormData('botas', currentItem.botas === 1)
      setFormData('plumas', currentItem.plumas === 1)
      setFormData('caparas', currentItem.caparas === 1)
      setFormData('equipo_cpat', currentItem.equipo_cpat === 1)

      setInitialLoad(true)
    }
  }, [currentItem, edit, view])

  useEffect(() => {
    if (initialLoad && currentItem && pathname === '/equipo') {
      const loadInitialData = async () => {
        const nuevosDisponibles = {}

        for (const detalle of currentItem.detalles) {
          const checkboxKey = `articulo-${detalle.articulo.nombre}-${detalle.articulo.id}`
          const selectKey = `seleccionado-numero_serie-${detalle.articulo.id}`

          // 1. Primero establecer el seleccionado
          setFormData(checkboxKey, true)
          setFormData(selectKey, detalle.numero_serie)

          // 2. Cargar todos los disponibles (incluyendo el seleccionado)
          try {
            const disponibles = await getArtDis(detalle.articulo.id)

            // Asegurarnos que el seleccionado está incluido
            const seleccionadoExiste = disponibles.some(
              (item) => item.numero_serie === detalle.numero_serie
            )

            if (!seleccionadoExiste) {
              disponibles.push({ numero_serie: detalle.numero_serie })
            }

            nuevosDisponibles[checkboxKey] = disponibles
          } catch (err) {
            console.error(`Error al cargar artículos disponibles:`, err)
            nuevosDisponibles[checkboxKey] = [
              { numero_serie: detalle.numero_serie }
            ]
          }
        }

        setArticulosDisponibles((prev) => ({
          ...prev,
          ...nuevosDisponibles
        }))
      }

      loadInitialData()
      setInitialLoad(false)
    }
  }, [initialLoad])

  const handleNestedInputChange = (e) => {
    const { name, value } = e.target
    setNestedFormData(name, value)
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
    if (
      [
        '/sucursales-empresa',
        '/guardias',
        '/clientes',
        '/proveedores',
        '/sucursales',
        '/cotizaciones'
      ].includes(pathname)
    ) {
      setEstados(estadosData)
      setEstadosMunicipios(estadosMunicipiosData)

      if (add) {
        setFormData('pais', 'México')
      }
    }
  }, [add, pathname, setFormData])

  useEffect(() => {
    const estadoSeleccionado = formData.estado
    if (!estadoSeleccionado) {
      setMunicipios([])
      return
    }

    const municipiosEstado = estadosMunicipios[estadoSeleccionado]
    setMunicipios(
      municipiosEstado
        ? municipiosEstado.map((m) => ({ value: m, label: m }))
        : []
    )
  }, [formData.estado, estadosMunicipios])

  const opcionesEstados = [
    { value: '', label: 'Selecciona un estado' },
    ...estados.map((estado) => ({
      value: estado.nombre,
      label: estado.nombre
    }))
  ]

  const loadOptionsClientes = async (inputValue) => {
    try {
      if (!loadOptionsClientes.cachedData) {
        loadOptionsClientes.cachedData = await getCliente()
      }

      const filteredData = loadOptionsClientes.cachedData.filter((g) =>
        g.nombre_empresa.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre_empresa
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsBancos = async (inputValue) => {
    try {
      if (!loadOptionsBancos.cachedData) {
        loadOptionsBancos.cachedData = await getBanco()
      }

      const filteredData = loadOptionsBancos.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsProveedores = async (inputValue) => {
    try {
      if (!loadOptionsProveedores.cachedData) {
        loadOptionsProveedores.cachedData = await getProveedor()
      }

      const filteredData = loadOptionsProveedores.cachedData.filter((g) =>
        g.nombre_empresa.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre_empresa
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsArticulos = async (inputValue) => {
    try {
      if (!loadOptionsArticulos.cachedData) {
        loadOptionsArticulos.cachedData = await getArticulo()
      }

      const filteredData = loadOptionsArticulos.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsCotizaciones = async (inputValue) => {
    try {
      if (!loadOptionsCotizaciones.cachedData) {
        loadOptionsCotizaciones.cachedData = await getCotizacion()
      }

      const filteredData = loadOptionsCotizaciones.cachedData.filter((g) =>
        g.nombre_empresa.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre_empresa
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsVentas = async (inputValue) => {
    try {
      if (!loadOptionsVentas.cachedData) {
        loadOptionsVentas.cachedData = await getVentaOrdenServicio()
      }

      const filteredData = loadOptionsVentas.cachedData.filter(
        (data) =>
          data.nombre_empresa
            .toLowerCase()
            .includes(inputValue.toLowerCase()) ||
          data.numero_factura.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: `${data.nombre_empresa} (${data.numero_factura})`,
        direccion: data.direccion,
        jefe_turno: data.cotizacion.jefe_turno,
        supervisor: data.cotizacion.supervisor,
        fecha_servicio: data.fecha_servicio
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsModuloConcepto = async (inputValue) => {
    try {
      if (!loadOptionsModuloConcepto.cachedData) {
        loadOptionsModuloConcepto.cachedData = await getModuloConcepto()
      }

      const filteredData = loadOptionsModuloConcepto.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsModuloDescuento = async (inputValue) => {
    try {
      if (!loadOptionsModuloDescuento.cachedData) {
        loadOptionsModuloDescuento.cachedData = await getModuloDescuento()
      }

      const filteredData = loadOptionsModuloDescuento.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsModuloPrestamo = async (inputValue) => {
    try {
      if (!loadOptionsModuloPrestamo.cachedData) {
        loadOptionsModuloPrestamo.cachedData = await getModuloPrestamo()
      }

      const filteredData = loadOptionsModuloPrestamo.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsTodosGuardias = async (inputValue) => {
    try {
      if (!loadOptionsTodosGuardias.cachedData) {
        loadOptionsTodosGuardias.cachedData = await getGuardias()
      }

      const filteredData = loadOptionsTodosGuardias.cachedData.filter(
        (g) =>
          g.nombre_completo.toLowerCase().includes(inputValue.toLowerCase()) ||
          g.numero_empleado.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: `${data.nombre_completo} (${data.numero_empleado})`
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsSupervisores = async (inputValue) => {
    try {
      if (!loadOptionsSupervisores.cachedData) {
        loadOptionsSupervisores.cachedData = await getSupervisores()
      }

      const filteredData = loadOptionsSupervisores.cachedData.filter(
        (g) =>
          g.nombre_completo.toLowerCase().includes(inputValue.toLowerCase()) ||
          g.numero_empleado.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: `${data.nombre_completo} (${data.numero_empleado})`,
        numero_empleado: data.numero_empleado,
        email: data.correo,
        nombre_completo: data.nombre_completo
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsGuardiasBySucursal = async (inputValue) => {
    if (!sucursalGuardiasId) return []

    try {
      if (!loadOptionsGuardiasBySucursal.cachedData) {
        loadOptionsGuardiasBySucursal.cachedData = await getGuardiasBySucursal(
          sucursalGuardiasId
        )
      }

      const filteredData = loadOptionsGuardiasBySucursal.cachedData.filter(
        (g) =>
          g.nombre_completo.toLowerCase().includes(inputValue.toLowerCase()) ||
          g.numero_empleado.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((g) => ({
        value: g.id,
        label: `${g.nombre_completo} (${g.numero_empleado})`
      }))
    } catch (error) {
      console.error('Error al cargar guardias por sucursal:', error)
      return []
    }
  }

  const loadOptionsPrestamos = async (inputValue) => {
    try {
      if (!loadOptionsPrestamos.cachedData) {
        loadOptionsPrestamos.cachedData = await getPrestamoPendiente()
      }

      const filteredData = loadOptionsPrestamos.cachedData.filter(
        (data) =>
          data.nombre.toLowerCase().includes(inputValue.toLowerCase()) ||
          data.monto_total_format
            .toLowerCase()
            .includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: `${data.nombre} (${data.monto_total_format})`
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsSucursalesEmpresa = async (inputValue) => {
    try {
      if (!loadOptionsSucursalesEmpresa.cachedData) {
        loadOptionsSucursalesEmpresa.cachedData = await getSucursalEmpresa()
      }

      const filteredData = loadOptionsSucursalesEmpresa.cachedData.filter((g) =>
        g.nombre_sucursal.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre_sucursal
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsRoles = async (inputValue) => {
    try {
      if (!loadOptionsRoles.cachedData) {
        loadOptionsRoles.cachedData = await getRol()
      }

      const filteredData = loadOptionsRoles.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsModulos = async (inputValue) => {
    try {
      if (!loadOptionsModulos.cachedData) {
        loadOptionsModulos.cachedData = await getModulo()
      }

      const filteredData = loadOptionsModulos.cachedData.filter((g) =>
        g.nombre.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.nombre
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsVehiculos = async (inputValue) => {
    try {
      if (!loadOptionsVehiculos.cachedData) {
        loadOptionsVehiculos.cachedData = await getVehiculo()
      }

      const filteredData = loadOptionsVehiculos.cachedData.filter(
        (data) =>
          data.tipo_vehiculo.toLowerCase().includes(inputValue.toLowerCase()) ||
          data.placas.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: `${data.tipo_vehiculo} (${data.placas})`
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsOrdenServicio = async (inputValue) => {
    try {
      if (!loadOptionsOrdenServicio.cachedData) {
        loadOptionsOrdenServicio.cachedData = await getOrdenServicio()
      }

      const filteredData = loadOptionsOrdenServicio.cachedData.filter((g) =>
        g.codigo_orden_servicio.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData.map((data) => ({
        value: data.id,
        label: data.codigo_orden_servicio
      }))
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  useEffect(() => {
    if ((edit || view) && formData.cliente_id?.value) {
      const getSucursalesByCliente = async () => {
        await updateSucursalesByCliente(formData.cliente_id.value)
      }

      getSucursalesByCliente()
    }
  }, [edit, view])

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
    setNestedFormData,
    handleInputChange,
    handleFileChange,
    handleMultipleFilesChange,
    handleNestedInputChange,
    handleCheckboxChange,
    opcionesEstados,
    municipios,
    loadOptionsClientes,
    loadOptionsBancos,
    loadOptionsProveedores,
    loadOptionsArticulos,
    loadOptionsCotizaciones,
    loadOptionsVentas,
    loadOptionsTodosGuardias,
    loadOptionsRoles,
    loadOptionsModulos,
    loadOptionsModuloConcepto,
    loadOptionsPrestamos,
    loadOptionsSucursalesEmpresa,
    loadOptionsGuardiasBySucursal,
    loadOptionsModuloDescuento,
    loadOptionsModuloPrestamo,
    loadOptionsVehiculos,
    loadOptionsOrdenServicio,
    loadOptionsSupervisores,
    selectOptions,
    articulosDisponibles,
    selectSupervisorBySucursal,
    selectJefeBySucursal,
    reloadGuardias
  }
}
