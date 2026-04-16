// Función para determinar el turno actual
export function getCurrentShift() {
  const hour = new Date().getHours()

  if (hour >= 6 && hour < 14) {
    return {
      name: 'Matutino',
      start: 6,
      end: 14,
      color: 'text-green-500',
      bgColor: 'bg-green-500/10',
      borderColor: 'border-green-500/30',
      bgClock: 'bg-green-400/20'
    }
  } else if (hour >= 14 && hour < 22) {
    return {
      name: 'Vespertino',
      start: 14,
      end: 22,
      color: 'text-amber-500',
      bgColor: 'bg-amber-500/10',
      borderColor: 'border-amber-500/30',
      bgClock: 'bg-amber-400/20'
    }
  } else {
    return {
      name: 'Nocturno',
      start: 22,
      end: 6,
      color: 'text-blue-500',
      bgColor: 'bg-blue-500/10',
      borderColor: 'border-blue-500/30',
      bgClock: 'bg-blue-400/20'
    }
  }
}
