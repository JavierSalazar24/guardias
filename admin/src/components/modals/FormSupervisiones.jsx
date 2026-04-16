import { InputField } from '../InputField'
import { AlertaCard } from '../AlertaCard'
import { formOptions } from '../../forms/formSupervisionesOptions'
import { FotoEvidenciaCameraOnly } from '../FotoEvidenciaCameraOnly'

export const FormSupervisiones = ({
  view,
  document,
  formData,
  handleInputChange,
  handleSelectedFile,
  loadOptionsGuardias
}) => {
  return (
    <>
      <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
        <FotoEvidenciaCameraOnly
          text='Evidencia'
          name='evidencia'
          view={view}
          formData={formData}
          document={document}
          onCapture={handleSelectedFile}
        />

        <div className='sm:col-span-6 md:col-span-2'>
          <AlertaCard text='Información general' />
        </div>
        {view && (
          <InputField
            type='text'
            label='Supervisor'
            name='supervisor_nombre'
            required={false}
            value={formData.supervisor_nombre || ''}
            onChange={handleInputChange}
            disabled={true}
            classInput='md:col-span-2'
          />
        )}
        {formOptions.generalFields.map(
          ({ type, label, name, required, options, condition }) =>
            (!condition || condition(formData)) && (
              <InputField
                key={name}
                type={type}
                label={label}
                name={name}
                opcSelect={options}
                required={required}
                value={formData[name] || ''}
                onChange={handleInputChange}
                loadOptions={loadOptionsGuardias}
                disabled={view}
                classInput='md:col-span-2'
              />
            )
        )}
      </div>
    </>
  )
}
