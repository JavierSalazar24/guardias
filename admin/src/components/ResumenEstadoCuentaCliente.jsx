import { formatearMonedaMXN } from '../utils/formattedCurrancy'

export const ResumenEstadoCuentaCliente = ({ data }) => {
  return (
    <div className='mb-7 p-4 border border-[#ddd] rounded-lg bg-[#f9f9f9]'>
      <h2 className='text-3xl mb-4 text-center text-[#27548a] font-bold'>
        Resumen General
      </h2>

      <div>
        <strong className='text-[18px]'>Totales de cotizaciones:</strong>
        <div className='ml-5 mt-2'>
          <li className='text-[14px] text-[#333]'>
            Aceptadas: {data.resumen.cotizaciones.aceptadas}
          </li>
          <li className='text-[14px] text-[#333]'>
            No aceptadas: {data.resumen.cotizaciones.no_aceptadas}
          </li>
          <li className='text-[14px] text-[#333]'>
            Pendientes: {data.resumen.cotizaciones.pendientes}
          </li>
        </div>
      </div>

      <div className='mt-5 p-2.5 border-t border-dashed border-[#ccc]' />

      <p>
        <strong className='text-[18px]'>Total ventas:</strong>{' '}
        <span className='px-2 py-1 rounded-lg text-[14px] bg-[#27548A] text-white'>
          {formatearMonedaMXN(data.resumen.ventas.total)} MXN.
        </span>
      </p>
      <div className='ml-5 mt-2'>
        <li className='text-[#0d7033] font-bold text-[14px]'>
          Pagadas: {formatearMonedaMXN(data.resumen.ventas.pagadas)} MXN.
        </li>
        <li className='text-[#b61818] font-bold text-[14px]'>
          Pendientes: {formatearMonedaMXN(data.resumen.ventas.pendientes)} MXN.
        </li>
        <li className='text-[#b61818] font-bold text-[14px]'>
          Vencidas: {formatearMonedaMXN(data.resumen.ventas.vencidas)} MXN.
        </li>
        <li className='text-[#d46700] font-bold text-[14px]'>
          Canceladas: {formatearMonedaMXN(data.resumen.ventas.canceladas)} MXN.
        </li>
      </div>

      <div className='mt-5 p-2.5 border-t border-dashed border-[#ccc]' />

      <div>
        <p>
          <strong className='text-[18px]'>Balance financiero:</strong>
        </p>
        <div className='ml-5 mt-2'>
          <li className='text-[#0d7033] font-bold text-[14px]'>
            Total recibido (ventas pagadas):{' '}
            {formatearMonedaMXN(data.resumen.ventas.pagadas)} MXN.
          </li>
          <li className='text-[#b61818] font-bold text-[14px]'>
            Total pendiente por pagar (pendientes + vencidas):{' '}
            {formatearMonedaMXN(
              data.resumen.ventas.pendientes + data.resumen.ventas.vencidas
            )}{' '}
            MXN.
          </li>
        </div>
      </div>
    </div>
  )
}
