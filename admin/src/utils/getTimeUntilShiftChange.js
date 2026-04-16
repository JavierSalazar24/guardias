// Función para calcular tiempo restante hasta cambio de turno
export function getTimeUntilShiftChange(shift) {
  const now = new Date()
  const currentHour = now.getHours()
  const currentMinute = now.getMinutes()
  const currentSecond = now.getSeconds()

  let endHour = shift.end
  if (shift.name === 'Nocturno' && currentHour >= 19) {
    endHour = 24 + 7 // Next day 7 AM
  } else if (shift.name === 'Nocturno' && currentHour < 7) {
    endHour = 7
  }

  const totalSecondsLeft =
    (endHour - currentHour - 1) * 3600 +
    (60 - currentMinute - 1) * 60 +
    (60 - currentSecond)
  const hours = Math.floor(totalSecondsLeft / 3600)
  const minutes = Math.floor((totalSecondsLeft % 3600) / 60)
  const seconds = totalSecondsLeft % 60

  return { hours, minutes, seconds }
}
