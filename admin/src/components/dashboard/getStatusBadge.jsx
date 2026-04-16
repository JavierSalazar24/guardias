import { Ban, CheckCircle, Clock } from 'lucide-react'

export const getStatusBadge = (estado) => {
  const styles = {
    'En proceso': 'bg-info/20 text-info border-info/30',
    Finalizada: 'bg-success/20 text-success border-success/30',
    Cancelada: 'bg-warning-dark/20 text-warning-dark border-warning-dark/30'
  }
  const icons = {
    'En proceso': Clock,
    Finalizada: CheckCircle,
    Cancelada: Ban
  }

  const Icon = icons[estado]

  return (
    <span
      className={`inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium border ${styles[estado]}`}
    >
      <Icon className='w-3 h-3' />
      {estado}
    </span>
  )
}
