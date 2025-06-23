export const tienePermiso = (user, moduloNombre, accion = 'consultar') => {
  return user?.rol?.permisos?.some(
    (permiso) =>
      permiso?.modulo?.nombre === moduloNombre && permiso?.[accion] === 1
  )
}
