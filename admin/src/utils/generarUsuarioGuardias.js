export function generarUsuarioGuardias(nombreCompleto, rango) {
  const rangos = {
    guardia: 'gs',
    supervisor: 'sp',
    'jefe de turno': 'jp'
  }

  const siglasRango = rangos[rango.toLowerCase()] || 'xx'
  const codigoRandom = String(Math.floor(Math.random() * 10000)).padStart(
    4,
    '0'
  )

  const palabras = nombreCompleto.trim().split(/\s+/)
  const iniciales = palabras.map((p) => p[0].toLowerCase()).join('')

  return `${siglasRango}-${codigoRandom}-${iniciales}`
}
