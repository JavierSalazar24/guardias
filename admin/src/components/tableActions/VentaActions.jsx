import { Ban } from 'lucide-react'

export const VentaActions = ({ data, openModal }) => {
  if (data.estatus === 'Cancelada' || data.estatus === 'Pagada') return null
  return (
    <button
      title='Cancelar venta'
      onClick={() => openModal('cancelar', data)}
      className='text-orange-600 hover:text-orange-900 p-1 rounded-md hover:bg-red-50 cursor-pointer transition-all'
    >
      <Ban className='h-5 w-5' />
    </button>
  )
}
