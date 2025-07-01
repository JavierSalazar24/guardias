export const usuariosForm = ({ name, setFormData, value }) => {
  if (name === 'supervisor_id') {
    const nombre = value.nombre_completo
    const email = value.email
    const numeroEmpleado = value.numero_empleado

    setFormData('nombre_completo', nombre)
    setFormData('email', email)
    setFormData('password', numeroEmpleado)
  }
}
