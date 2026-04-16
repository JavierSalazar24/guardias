import {
  UserPlus,
  FileText,
  ShoppingCart,
  QrCode,
  ClipboardList,
  Receipt,
  Users,
  Banknote,
  FilePenLine
} from 'lucide-react'
import { Link } from 'react-router'

export default function AccionesRapidas() {
  const actions = [
    {
      icon: UserPlus,
      label: 'Nuevo Guardia',
      color: 'bg-success/10 text-success hover:bg-success/20',
      url: '/guardias'
    },
    {
      icon: FileText,
      label: 'Nueva Cotización',
      color: 'bg-info/10 text-info hover:bg-info/20',
      url: '/cotizaciones'
    },
    {
      icon: Users,
      label: 'Nuevo Cliente',
      color: 'bg-success-dark/10 text-success-dark hover:bg-success-dark/20',
      url: '/clientes'
    },
    {
      icon: ShoppingCart,
      label: 'Orden de Compra',
      color: 'bg-warning/10 text-warning hover:bg-warning/20',
      url: '/ordenes-compra'
    },
    {
      icon: FilePenLine,
      label: 'Acta administrativa',
      color: 'bg-action/10 text-action hover:bg-action/20',
      url: '/actas-administrativas'
    },
    {
      icon: Banknote,
      label: 'Pago a Guardia',
      color: 'bg-warning-dark/10 text-warning-dark hover:bg-warning-dark/20',
      url: '/pagos-empleados'
    },
    {
      icon: ClipboardList,
      label: 'Orden de Servicio',
      color: 'bg-danger/10 text-danger hover:bg-danger/20',
      url: '/orden-servicio'
    },
    {
      icon: Receipt,
      label: 'Nuevo Gasto',
      color: 'bg-muted/10 text-muted hover:bg-muted/20',
      url: '/gastos'
    }
  ]

  return (
    <div className='bg-white border border-gray-200 rounded-xl p-5 shadow-md mt-6'>
      <div className='mb-4'>
        <h3 className='text-lg font-semibold text-gray-900'>
          Acciones Rápidas
        </h3>
        <p className='text-sm text-gray-500'>Accesos directos frecuentes</p>
      </div>

      <div className='grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-4'>
        {actions.map((action, index) => {
          const Icon = action.icon
          return (
            <Link
              key={index}
              to={action.url}
              className={`flex flex-col items-center justify-center p-4 rounded-xl ${action.color} transition-colors`}
            >
              <Icon className='w-6 h-6 mb-2' />
              <span className='text-xs font-medium text-center'>
                {action.label}
              </span>
            </Link>
          )
        })}
      </div>
    </div>
  )
}
