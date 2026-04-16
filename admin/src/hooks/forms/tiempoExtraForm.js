import { toFloat, toInt } from '../../utils/numbers'

export const tiempoExtraForm = ({ name, setFormData, value, formData }) => {
  if (name === 'monto_por_hora' || name === 'horas') {
    const valor = name === 'monto_por_hora' ? toFloat(value) : toInt(value)

    const monto =
      name === 'monto_por_hora' ? valor : formData.monto_por_hora || 0
    const horas = name === 'horas' ? valor : formData.horas || 0

    const monto_total = monto * horas

    setFormData('monto_total', monto_total)
  }
}
