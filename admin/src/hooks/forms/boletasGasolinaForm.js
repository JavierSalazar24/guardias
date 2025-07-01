import { toFloat } from '../../utils/numbers'

export const boletasGasolinaForm = ({ name, setFormData, value, formData }) => {
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
}
