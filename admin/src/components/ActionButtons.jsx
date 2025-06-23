import {
  Ban,
  Edit,
  Eye,
  Image,
  LockOpen,
  ShieldOff,
  Trash2
} from 'lucide-react'
import { useModal } from '../hooks/useModal'
import { useLocation } from 'react-router'
import { API_HOST } from '../config'
import { useAuth } from '../context/AuthContext'
import { hasPermission } from '../helpers/permissions'
import { isExcluded } from '../utils/routeUtils'
import {
  EXCLUDE_DELETE,
  EXCLUDE_EDIT,
  EXCLUDE_GENERAL
} from '../routes/exclusiones'
import { BotonImprimir } from './BotonImprimir'

const printButtonsConfig = {
  '/cotizaciones': {
    title: 'Imprimir cotización',
    href: (data) => `${API_HOST}/api/pdf/cotizacion/${data.id}`
  },
  '/generar-qr': {
    title: 'Imprimir QRs',
    href: (data) =>
      `${API_HOST}/ordenes-servicio/${data.orden_servicio?.id}/pdf-qrs`
  },
  '/pagos-empleados': {
    title: 'Imprimir comprobante de pago',
    href: (data) => `${API_HOST}/api/pdf/pagos-empleados/${data.id}`
  },
  '/check-guardia': {
    href: (data) => `${API_HOST}/api/pdf/reporte-check-guardia/${data.id}`
  },
  '/reporte-incidente-guardia': {
    href: (data) => `${API_HOST}/api/pdf/reporte-incidente-guardia/${data.id}`
  },
  '/reporte-guardia': {
    href: (data) => `${API_HOST}/api/pdf/reporte-guardia/${data.id}`
  },
  '/reporte-supervisor': {
    href: (data) => `${API_HOST}/api/pdf/reporte-supervisor/${data.id}`
  },
  '/reporte-bitacoras': {
    href: (data) => `${API_HOST}/api/pdf/reporte-bitacoras/${data.id}`
  },
  '/reporte-patrullas': {
    href: (data) => `${API_HOST}/api/pdf/reporte-patrullas/${data.id}`
  }
}

export const ActionButtons = ({ data }) => {
  const { user } = useAuth()
  const { pathname } = useLocation()
  const { openModal } = useModal()

  const printConfig = printButtonsConfig[pathname]

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
            !(pathname === '/ventas' && data.estatus === 'Pagada') && (
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
            !isExcluded(pathname, EXCLUDE_DELETE) && (
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

      {pathname === '/ventas' &&
        data.estatus !== 'Cancelada' &&
        data.estatus !== 'Pagada' && (
          <button
            title='Cancelar venta'
            onClick={() => openModal('cancelar', data)}
            className='text-orange-600 hover:text-orange-900 p-1 rounded-md hover:bg-red-50 cursor-pointer transition-all'
          >
            <Ban className='h-5 w-5' />
          </button>
        )}
      {pathname === '/guardias' && (
        <button
          title='Mandar a lista negra'
          onClick={() => openModal('blacklist', data)}
          className='text-orange-600 hover:text-orange-900 p-1 rounded-md hover:bg-orange-50 cursor-pointer transition-all'
        >
          <ShieldOff className='h-5 w-5' />
        </button>
      )}
      {pathname === '/blacklist' && (
        <button
          title='Quitar de la lista negra'
          onClick={() => openModal('whitelist', data)}
          className='text-yellow-600 hover:text-yellow-900 p-1 rounded-md hover:bg-yellow-50 cursor-pointer transition-all'
        >
          <LockOpen className='h-5 w-5' />
        </button>
      )}
      {pathname === '/recorridos-guardia' &&
        (data.foto ? (
          <a
            title='Ver foto'
            href={data.foto}
            target='_blank'
            className='text-yellow-600 hover:text-yellow-900 p-1 rounded-md hover:bg-red-50 cursor-pointer transition-all'
          >
            <Image className='h-5 w-5' />
          </a>
        ) : (
          <p className='text-xs text-primary font-semibold'>
            No hay foto disponible
          </p>
        ))}

      {/* Botón de impresión dinámico */}
      {printConfig && (
        <BotonImprimir
          title={printConfig.title}
          href={printConfig.href(data)}
        />
      )}
    </div>
  )
}
