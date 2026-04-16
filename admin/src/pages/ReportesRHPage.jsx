import { AlertaCard } from '../components/AlertaCard'
import { FormReportesRH } from '../components/modals/FormReportesRH'

const ReportesRHPage = () => {
  return (
    <div className='md:p-4 bg-gray-100'>
      <h1 className='text-2xl font-semibold text-gray-900 mb-4 sm:mb-0'>
        Generador de reportes
      </h1>

      <div className='mt-6 bg-white p-4 rounded-xl mx-auto'>
        <AlertaCard text='Generador de reportes de Recursos Humanos' />

        <FormReportesRH />
      </div>
    </div>
  )
}
export default ReportesRHPage
