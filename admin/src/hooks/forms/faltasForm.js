import { toFloat, toInt } from '../../utils/numbers'

export const faltasForm = ({ name, setFormData, value, formData }) => {
  if (name === 'cantidad_faltas' || name === 'descuento_falta') {
    const cantidad =
      name === 'cantidad_faltas'
        ? toInt(value)
        : toInt(formData.cantidad_faltas) || 0

    const descuento =
      name === 'descuento_falta'
        ? toFloat(value)
        : toFloat(formData.descuento_falta) || 0

    const descuentoTotal = cantidad * descuento

    setFormData('monto', descuentoTotal)
  }
}
