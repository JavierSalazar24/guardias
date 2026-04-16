import { Package } from 'lucide-react'
import { Link } from 'react-router'

export const InventarioPanel = ({ inventarioAlerta }) => {
  return (
    <div className='bg-white border border-gray-200 shadow-md rounded-xl overflow-hidden'>
      <div className='p-4 border-b border-gray-200'>
        <h3 className='text-lg font-semibold text-gray-900 flex items-center gap-2'>
          <Package className='w-5 h-5 text-amber-400' />
          Inventario
        </h3>
      </div>

      <div className='p-4 space-y-3 max-h-72 overflow-y-auto'>
        {inventarioAlerta.length === 0 ? (
          <p className='text-center text-gray-400 text-lg font-medium'>
            No se encontraron registros.
          </p>
        ) : (
          inventarioAlerta.map((item, index) => (
            <div key={index} className='flex items-end justify-between'>
              <div className='flex-1'>
                <p className='text-sm text-gray-600'>{item.item}</p>
                <div className='flex items-center gap-2 mt-1'>
                  <div className='flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden'>
                    <div
                      className={`h-full rounded-full ${
                        item.status === 'critico'
                          ? 'bg-red-500'
                          : 'bg-amber-500'
                      }`}
                      style={{ width: `${(item.stock / item.min) * 100}%` }}
                    ></div>
                  </div>
                  <span className='text-xs text-gray-500'>
                    {item.stock}/{item.min}
                  </span>
                </div>
              </div>
              <span
                className={`ml-3 px-2 py-0.5 rounded text-xs font-medium ${
                  item.status === 'critico'
                    ? 'bg-danger/20 text-danger'
                    : 'bg-warning-dark/20 text-warning-dark'
                }`}
              >
                {item.status === 'critico' ? 'Crítico' : 'Bajo'}
              </span>
            </div>
          ))
        )}
      </div>

      <div className='p-4 border-t border-gray-200'>
        <Link
          to='/almacen'
          className='w-full block text-center py-2 bg-amber-400 hover:bg-amber-500 rounded-lg text-sm text-gray-800 font-medium transition-colors'
        >
          Ver inventario completo
        </Link>
      </div>
    </div>
  )
}
