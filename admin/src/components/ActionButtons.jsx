import {
  Ban,
  Edit,
  Eye,
  Image,
  LockOpen,
  ShieldOff,
  Trash2
} from 'lucide-react'
import { useLocation } from 'react-router'
import { useAuth } from '../context/AuthContext'
import { hasPermission } from '../helpers/permissions'
import { isExcluded } from '../utils/routeUtils'
import {
  EXCLUDE_DELETE,
  EXCLUDE_EDIT,
  EXCLUDE_GENERAL
} from '../routes/exclusiones'
import { BotonImprimir } from './BotonImprimir'
import { routesPrintsButtons } from '../utils/routesPrintsButtons'
import { TableActionsDispatcher } from './tableActions/TableActionsDispatcher'

export const ActionButtons = ({ data, openModal }) => {
  const { user } = useAuth()
  const { pathname } = useLocation()

  const printButton = routesPrintsButtons[pathname]

  return (
    <div className='flex justify-center space-x-2'>
      {/* Ver */}
      {hasPermission(user, pathname, 'consultar') &&
        pathname !== '/recorridos-guardia' && (
          <button
            title='Ver registro'
            onClick={() => openModal('view', data)}
            className='text-indigo-600 hover:text-indigo-900 p-1 rounded-md hover:bg-indigo-50 cursor-pointer transition-all'
          >
            <Eye className='h-5 w-5' />
          </button>
        )}

      {!isExcluded(pathname, EXCLUDE_GENERAL) && (
        <>
          {/* Editar */}
          {hasPermission(user, pathname, 'actualizar') &&
            !isExcluded(pathname, EXCLUDE_EDIT) &&
            !(pathname === '/ventas' && data.estatus === 'Pagada') &&
            !(pathname === '/ventas' && data.estatus === 'Cancelada') && (
              <button
                title='Editar registro'
                onClick={() => openModal('edit', data)}
                className='text-green-600 hover:text-green-900 p-1 rounded-md hover:bg-green-50 cursor-pointer transition-all'
              >
                <Edit className='h-5 w-5' />
              </button>
            )}
          {/* Eliminar */}
          {hasPermission(user, pathname, 'eliminar') &&
            !isExcluded(pathname, EXCLUDE_DELETE) &&
            !(
              pathname === '/ventas' &&
              (data.estatus === 'Pagada' ||
                data.estatus === 'Pendiente' ||
                data.estatus === 'Vencida')
            ) &&
            !(pathname === '/cotizaciones' && data.aceptada === 'SI') &&
            !(
              pathname === '/orden-servicio' && data.estatus === 'En proceso'
            ) &&
            !(pathname === '/prestamos' && data.estatus === 'Pendiente') && (
              <button
                title='Eliminar registro'
                onClick={() => openModal('delete', data)}
                className='text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50 cursor-pointer transition-all'
              >
                <Trash2 className='h-5 w-5' />
              </button>
            )}
        </>
      )}

      <TableActionsDispatcher data={data} openModal={openModal} />

      {/* Botón de impresión dinámico */}
      {printButton && (
        <BotonImprimir
          title={printButton.title}
          href={printButton.href(data)}
        />
      )}
    </div>
  )
}
