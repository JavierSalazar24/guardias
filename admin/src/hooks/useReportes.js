import * as XLSX from 'xlsx'
import { saveAs } from 'file-saver'
import { toast } from 'sonner'
import dayjs from 'dayjs'

import { useState } from 'react'
import { getBanco } from '../api/bancos'
import {
  getEstadoCuentaBanco,
  getEstadoCuentaCliente,
  getEstadoCuentaGuardia,
  getEstadoCuentaProveedor,
  getHorasTrabajadasGuardia,
  getReportRH,
  getReporte
} from '../api/reportes'
import { getProveedor } from '../api/proveedores'
import { getGuardias } from '../api/guardias'
import { getCliente } from '../api/clientes'
import { getVehiculo } from '../api/vehiculos'
import { formatearMonedaMXN } from '../utils/formattedCurrancy'

export const useReportes = () => {
  const [formReport, setFormReport] = useState({})
  const [estado, setEstado] = useState(null)

  const exportToExcel = (data, columns, sheetName, fileName) => {
    if (!data || data.length === 0) {
      toast.warning('No hay datos para exportar.')
      return
    }

    // Definir encabezados de la tabla
    const headers = [columns]

    // Crear hoja de Excel
    const worksheet = XLSX.utils.json_to_sheet(data)

    // Agregar los encabezados
    XLSX.utils.sheet_add_aoa(worksheet, headers, { origin: 'A1' })

    // 📌 Ajustar el ancho de las columnas al tamaño del texto
    worksheet['!cols'] = columns.map((col) => ({ wch: col.length + 5 })) // Ajusta el ancho sumando 5 caracteres extra

    // Crear libro de Excel y añadir la hoja
    const workbook = XLSX.utils.book_new()
    XLSX.utils.book_append_sheet(workbook, worksheet, sheetName)

    // Generar el archivo Excel
    const excelBuffer = XLSX.write(workbook, {
      bookType: 'xlsx',
      type: 'array'
    })

    // Guardar el archivo
    const dataBlob = new Blob([excelBuffer], {
      type: 'application/octet-stream'
    })
    saveAs(dataBlob, fileName)
  }

  const handleInputChange = async (e, actionMeta) => {
    let name, value

    if (e.target) {
      ;({ name, value } = e.target)
    } else {
      name = actionMeta.name
      value = e || []
    }

    setFormReport((prevState) => ({
      ...prevState,
      [name]: value
    }))
  }

  const loadOptionsBancos = async (inputValue) => {
    try {
      if (!loadOptionsBancos.cachedData) {
        const response = await getBanco()
        const data = response.map((info) => ({
          value: info.id,
          label: info.nombre
        }))

        if (data.length > 0) data.unshift({ label: 'Todos', value: 'todos' })

        loadOptionsBancos.cachedData = data
      }

      if (!inputValue) return loadOptionsBancos.cachedData

      const filteredData = loadOptionsBancos.cachedData.filter((item) =>
        item.label.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsProveedores = async (inputValue) => {
    try {
      if (!loadOptionsProveedores.cachedData) {
        const response = await getProveedor()
        const data = response.map((info) => ({
          value: info.id,
          label: info.nombre_empresa
        }))

        if (data.length > 0) data.unshift({ label: 'Todos', value: 'todos' })

        loadOptionsProveedores.cachedData = data
      }

      if (!inputValue) return loadOptionsProveedores.cachedData

      const filteredData = loadOptionsProveedores.cachedData.filter((item) =>
        item.label.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsGuardias = async (inputValue) => {
    try {
      if (!loadOptionsGuardias.cachedData) {
        loadOptionsGuardias.cachedData = await getGuardias()
      }

      const filteredData = loadOptionsGuardias.cachedData.filter(
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

  const loadOptionsGuardiasTodos = async (inputValue) => {
    try {
      if (!loadOptionsGuardiasTodos.cachedData) {
        const response = await getGuardias()
        const data = response.map((data) => ({
          value: data.id,
          label: data.nombre_completo
        }))

        if (data.length > 0) data.unshift({ label: 'Todos', value: 'todos' })

        loadOptionsGuardiasTodos.cachedData = data
      }

      if (!inputValue) return loadOptionsGuardiasTodos.cachedData

      const filteredData = loadOptionsGuardiasTodos.cachedData.filter((item) =>
        item.label.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const loadOptionsProveedoresUnico = async (inputValue) => {
    try {
      if (!loadOptionsProveedoresUnico.cachedData) {
        loadOptionsProveedoresUnico.cachedData = await getProveedor()
      }

      const filteredData = loadOptionsProveedoresUnico.cachedData.filter((g) =>
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

  const loadOptionsBancosUnico = async (inputValue) => {
    try {
      if (!loadOptionsBancosUnico.cachedData) {
        loadOptionsBancosUnico.cachedData = await getBanco()
      }

      const filteredData = loadOptionsBancosUnico.cachedData.filter((g) =>
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

  const loadOptionsVehiculos = async (inputValue) => {
    try {
      if (!loadOptionsVehiculos.cachedData) {
        const response = await getVehiculo()
        const data = response.map((data) => ({
          value: data.id,
          label: `${data.tipo_vehiculo} - ${data.marca} ${data.modelo} (${data.placas})`
        }))

        if (data.length > 0) data.unshift({ label: 'Todos', value: 'todos' })

        loadOptionsVehiculos.cachedData = data
      }

      if (!inputValue) return loadOptionsVehiculos.cachedData

      const filteredData = loadOptionsVehiculos.cachedData.filter((item) =>
        item.label.toLowerCase().includes(inputValue.toLowerCase())
      )

      return filteredData
    } catch (error) {
      console.error('Error cargando datos:', error)
      return []
    }
  }

  const generateReport = async (form) => {
    try {
      const response = await getReporte(form)

      // Mapeo de módulos a funciones de transformación
      const dataTransformers = {
        movimientos: transformMovimientData,
        'orden-compra': transformOrderData,
        compras: transformPayData,
        gastos: transformExpenseData,
        ventas: transformSalesData,
        almacen: transformInventoryData,
        equipo: transformEquipmentData,
        'boletas-gasolina': transformBoletasGasolina
      }

      // Configuraciones de reporte por módulo
      const reportConfigs = {
        movimientos: {
          filename: 'Reporte de movimientos de banco',
          headers: [
            'Banco',
            'Tipo de movimiento',
            'Concepto',
            'Fecha del movimiento',
            'Referencia',
            'Método de pago',
            'Monto'
          ]
        },
        'orden-compra': {
          filename: 'Reporte de órdenes de compra',
          headers: [
            'Banco',
            'Proveedor',
            'Artículo',
            'Cantidad de artículos',
            'Precio x artículo',
            'Número de OC',
            'Total',
            'Estatus'
          ]
        },
        compras: {
          filename: 'Reporte de compras',
          headers: [
            'Banco',
            'Proveedor',
            'Artículo',
            'Cantidad de artículos',
            'Precio x artículo',
            'Número de OC',
            'Total',
            'Método de pago',
            'Referencia'
          ]
        },
        gastos: {
          filename: 'Reporte de gastos',
          headers: ['Banco', 'Concepto', 'Método de pago', 'Total']
        },
        ventas: {
          filename: 'Reporte de ventas',
          headers: [
            'Nombre de empresa',
            'Número de factura',
            'Tipo de pago',
            'Método de pago',
            'Nota de crédito',
            'Fecha de cotización aceptada',
            'Fecha de vencimiento',
            'Estatus',
            'Motivo de cancelación',
            'Total'
          ]
        },
        almacen: {
          filename: 'Reporte de almacén',
          headers: [
            'Artículo',
            'Número de serie',
            'Fecha de entrada',
            'Fecha de salida',
            'Estatus',
            'Otra información'
          ]
        },
        equipo: {
          filename: 'Reporte de equipamiento',
          headers: [
            'Guardia',
            'Fecha de entrega',
            'Fecha de devolución',
            '¿Ya se regresó el equipo?',
            'Equipo asignado',
            'Otro'
          ]
        },
        'boletas-gasolina': {
          filename: 'Reporte de boletas de gasolina',
          headers: [
            'Vehículo',
            'Kilometraje',
            'Litros',
            'Costo por litro',
            'Costo total',
            'Método de pago',
            'Referencia',
            'Observaciones',
            'Fecha'
          ]
        }
      }

      // Transformar datos según el módulo
      const transformer = dataTransformers[form.modulo] || (() => [])
      const data = response.map(transformer)

      // Obtener configuración del reporte
      const config = reportConfigs[form.modulo] || {}

      // Generar nombre de archivo con fecha
      const filename = `${config.filename} ${dayjs().format('DD-MM-YYYY')}.xlsx`

      // Exportar a Excel
      exportToExcel(data, config.headers, config.filename, filename)
    } catch (error) {
      toast.warning(error.message)
      console.error('Error generating report:', error)
    }
  }

  const generateReportCartera = async (form) => {
    const data = form.map((info) => ({
      cliente: info.cliente,
      sucursal: info.sucursal,
      numero_factura: info.numero_factura,
      nota_credito: info.nota_credito,
      fecha_emision: dayjs(info.fecha_emision).format('DD/MM/YYYY'),
      fecha_vencimiento_format: info.fecha_vencimiento_format,
      atraso: info.atraso,
      total_format: info.total_format,
      estatus: info.estatus
    }))

    const headers = [
      'Cliente',
      'Sucursal',
      'Número de factura',
      'Nota de crédito',
      'Fecha de cotización aceptada',
      'Fecha de vencimiento',
      'Días de atraso',
      'Total',
      'Estatus'
    ]

    const filename = `Reporte de cartera vencida ${dayjs().format(
      'DD-MM-YYYY'
    )}.xlsx`
    exportToExcel(data, headers, 'Reporte de cartera vencida', filename)

    // const newData =
  }

  const generateReportRH = async (form) => {
    const response = await getReportRH(form)

    const dataTransformers = {
      incapacidades: transformIncapacidades,
      'tiempo-extra': transformTiempoExtra,
      faltas: transformFaltas,
      descuentos: transformDescuentos,
      vacaciones: transformVacaciones,
      prestamos: transformPrestamos
    }

    // Configuraciones de reporte por módulo
    const reportConfigs = {
      incapacidades: {
        filename: 'Reporte de incapacidades',
        headers: [
          'Guardia',
          'Inicio de incapacidad',
          'Fin de incapacidad',
          'Pago por parte de la empresa',
          'Motivo',
          'Observaciones'
        ]
      },
      'tiempo-extra': {
        filename: 'Reporte de tiempo extra',
        headers: [
          'Guardia',
          'Inicio del período de tiempo extra',
          'Fin del período de tiempo extra',
          'Horas extras trabajadas',
          'Pago por hora',
          'Pago total'
        ]
      },
      faltas: {
        filename: 'Reporte de faltas',
        headers: [
          'Guardia',
          'Inicio del período de faltas',
          'Fin del período de faltas',
          'Cantidad de faltas',
          'Descuento x falta',
          'Monto total descontado'
        ]
      },
      descuentos: {
        filename: 'Reporte de descuentos',
        headers: [
          'Guardia',
          'Mótivo del descuento',
          'Monto del descuento',
          'Fecha del descuento',
          'Observaciones'
        ]
      },
      vacaciones: {
        filename: 'Reporte de vacaciones',
        headers: [
          'Guardia',
          'Inicio de vacaciones',
          'Fin de vacaciones',
          'Días totales de vacaciones',
          'Prima vacacional',
          'Obvservaciones'
        ]
      },
      prestamos: {
        filename: 'Reporte de préstamo',
        headers: [
          'Guardia',
          'Monto del préstamo',
          'Saldo restante del préstamo',
          'Número de pagos acordados',
          'Abonos pagados',
          'Fecha del préstamo',
          'Motivo',
          'Obvservaciones',
          'Estatus',
          'Fecha del préstamo liquidado'
        ]
      }
    }

    // Transformar datos según el módulo
    const transformer = dataTransformers[form.modulo] || (() => [])
    const data = response.map(transformer)

    // Obtener configuración del reporte
    const config = reportConfigs[form.modulo] || {}

    // Generar nombre de archivo con fecha
    const filename = `${config.filename} ${dayjs().format('DD-MM-YYYY')}.xlsx`

    // Exportar a Excel
    exportToExcel(data, config.headers, config.filename, filename)
  }

  const generateEstadoCuentaGuardia = async (form) => {
    const data = await getEstadoCuentaGuardia(form)
    setEstado(data)
  }

  const generateHorasTrabajadasGuardia = async (form) => {
    const data = await getHorasTrabajadasGuardia(form)
    setEstado(data)
  }

  const generateEstadoCuentaCliente = async (form) => {
    const data = await getEstadoCuentaCliente(form)
    setEstado(data)
  }

  const generateEstadoCuentaProveedor = async (form) => {
    const data = await getEstadoCuentaProveedor(form)
    setEstado(data)
  }

  const generateEstadoCuentaBanco = async (form) => {
    const data = await getEstadoCuentaBanco(form)
    setEstado(data)
  }

  // Funciones de transformación específicas por módulo para RH
  function transformIncapacidades(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      inicio_incapacidad: formatDate(res.fecha_inicio),
      fin_incapacidad: formatDate(res.fecha_fin),
      pago_empresa: formatCurrency(res.pago_empresa),
      motivo: res.motivo,
      observaciones: res.observaciones
    }
  }

  function transformTiempoExtra(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      inicio_periodo: formatDate(res.fecha_inicio),
      fin_periodo: formatDate(res.fecha_fin),
      horas: res.horas,
      monto_por_hora: formatCurrency(res.monto_por_hora),
      monto_total: formatCurrency(res.monto_total)
    }
  }

  function transformFaltas(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      inicio_periodo: formatDate(res.fecha_inicio),
      fin_periodo: formatDate(res.fecha_fin),
      cantidad_faltas: res.cantidad_faltas,
      descuento_falta: formatCurrency(res.descuento_falta),
      monto: formatCurrency(res.monto)
    }
  }

  function transformDescuentos(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      motivo: res.modulo_descuento.nombre,
      monto: formatCurrency(res.monto),
      fecha: formatDate(res.fecha),
      observaciones: res.observaciones
    }
  }

  function transformVacaciones(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      inicio_periodo: formatDate(res.fecha_inicio),
      fin_periodo: formatDate(res.fecha_fin),
      dias_totales: res.dias_totales,
      prima_vacacional: formatCurrency(res.prima_vacacional),
      observaciones: res.observaciones
    }
  }

  function transformPrestamos(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      monto_total: formatCurrency(res.monto_total),
      saldo_restante: formatCurrency(res.saldo_restante),
      numero_pagos: res.numero_pagos,
      abonos_pagados: `${res.abonos.length}/${res.numero_pagos}`,
      fecha_prestamo: formatDate(res.fecha_prestamo),
      motivo: res.modulo_prestamo.nombre,
      observaciones: res.observaciones,
      estatus: res.estatus,
      fecha_pagado: formatDate(res.fecha_pagado)
    }
  }

  // Funciones de transformación específicas por módulo
  function transformMovimientData(res) {
    return {
      banco: res.banco.nombre,
      tipo_movimiento: res.tipo_movimiento,
      concepto: res.concepto,
      fecha: formatDate(res.fecha),
      referencia: res.referencia || 'N/A',
      metodo_pago: res.metodo_pago,
      monto: formatCurrency(res.monto)
    }
  }

  function transformOrderData(res) {
    return {
      banco: res.banco.nombre,
      proveedor: res.proveedor.nombre_empresa,
      articulo: res.articulo.nombre,
      cantidad_articulo: res.cantidad_articulo,
      precio_articulo: formatCurrency(res.precio_articulo),
      numero_oc: res.numero_oc,
      total: formatCurrency(res.total),
      estatus: res.estatus
    }
  }

  function transformPayData(res) {
    return {
      banco: res.orden_compra.banco.nombre,
      proveedor: res.orden_compra.proveedor.nombre_empresa,
      articulo: res.orden_compra.articulo.nombre,
      cantidad_articulo: res.orden_compra.cantidad_articulo,
      precio_articulo: formatCurrency(res.orden_compra.precio_articulo),
      numero_oc: res.orden_compra.numero_oc,
      total: formatCurrency(res.orden_compra.total),
      metodo_pago: res.metodo_pago,
      referencia: res.referencia || 'N/A'
    }
  }

  function transformExpenseData(res) {
    return {
      banco: res.banco.nombre,
      concepto: res.modulo_concepto.nombre,
      metodo_pago: res.metodo_pago,
      total: formatCurrency(res.total)
    }
  }

  function transformSalesData(res) {
    const nombre_empresa =
      res?.cotizacion?.sucursal?.nombre_empresa ||
      res?.cotizacion?.nombre_empresa ||
      'N/A'

    const fecha_vencimiento =
      res.tipo_pago === 'Contado' ? 'N/A' : formatDate(res.fecha_vencimiento)

    return {
      nombre_empresa,
      numero_factura: res.numero_factura,
      tipo_pago: res.tipo_pago,
      metodo_pago: res.metodo_pago,
      nota_credito: res.nota_credito,
      fecha_emision: formatDate(res.fecha_emision),
      fecha_vencimiento,
      estatus: res.estatus,
      motivo_cancelada: res.motivo_cancelada || 'N/A',
      total: formatCurrency(res.total)
    }
  }

  function transformInventoryData(res) {
    return {
      articulo: res.articulo.nombre,
      numero_serie: res.numero_serie,
      fecha_entrada: formatDate(res.fecha_entrada, 'Sin entrada a almacén'),
      fecha_salida: formatDate(res.fecha_salida, 'Sin salida de almacén'),
      estado: res.estado,
      otra_informacion: res.otra_informacion || 'N/A'
    }
  }

  function transformEquipmentData(res) {
    return {
      guardia: formatGuardianName(res.guardia),
      fecha_entrega: formatDate(res.fecha_entrega),
      fecha_devuelto: formatDate(res.fecha_devuelto, 'Sin devolver'),
      devuelto: res.devuelto,
      equipo_asignado: formatAssignedEquipment(res.detalles)
    }
  }

  function transformBoletasGasolina(res) {
    return {
      vehiculo: `${res.vehiculo.tipo_vehiculo} (${res.vehiculo.placas})`,
      kilometraje: res.kilometraje,
      litros: res.litros,
      costo_litro: formatearMonedaMXN(res.costo_litro),
      costo_total: formatearMonedaMXN(res.costo_total),
      metodo_pago: res.metodo_pago,
      referencia: res?.referencia || 'N/A',
      observaciones: res.observaciones,
      fecha: formatDate(res.created_at)
    }
  }

  // Funciones utilitarias
  function formatCurrency(amount) {
    return `$${amount}`
  }

  function formatDate(date, fallback = 'N/A') {
    return date ? dayjs(date).format('DD/MM/YYYY') : fallback
  }

  function formatGuardianName(guardian) {
    if (!guardian) return 'N/A'
    return `${guardian.nombre} ${guardian.apellido_p} ${guardian.apellido_m}`.trim()
  }

  function formatAssignedEquipment(details) {
    if (!details || !details.length) return 'Ningún equipo asignado'
    return details
      .map((d) => `${d.articulo.nombre} (${d.numero_serie})`)
      .join(', ')
  }

  return {
    formReport,
    estado,
    handleInputChange,
    loadOptionsBancos,
    loadOptionsProveedores,
    loadOptionsGuardias,
    loadOptionsGuardiasTodos,
    loadOptionsClientes,
    loadOptionsProveedoresUnico,
    loadOptionsBancosUnico,
    loadOptionsVehiculos,
    generateReport,
    generateReportCartera,
    generateReportRH,
    generateEstadoCuentaGuardia,
    generateEstadoCuentaCliente,
    generateEstadoCuentaProveedor,
    generateEstadoCuentaBanco,
    generateHorasTrabajadasGuardia
  }
}
