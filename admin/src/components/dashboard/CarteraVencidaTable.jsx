import { AlertCircle, Phone, Mail } from 'lucide-react'
import { Link } from 'react-router'
import { formatearMonedaMXN } from '../../utils/formattedCurrancy'
import { getRiskBadge } from './getRiskBadge'
import dayjs from 'dayjs'

export function CarteraVencidaTable({ carteraVencida, total }) {
  return (
    <div className='bg-white border border-gray-200 shadow-md rounded-xl overflow-hidden'>
      <div className='p-5 border-b border-gray-200'>
        <div className='flex flex-wrap items-center justify-between'>
          <div>
            <h3 className='text-lg font-semibold text-gray-900 flex items-center gap-2'>
              <AlertCircle className='w-5 h-5 text-red-400' />
              Cartera vencida
            </h3>
            <p className='text-sm text-gray-500'>
              Clientes con pagos pendientes
            </p>
          </div>
          <Link
            to='/cartera-vencida'
            className='mt-4 sm:mt-0 text-center px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-md text-sm text-white font-medium transition-colors'
          >
            Ver todos los registros
          </Link>
        </div>
      </div>

      <div className='overflow-x-auto max-h-96'>
        <table className='w-full'>
          <thead className='sticky z-0 top-0 bg-white'>
            <tr className='bg-gray-100'>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Cliente
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Monto
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Días Vencido
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Riesgo
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Contacto
              </th>
            </tr>
          </thead>
          <tbody className='divide-y divide-gray-200'>
            {carteraVencida.length === 0 ? (
              <tr>
                <td
                  colSpan='5'
                  className='text-center text-gray-400 text-lg font-medium py-4'
                >
                  No se encontraron registros.
                </td>
              </tr>
            ) : (
              carteraVencida.map((item) => (
                <tr
                  key={item.id}
                  className='hover:bg-gray-200 transition-colors'
                >
                  <td className='px-4 py-3 text-center'>
                    <div>
                      <p className='text-sm font-medium text-gray-600'>
                        {item.cliente}
                      </p>
                      <p className='text-xs text-gray-500'>
                        Fecha vencimiento:{' '}
                        {dayjs(item.fechaVencimiento).format('DD/MM/YYYY')}
                      </p>
                    </div>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <span className='text-sm font-semibold text-red-400'>
                      {formatearMonedaMXN(item.monto)}
                    </span>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <span className='text-sm text-gray-700'>
                      {item.diasVencido} días
                    </span>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    {getRiskBadge(item.riesgo)}
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <div className='flex items-center gap-2 justify-center'>
                      <a
                        href={`tel:${item.telefono}`}
                        target='_blank'
                        className='p-1.5 text-gray-400 hover:text-teal-400 hover:bg-teal-500/10 rounded-lg transition-colors'
                        title='Llamar'
                      >
                        <Phone className='w-4 h-4' />
                      </a>
                      <a
                        href={`mailto:${item.correo}`}
                        target='_blank'
                        className='p-1.5 text-gray-400 hover:text-teal-400 hover:bg-teal-500/10 rounded-lg transition-colors'
                        title='Enviar correo'
                      >
                        <Mail className='w-4 h-4' />
                      </a>
                    </div>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>

      <div className='p-4 border-t border-gray-200 bg-white'>
        <div className='flex items-center justify-between'>
          <span className='text-sm text-gray-500'>
            Total cartera vencida:{' '}
            <span className='text-red-400 font-semibold'>
              {formatearMonedaMXN(total)}
            </span>
          </span>
        </div>
      </div>
    </div>
  )
}
