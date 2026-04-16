import { formOptions } from '../../forms/formDocumentosOptions'
import { InputField } from '../InputField'

export const FormDocumentos = ({
  view,
  edit,
  document,
  formData,
  handleInputChange,
  handleFileChange,
  loadOptionsGuardias,
  loadOptionsTiposDocumentos
}) => {
  return (
    <div className='grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 md:grid-cols-2 mb-7'>
      {formOptions.generalFields.map(({ type, label, name, required }) => (
        <InputField
          key={name}
          type={type}
          label={label}
          name={name}
          required={document ? !document : required}
          value={formData[name] || ''}
          onChange={type === 'file' ? handleFileChange : handleInputChange}
          loadOptions={
            name === 'guardia_id'
              ? loadOptionsGuardias
              : loadOptionsTiposDocumentos
          }
          disabled={view}
          classInput={type === 'file' ? 'md:col-span-2' : 'md:col-span-1'}
          document={edit ? null : formData[`${name}_url`] || null}
        />
      ))}
    </div>
  )
}
