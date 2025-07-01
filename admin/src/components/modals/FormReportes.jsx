import {
  estatusOptions,
  metodoPagoOptions,
  moduloOptions,
  tipoMovimientoOptions,
  tipoPagoOptions
} from '../../utils/reporteOptions'
import { InputField } from '../InputField'

export const FormReportes = ({
  formReport,
  handleInputChange,
  loadOptionsBancos,
  loadOptionsProveedores,
  loadOptionsVehiculos,
  handleSubmit
}) => {
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
        classInput='md:col-span-6'
      />

      <InputField
        label='Fecha de inicio'
        id='fecha_inicio'
        name='fecha_inicio'
        type='datetime-local'
        required={true}
        value={formReport.fecha_inicio || ''}
        onChange={handleInputChange}
        classInput='md:col-span-3'
      />
      <InputField
        label='Fecha de fin'
        id='fecha_fin'
        name='fecha_fin'
        type='datetime-local'
        required={true}
        value={formReport.fecha_fin || ''}
        onChange={handleInputChange}
        classInput='md:col-span-3'
      />

      {['orden-compra', 'compras', 'gastos', 'movimientos'].includes(
        formReport.modulo
      ) && (
        <InputField
          label='Bancos'
          id='banco_id'
          name='banco_id'
          type='async'
          required={true}
          value={formReport.banco_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsBancos}
          classInput='md:col-span-3'
        />
      )}

      {['orden-compra', 'compras'].includes(formReport.modulo) && (
        <InputField
          label='Proveedor'
          id='proveedor_id'
          name='proveedor_id'
          type='async'
          required={true}
          value={formReport.proveedor_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsProveedores}
          classInput='md:col-span-3'
        />
      )}

      {formReport.modulo === 'orden-compra' && (
        <InputField
          label='Estatus'
          id='estatus'
          name='estatus'
          type='select'
          required={true}
          value={formReport.estatus || ''}
          opcSelect={estatusOptions}
          onChange={handleInputChange}
          classInput='md:col-span-3'
        />
      )}

      {['bancos', 'ventas', 'gastos', 'compras', 'movimientos'].includes(
        formReport.modulo
      ) && (
        <InputField
          label='Método de pago'
          id='metodo_pago'
          name='metodo_pago'
          type='select'
          required={true}
          value={formReport.metodo_pago || ''}
          onChange={handleInputChange}
          opcSelect={metodoPagoOptions}
          classInput='md:col-span-3'
        />
      )}

      {formReport.modulo === 'ventas' && (
        <InputField
          label='Tipo de pago'
          id='tipo_pago'
          name='tipo_pago'
          type='select'
          required={true}
          value={formReport.tipo_pago || ''}
          onChange={handleInputChange}
          opcSelect={tipoPagoOptions}
          classInput='md:col-span-3'
        />
      )}

      {formReport.modulo === 'movimientos' && (
        <InputField
          label='Tipo de movimiento'
          id='tipo_movimiento'
          name='tipo_movimiento'
          type='select'
          required={true}
          value={formReport.tipo_movimiento || ''}
          onChange={handleInputChange}
          opcSelect={tipoMovimientoOptions}
          classInput='md:col-span-3'
        />
      )}

      {formReport.modulo === 'boletas-gasolina' && (
        <InputField
          label='Vehículo'
          id='vehiculo_id'
          name='vehiculo_id'
          type='async'
          required={true}
          value={formReport.vehiculo_id || ''}
          onChange={handleInputChange}
          loadOptions={loadOptionsVehiculos}
          classInput='md:col-span-6'
        />
      )}

      <div className='md:col-span-6 sm:col-span-6'>
        <button
          type='submit'
          className='rounded-sm text-white font-medium py-2 px-3 bg-[#3674B5] hover:bg-[#486483] transition-all cursor-pointer'
        >
          Generar reporte
        </button>
      </div>
    </form>
  )
}
