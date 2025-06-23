import { Printer } from 'lucide-react'

export const BotonImprimir = ({ title = 'Ver reporte', href }) => {
  return (
    <a
      title={title}
      href={href}
      target='_blank'
      className='text-yellow-600 hover:text-yellow-900 p-1 rounded-md hover:bg-red-50 cursor-pointer transition-all'
    >
      <Printer className='h-5 w-5' />
    </a>
  )
}
