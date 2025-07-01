import dayjs from 'dayjs'
import { getGuardiaById } from '../../api/guardias'
import { toFloat } from '../../utils/numbers'
import { toast } from 'sonner'
import { getEstadoCuentaGuardia } from '../../api/reportes'

export const pagosEmpleadosForm = async ({
  name,
  setFormData,
  value,
  formData
}) => {
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
    const fonacot = name === 'fonacot' ? valor : toFloat(formData.fonacot) || 0
    const retencionISR =
      name === 'retencion_isr' ? valor : toFloat(formData.retencion_isr) || 0

    const retenciones = imss + infonavit + fonacot + retencionISR
    setFormData('total_retenciones', retenciones.toFixed(2))

    const bruto = toFloat(formData.pago_bruto)
    const pagoFinal = bruto - retenciones
    setFormData('pago_final', pagoFinal.toFixed(2))
  }
}
