import { AlertaCard } from './AlertaCard'

const toTitleCase = (str) => {
  return str.replace(/_/g, ' ').replace(/\b\w/g, (char) => char.toUpperCase())
}

export const InformePatrullas = ({ formData }) => {
  return (
    <>
      {/* Datos del Vehículo */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Datos del Vehículo' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          <div className='grid grid-cols-1 sm:grid-cols-2 gap-4'>
            <div className='flex flex-col'>
              <strong>Kilometraje Inicial</strong>
              <p className='text-gray-600'>
                {formData.datos_vehiculo?.kilometraje_inicial || 'N/A'}
              </p>
            </div>
            <div className='flex flex-col'>
              <strong>Kilometraje Final</strong>
              <p className='text-gray-600'>
                {formData.datos_vehiculo?.kilometraje_final || 'N/A'}
              </p>
            </div>
            <div className='flex flex-col'>
              <strong>Unidad Limpia</strong>
              <p
                className={`text-gray-600 ${
                  formData.datos_vehiculo?.unidad_limpia
                    ? 'text-green-500'
                    : 'text-red-500'
                }`}
              >
                {formData.datos_vehiculo?.unidad_limpia ? 'Sí' : 'No'}
              </p>
            </div>
            <div className='flex flex-col'>
              <strong>Placas</strong>
              <p className='text-gray-600'>
                {formData.datos_vehiculo?.placas || 'N/A'}
              </p>
            </div>
            <div className='flex flex-col'>
              <strong>Tarjeta de Circulación</strong>
              <p className='text-gray-600'>
                {formData.datos_vehiculo?.tarjeta_circulacion || 'N/A'}
              </p>
            </div>
          </div>
        </div>
      </div>

      {/* Llantas */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Llantas' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.llantas || {}).map(
            ([key, { marca, condicion }]) => (
              <div key={key} className='flex justify-between py-3 border-b'>
                <div className='flex flex-col'>
                  <strong>{toTitleCase(key)}</strong>
                  <p className='text-gray-600'>{`Marca: ${marca || 'N/A'}`}</p>
                  <p
                    className={`text-gray-600 font-semibold ${
                      condicion === 'Buena'
                        ? 'text-green-500'
                        : condicion === 'Regular'
                        ? 'text-yellow-500'
                        : 'text-red-500'
                    }`}
                  >
                    {`Condición: ${condicion || 'N/A'}`}
                  </p>
                </div>
              </div>
            )
          )}
        </div>
      </div>

      {/* Niveles */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Niveles' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.niveles || {}).map(([key, value]) => (
            <div key={key} className='flex justify-between py-3 border-b'>
              <div className='flex flex-col'>
                <strong>{toTitleCase(key)}</strong>
                <p
                  className={`text-gray-600 font-semibold ${
                    value === 'Buena'
                      ? 'text-green-500'
                      : value === 'Regular'
                      ? 'text-yellow-500'
                      : 'text-red-500'
                  }`}
                >
                  {`Condición: ${value || 'N/A'}`}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Condiciones mecánicas */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Condiciones Mecánicas' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.condiciones_mecanicas || {}).map(
            ([key, value]) => (
              <div key={key} className='flex justify-between py-3 border-b'>
                <div className='flex flex-col'>
                  <strong>{toTitleCase(key)}</strong>
                  <p
                    className={`text-gray-600 font-semibold ${
                      value === 'Buena'
                        ? 'text-green-500'
                        : value === 'Regular'
                        ? 'text-yellow-500'
                        : 'text-red-500'
                    }`}
                  >
                    {`Condición: ${value || 'N/A'}`}
                  </p>
                </div>
              </div>
            )
          )}
        </div>
      </div>

      {/* Costado derecho */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Costado Derecho' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.costado_derecho || {}).map(
            ([key, value]) => (
              <div key={key} className='flex justify-between py-3 border-b'>
                <div className='flex flex-col'>
                  <strong>{toTitleCase(key)}</strong>
                  <p
                    className={`text-gray-600 font-semibold ${
                      value === 'Buena'
                        ? 'text-green-500'
                        : value === 'Regular'
                        ? 'text-yellow-500'
                        : 'text-red-500'
                    }`}
                  >
                    {`Condición: ${value || 'N/A'}`}
                  </p>
                </div>
              </div>
            )
          )}
        </div>
      </div>

      {/* Costado izquierdo */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Costado Izquierdo' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.costado_izquierda || {}).map(
            ([key, value]) => (
              <div key={key} className='flex justify-between py-3 border-b'>
                <div className='flex flex-col'>
                  <strong>{toTitleCase(key)}</strong>
                  <p
                    className={`text-gray-600 font-semibold ${
                      value === 'Buena'
                        ? 'text-green-500'
                        : value === 'Regular'
                        ? 'text-yellow-500'
                        : 'text-red-500'
                    }`}
                  >
                    {`Condición: ${value || 'N/A'}`}
                  </p>
                </div>
              </div>
            )
          )}
        </div>
      </div>

      {/* Herramientas */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Herramientas' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.herramientas || {}).map(([key, value]) => (
            <div key={key} className='flex justify-between py-3 border-b'>
              <div className='flex flex-col'>
                <strong>{toTitleCase(key)}</strong>
                <p
                  className={`text-gray-600 font-semibold ${
                    value ? 'text-green-500' : 'text-red-500'
                  }`}
                >
                  {value ? 'Disponible' : 'No disponible'}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Documentación */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Documentación' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.documentacion || {}).map(([key, value]) => (
            <div key={key} className='flex justify-between py-3 border-b'>
              <div className='flex flex-col'>
                <strong>{toTitleCase(key)}</strong>
                <p
                  className={`text-gray-600 font-semibold ${
                    value ? 'text-green-500' : 'text-red-500'
                  }`}
                >
                  {value ? 'Disponible' : 'No disponible'}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Llaves y accesos */}
      <div className='sm:col-span-2 md:col-span-3'>
        <AlertaCard text='Llaves y Accesos' />
        <div className='bg-white p-6 rounded-lg shadow-md mt-4'>
          {Object.entries(formData.llaves_accesos || {}).map(([key, value]) => (
            <div key={key} className='flex justify-between py-3 border-b'>
              <div className='flex flex-col'>
                <strong>{toTitleCase(key)}</strong>
                <p
                  className={`text-gray-600 font-semibold ${
                    value === 'Buena'
                      ? 'text-green-500'
                      : value === 'Regular'
                      ? 'text-yellow-500'
                      : 'text-red-500'
                  }`}
                >
                  {`Condición: ${value || 'N/A'}`}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </>
  )
}
