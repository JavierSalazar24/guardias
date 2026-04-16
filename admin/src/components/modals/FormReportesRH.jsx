import { useReportes } from '../../hooks/useReportes'
import { InputField } from '../InputField'

const moduloOptions = [
  { value: '', label: 'Selecciona una opción' },
  { value: 'incapacidades', label: 'Incapacidades' },
  { value: 'tiempo-extra', label: 'Tiempo extra' },
  { value: 'faltas', label: 'Faltas' },
  { value: 'descuentos', label: 'Descuentos' },
  { value: 'vacaciones', label: 'Vacaciones' },
  { value: 'prestamos', label: 'Préstamos' }
]

export const FormReportesRH = () => {
  const {
    generateReportRH,
    handleInputChange,
    formReport,
    loadOptionsGuardiasTodos
  } = useReportes()

  const handleSubmit = (e) => {
    e.preventDefault()

    const newData = {
      ...formReport,
      guardia_id: formReport.guardia_id.value
    }
    generateReportRH(newData)
  }

  return (
    <form
      className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 mt-3'
      onSubmit={handleSubmit}
    >
      <InputField
        label='Selecciona el módulo'
        id='modulo'
        name='modulo'
        type='select'
        required={true}
        value={formReport.modulo || ''}
        onChange={handleInputChange}
        opcSelect={moduloOptions}
        classInput='md:col-span-3'
      />
      <InputField
        label='Selecciona al guardia'
        id='guardia_id'
        name='guardia_id'
        type='async'
        required={true}
        value={formReport.guardia_id || ''}
        onChange={handleInputChange}
        loadOptions={loadOptionsGuardiasTodos}
        classInput='md:col-span-3'
      />
      <InputField
        label='Fecha de inicio del periodo'
        id='fecha_inicio'
        name='fecha_inicio'
        type='date'
        required={true}
        value={formReport.fecha_inicio}
        onChange={handleInputChange}
        classInput='md:col-span-3'
      />
      <InputField
        label='Fecha de fin del periodo'
        id='fecha_fin'
        name='fecha_fin'
        type='date'
        required={true}
        value={formReport.fecha_fin}
        onChange={handleInputChange}
        classInput='md:col-span-3'
      />

      <div className='md:col-span-6 sm:col-span-6'>
        <button className='rounded-sm text-white font-medium py-2 px-3 bg-[#3674B5] hover:bg-[#486483] transition-all cursor-pointer'>
          Generar reporte
        </button>
      </div>
    </form>
  )
}
