import { LockOpen } from 'lucide-react'

export const BlacklistActions = ({ data, openModal }) => {
  return (
    <button
      title='Quitar de la lista negra'
      onClick={() => openModal('whitelist', data)}
      className='text-yellow-600 hover:text-yellow-900 p-1 rounded-md hover:bg-yellow-50 cursor-pointer transition-all'
    >
      <LockOpen className='h-5 w-5' />
    </button>
  )
}
