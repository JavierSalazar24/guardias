export const calcularEdad = (fechaNacimiento) => {
  if (!fechaNacimiento) return null

  const [year, month, day] = fechaNacimiento.split('-').map(Number)
  const hoy = new Date()
  const nacimiento = new Date(year, month - 1, day)

  let edad = hoy.getFullYear() - nacimiento.getFullYear()

  if (
    hoy.getMonth() < nacimiento.getMonth() ||
    (hoy.getMonth() === nacimiento.getMonth() &&
      hoy.getDate() < nacimiento.getDate())
  ) {
    edad--
  }

  return edad
}
