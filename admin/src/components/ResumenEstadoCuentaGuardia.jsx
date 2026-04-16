import { formatearMonedaMXN } from '../utils/formattedCurrancy'

export const ResumenEstadoCuentaGuardia = ({ data }) => {
  return (
    <div className='mb-7 p-4 border border-[#ddd] rounded-lg bg-[#f9f9f9] resumen'>
      <h3 className='text-3xl mb-4 text-center text-[#27548a] font-bold'>
        Resumen Final
      </h3>

      <div className='flex mb-2 gap-2.5 items-center mt-10'>
        <span className='font-bold text-[18px]'>Total ingresos:</span>
        <span className='px-1.5 py-0.5 rounded-lg text-[14px] bg-[#1f964d] text-white'>
          {formatearMonedaMXN(data.totales.total_ingresos)} MXN
        </span>
      </div>

      <div className='ml-5'>
        <p>
          - Pago por días trabajados:{' '}
          {formatearMonedaMXN(data.ingresos.pago_dias_trabajados)} MXN
        </p>
        <p>
          - Tiempo extra: {formatearMonedaMXN(data.ingresos.tiempo_extra)} MXN
        </p>
        <p>
          - Prima vacacional:{' '}
          {formatearMonedaMXN(data.ingresos.prima_vacacional)} MXN
        </p>
        <p>
          - Incapacidades pagadas:{' '}
          {formatearMonedaMXN(data.ingresos.incapacidades_pagadas)} MXN
        </p>
      </div>

      <div className='mt-5 p-2.5 border-t border-dashed border-[#ccc]' />

      <div className='flex mb-2 gap-2.5 items-center'>
        <span className='font-bold text-[18px]'>Total egresos:</span>
        <span className='px-1.5 py-0.5 rounded-lg text-[14px] bg-[#e02525] text-white'>
          {formatearMonedaMXN(data.totales.total_egresos)} MXN
        </span>
      </div>

      <div className='ml-5'>
        <p>- Faltas: {formatearMonedaMXN(data.egresos.faltas)} MXN</p>
        <p>- Descuentos: {formatearMonedaMXN(data.egresos.descuentos)} MXN</p>
        <p>
          - Préstamos (pendientes): {formatearMonedaMXN(data.egresos.prestamos)}{' '}
          MXN
        </p>
        <p>
          - Incapacidades no pagadas:{' '}
          {formatearMonedaMXN(data.egresos.incapacidades_no_pagadas)} MXN
        </p>
        <p className='italic text-[#555] text-[12px] mt-1.5 ml-2'>
          Las incapacidades no cubiertas por la empresa se descuentan porque
          representan días no laborados sin derecho a sueldo.
        </p>
      </div>

      <div className='mt-5 p-2.5 border-t border-dashed border-[#ccc]' />

      <div className='flex mb-2 gap-2.5 items-center'>
        <span className='font-bold text-[18px]'>
          Prestaciones (retenciones legales):
        </span>
        <span className='px-1.5 py-0.5 rounded-lg text-[14px] bg-[#e02525] text-white'>
          {formatearMonedaMXN(data.totales.total_prestaciones)} MXN
        </span>
      </div>
      <div className='ml-5'>
        <p>- IMSS: {formatearMonedaMXN(data.prestaciones.imss)} MXN</p>
        <p>
          - INFONAVIT: {formatearMonedaMXN(data.prestaciones.infonavit)} MXN
        </p>
        <p>- FONACOT: {formatearMonedaMXN(data.prestaciones.fonacot)} MXN</p>
        <p>
          - Retención ISR: {formatearMonedaMXN(data.prestaciones.retencion_isr)}{' '}
          MXN
        </p>
        <p>- Aguinaldo: {formatearMonedaMXN(data.guardia.aguinaldo)} MXN</p>
        <p className='italic text-[#555] text-[12px] mt-1.5 ml-2'>
          El aguinaldo no se ha sumado ni al sueldo bruto, ni al sueldo neto.
        </p>
      </div>

      <div className='mt-5 p-2.5 border-t border-dashed border-[#ccc]' />

      <div className='flex mb-2 gap-2.5 items-center'>
        <span className='font-bold text-[18px]'>Pago bruto:</span>
        <span className='text-white px-1.5 py-0.5 rounded-lg text-[14px] bg-[#1f964d]'>
          {formatearMonedaMXN(data.totales.pago_bruto)} MXN
        </span>
      </div>
      <div className='flex mb-2 gap-2.5 items-center'>
        <span className='font-bold text-[18px]'>Pago neto:</span>
        <span className='text-white px-1.5 py-0.5 rounded-lg text-[14px] bg-[#1f964d] '>
          {formatearMonedaMXN(data.totales.pago_neto)} MXN
        </span>
      </div>
    </div>
  )
}
