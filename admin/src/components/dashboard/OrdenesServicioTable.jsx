import { Link } from 'react-router'
import dayjs from 'dayjs'
import { formatearMonedaMXN } from '../../utils/formattedCurrancy'
import { getStatusBadge } from './getStatusBadge'

export function OrdenesServicioTable({ ordenesServicio }) {
  return (
    <div className='bg-white border border-gray-200 shadow-md rounded-xl overflow-hidden'>
      <div className='p-5 border-b border-gray-200'>
        <div className='flex flex-wrap items-center justify-between'>
          <div>
            <h3 className='text-lg font-semibold text-gray-900'>
              Órdenes de servicio
            </h3>
            <p className='text-sm text-gray-500'>
              Servicios activos y finalizados
            </p>
          </div>
          <Link
            to='/orden-servicio'
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
                OS / Cliente
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Servicio
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Guardias
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Inicio
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Estado
              </th>
              <th className='px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>
                Valor
              </th>
            </tr>
          </thead>
          <tbody className='divide-y divide-gray-200'>
            {ordenesServicio.length === 0 ? (
              <tr>
                <td
                  colSpan='6'
                  className='text-center text-gray-400 text-lg font-medium py-4'
                >
                  No se encontraron registros.
                </td>
              </tr>
            ) : (
              ordenesServicio.map((order) => (
                <tr
                  key={order.id}
                  className='hover:bg-gray-200 transition-colors'
                >
                  <td className='px-4 py-3 text-center'>
                    <div>
                      <p className='text-sm font-mono text-success uppercase'>
                        {order.id}
                      </p>
                      <p className='text-sm text-gray-700'>{order.cliente}</p>
                    </div>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <span className='text-sm text-gray-700'>
                      {order.servicio}
                    </span>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <span className='text-sm text-gray-700'>
                      {order.guardias}
                    </span>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <span className='text-sm text-gray-700'>
                      {dayjs(order.inicio).format('DD/MM/YYYY')}
                    </span>
                  </td>
                  <td className='px-4 py-3 text-center'>
                    {getStatusBadge(order.estado)}
                  </td>
                  <td className='px-4 py-3 text-center'>
                    <span className='text-sm font-bold text-green-600'>
                      {formatearMonedaMXN(order.valor)}
                    </span>
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
            Mostrando los últimos {ordenesServicio.length} registro
            {ordenesServicio.length === 1 ? '' : 's'}
          </span>
        </div>
      </div>
    </div>
  )
}
