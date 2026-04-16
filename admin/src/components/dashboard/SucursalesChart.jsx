import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer
} from 'recharts'
import { CustomTooltip } from './CustomTooltip'

export function SucursalesChart({ sucursalesVentas }) {
  return (
    <div className='bg-white border border-gray-200 shadow-md rounded-xl p-5'>
      <div className='mb-2'>
        <h3 className='text-lg font-semibold text-gray-900'>
          Rendimiento por sucursal
        </h3>
        <p className='text-sm text-gray-500'>
          Las 5 sucursales con mayores ventas
        </p>
      </div>

      <div className='h-72'>
        {sucursalesVentas.length === 0 ? (
          <div className='flex items-center justify-center h-full'>
            <span className='text-gray-400 text-lg font-medium'>
              No hay datos para graficar.
            </span>
          </div>
        ) : (
          <ResponsiveContainer width='100%' height='100%'>
            <BarChart data={sucursalesVentas} layout='vertical'>
              <CartesianGrid
                strokeDasharray='3 3'
                stroke='#dddddd'
                horizontal={false}
              />
              <XAxis
                type='number'
                stroke='#6b7280'
                fontSize={12}
                tickFormatter={(value) => `$${value / 1000}K`}
              />
              <YAxis
                type='category'
                dataKey='nombre'
                stroke='#6b7280'
                fontSize={11}
                width={80}
              />
              <Tooltip
                content={
                  <CustomTooltip
                    active={true}
                    payload={sucursalesVentas}
                    label='Rendimiento por sucursal'
                  />
                }
              />
              <Bar
                dataKey='ventas'
                name='Ventas'
                fill='#00ab78'
                radius={[0, 4, 4, 0]}
              />
            </BarChart>
          </ResponsiveContainer>
        )}
      </div>

      <div className='flex items-center justify-center gap-6 mt-4'>
        <div className='flex items-center gap-2'>
          <div className='w-3 h-3 rounded-full bg-success'></div>
          <span className='text-sm text-gray-400'>Ventas del mes</span>
        </div>
      </div>
    </div>
  )
}
