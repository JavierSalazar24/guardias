import { toast } from 'sonner'

export const equipoForm = async ({
  name,
  value,
  checked,
  setArticulosDisponibles,
  setFormData,
  getArtDis
}) => {
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
