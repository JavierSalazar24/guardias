import { ShieldOff } from 'lucide-react'

export const GuardiaActions = ({ data, openModal }) => {
  return (
    <button
      title='Mandar a lista negra'
      onClick={() => openModal('blacklist', data)}
      className='text-orange-600 hover:text-orange-900 p-1 rounded-md hover:bg-orange-50 cursor-pointer transition-all'
    >
      <ShieldOff className='h-5 w-5' />
    </button>
  )
}
