import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer
} from 'recharts'
import { CustomTooltip } from './CustomTooltip'

export function GuardiasChart({ guardiasData }) {
  return (
    <div className='bg-white border border-gray-200 shadow-md rounded-xl p-5'>
      <div className='mb-6'>
        <h3 className='text-lg font-semibold text-gray-900'>
          Evolución del personal
        </h3>
        <p className='text-sm text-gray-500'>Guardias activos, altas y bajas</p>
      </div>

      <div className='h-72'>
        {guardiasData.length === 0 ? (
          <div className='flex items-center justify-center h-full'>
            <span className='text-gray-400 text-lg font-medium'>
              No hay datos para graficar.
            </span>
          </div>
        ) : (
          <ResponsiveContainer width='100%' height='100%'>
            <LineChart data={guardiasData}>
              <CartesianGrid strokeDasharray='3 3' stroke='#dddddd' />
              <XAxis dataKey='month' stroke='#6b7280' fontSize={12} />
              <YAxis stroke='#6b7280' fontSize={12} />
              <Tooltip
                content={
                  <CustomTooltip
                    active={true}
                    payload={guardiasData}
                    label='Evolución del personal'
                  />
                }
              />
              <Line
                type='monotone'
                dataKey='activos'
                name='Activos'
                stroke='#00ab78'
                strokeWidth={2}
                dot={{ fill: '#00ab78', strokeWidth: 2 }}
              />
              <Line
                type='monotone'
                dataKey='nuevos'
                name='Nuevos'
                stroke='#3b82f6'
                strokeWidth={2}
                dot={{ fill: '#3b82f6', strokeWidth: 2 }}
              />
              <Line
                type='monotone'
                dataKey='bajas'
                name='Bajas'
                stroke='#ef4444'
                strokeWidth={2}
                dot={{ fill: '#ef4444', strokeWidth: 2 }}
              />
            </LineChart>
          </ResponsiveContainer>
        )}
      </div>

      <div className='flex items-center justify-center gap-6 mt-4'>
        <div className='flex items-center gap-2'>
          <div className='w-3 h-3 rounded-full bg-success'></div>
          <span className='text-sm text-gray-400'>Activos</span>
        </div>
        <div className='flex items-center gap-2'>
          <div className='w-3 h-3 rounded-full bg-blue-500'></div>
          <span className='text-sm text-gray-400'>Nuevos</span>
        </div>
        <div className='flex items-center gap-2'>
          <div className='w-3 h-3 rounded-full bg-red-500'></div>
          <span className='text-sm text-gray-400'>Bajas</span>
        </div>
      </div>
    </div>
  )
}
