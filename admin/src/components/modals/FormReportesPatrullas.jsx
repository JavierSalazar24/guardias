import { formOptions } from '../../forms/formReportesPatrullasOptions'
import { AlertaCard } from '../AlertaCard'
import { InformePatrullas } from '../InformePatrullas'
import { InputField } from '../InputField'

export const FormReportesPatrullas = ({
  view,
  formData,
  handleInputChange
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text='Datos de la bitácora' />
      </div>

      {formOptions.generalFields.map(({ type, label, name, required }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={required}
          value={formData[name] || ''}
          onChange={handleInputChange}
          disabled={view}
          classInput='md:col-span-2'
        />
      ))}

      <InformePatrullas formData={formData} />
    </div>
  )
}
