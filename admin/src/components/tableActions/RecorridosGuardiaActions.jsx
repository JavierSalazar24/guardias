import { Image } from 'lucide-react'

export const RecorridosGuardiaActions = ({ data }) => {
  return data.foto ? (
    <a
      title='Ver foto'
      href={data.foto_recorrido_url}
      target='_blank'
      className='text-yellow-600 hover:text-yellow-900 p-1 rounded-md hover:bg-red-50 cursor-pointer transition-all'
      rel='noopener noreferrer'
    >
      <Image className='h-5 w-5' />
    </a>
  ) : (
    <p className='text-xs text-primary font-semibold'>No hay foto disponible</p>
  )
}
