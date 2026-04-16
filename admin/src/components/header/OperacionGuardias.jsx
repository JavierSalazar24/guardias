import { ShieldCheck, Users } from 'lucide-react'
import { useGuardiasTotales } from '../../hooks/useGuardiasTotales'
import Loading from '../Loading'

export const OperacionGuardias = () => {
  const { data, isLoading, isError } = useGuardiasTotales()

  if (isError) return null

  if (isLoading) return <div className='loader'></div>

  return (
    <div className='hidden lg:flex items-center gap-3 rounded-xl border border-border bg-card/30 px-4 py-2.5'>
      <div className='flex h-8 w-8 items-center justify-center rounded-lg bg-success/10'>
        <Users className='h-4 w-4 text-success' />
      </div>
      <div className='flex flex-col'>
        <span className='text-[10px] font-medium uppercase tracking-wider text-muted-foreground'>
          Guardias en Turno
        </span>
        <div className='flex items-baseline gap-1'>
          <span className='font-bold text-foreground'>
            {data.guardiasEnTurno}
          </span>
          <span className='text-xs text-muted-foreground'>
            / {data.guardiasTotales}
          </span>
        </div>
      </div>
      <div className='ml-2 flex h-7 w-7 items-center justify-center rounded-full bg-success/10'>
        <ShieldCheck className='h-3.5 w-3.5 text-success' />
      </div>
    </div>
  )
}
