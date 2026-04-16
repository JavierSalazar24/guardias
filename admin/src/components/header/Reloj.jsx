export const Reloj = ({ currentTime }) => {
  return (
    <div className='flex lg:hidden xl:flex flex-col items-end'>
      <span className='text-xl font-bold tabular-nums text-foreground'>
        {currentTime.toLocaleTimeString('es-MX', {
          hour: '2-digit',
          minute: '2-digit'
        })}
      </span>
      <span className='text-xs text-muted-foreground'>
        {currentTime.toLocaleDateString('es-MX', {
          weekday: 'long',
          day: 'numeric',
          month: 'short'
        })}
      </span>
    </div>
  )
}
