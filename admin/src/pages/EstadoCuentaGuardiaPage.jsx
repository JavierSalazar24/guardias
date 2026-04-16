import dayjs from 'dayjs'
import { AlertaCard } from '../components/AlertaCard'
import { useReportes } from '../hooks/useReportes'
import { toast } from 'sonner'
import { FormEstadoCuentaGuardia } from '../components/modals/FormEstadoCuentaGuardia'

export default function EstadoCuentaGuardiaPage() {
  const {
    formReport,
    estado,
    generateEstadoCuentaGuardia,
    handleInputChange,
    loadOptionsGuardias
  } = useReportes()

  const handleGeneretReport = (e) => {
    e.preventDefault()

    if (dayjs(formReport.fecha_inicio).isAfter(dayjs(formReport.fecha_fin))) {
      toast.warning('La fecha de fin no puede ser antes que la fecha de inicio')
      return
    }

    const newData = {
      ...formReport,
      guardia_id: formReport.guardia_id.value
    }
    generateEstadoCuentaGuardia(newData)
  }

  return (
    <div className='md:p-4 bg-gray-100'>
      <h1 className='text-2xl font-semibold text-gray-900 mb-4 sm:mb-0'>
        Estado de cuenta de los guardias
      </h1>

      <div className='mt-6 bg-white p-4 rounded-xl mx-auto'>
        <AlertaCard text='Generador de estado de cuentas de los guardias' />

        <FormEstadoCuentaGuardia
          estado={estado}
          handleSubmit={handleGeneretReport}
          handleInputChange={handleInputChange}
          loadOptionsGuardias={loadOptionsGuardias}
          formReport={formReport}
        />
      </div>
    </div>
  )
}
