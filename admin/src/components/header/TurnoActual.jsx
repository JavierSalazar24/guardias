import { Clock, Radio } from 'lucide-react'

export const TurnoActual = ({ shift, timeLeft }) => {
  return (
    <div
      className={`flex items-center gap-3 rounded-xl border ${shift.borderColor} ${shift.bgColor} px-4 py-2.5`}
    >
      <div
        className={`flex h-8 w-8 items-center justify-center rounded-lg ${shift.bgClock}`}
      >
        <Clock className={`h-4 w-4 ${shift.color}`} />
      </div>
      <div className='flex flex-col'>
        <div className='flex items-center gap-2'>
          <span className='text-[10px] font-medium uppercase tracking-wider text-muted-foreground'>
            Turno Actual
          </span>
          <div className='flex items-center gap-1'>
            <Radio className={`h-3 w-3 ${shift.color} animate-pulse`} />
            <span className={`text-[10px] font-semibold ${shift.color}`}>
              EN VIVO
            </span>
          </div>
        </div>
        <div className='flex items-center gap-2'>
          <span className={`text-sm font-bold ${shift.color}`}>
            {shift.name}
          </span>
          <span className='text-xs text-muted-foreground'>|</span>
          <span className='font-mono text-sm font-semibold text-foreground'>
            {String(timeLeft.hours).padStart(2, '0')}:
            {String(timeLeft.minutes).padStart(2, '0')}:
            {String(timeLeft.seconds).padStart(2, '0')}
          </span>
          <span className='text-[10px] text-muted-foreground'>restante</span>
        </div>
      </div>
    </div>
  )
}
