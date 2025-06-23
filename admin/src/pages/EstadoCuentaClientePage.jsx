import dayjs from 'dayjs'
import { AlertaCard } from '../components/AlertaCard'
import { useReportes } from '../hooks/useReportes'
import { toast } from 'sonner'
import { FormEstadoCuentaCliente } from '../components/modals/FormEstadoCuentaCliente'

export default function EstadoCuentaClientePage() {
  const {
    formReport,
    estado,
    generateEstadoCuentaCliente,
    handleInputChange,
    loadOptionsClientes
  } = useReportes()

  const handleGeneretReport = (e) => {
    e.preventDefault()

    if (dayjs(formReport.fecha_inicio).isAfter(dayjs(formReport.fecha_fin))) {
      toast.warning('La fecha de fin no puede ser antes que la fecha de inicio')
      return
    }

    const newData = {
      ...formReport,
      cliente_id: formReport.cliente_id.value
    }
    generateEstadoCuentaCliente(newData)
  }

  return (
    <div className='md:p-4 bg-gray-100'>
      <h1 className='text-2xl font-semibold text-gray-900 mb-4 sm:mb-0'>
        Estado de cuenta de los clientes
      </h1>

      <div className='mt-6 bg-white p-4 rounded-xl mx-auto'>
        <AlertaCard text='Generador de estado de cuentas de los clientes' />

        <FormEstadoCuentaCliente
          estado={estado}
          handleSubmit={handleGeneretReport}
          handleInputChange={handleInputChange}
          loadOptionsClientes={loadOptionsClientes}
          formReport={formReport}
        />
      </div>
    </div>
  )
}
