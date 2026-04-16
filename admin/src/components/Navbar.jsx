import { useEffect, useState } from 'react'
import { ButtonSidebar } from './header/ButtonSidebar'
import { OperacionGuardias } from './header/OperacionGuardias'
import { TurnoActual } from './header/TurnoActual'
import { Reloj } from './header/Reloj'
import { DropDownNavbar } from './header/DropDownNavbar'
import { getCurrentShift } from '../utils/getCurrentShift'
import { getTimeUntilShiftChange } from '../utils/getTimeUntilShiftChange'

export const Navbar = ({ toggleSidebar }) => {
  const [currentTime, setCurrentTime] = useState(new Date())
  const [shift, setShift] = useState(getCurrentShift())
  const [timeLeft, setTimeLeft] = useState(
    getTimeUntilShiftChange(getCurrentShift())
  )

  useEffect(() => {
    const timer = setInterval(() => {
      const now = new Date()
      setCurrentTime(now)
      const currentShift = getCurrentShift()
      setShift(currentShift)
      setTimeLeft(getTimeUntilShiftChange(currentShift))
    }, 1000)

    return () => clearInterval(timer)
  }, [])

  return (
    <header className='bg-white shadow-sm border-b border-gray-100 z-10 py-2'>
      <div className='flex items-center justify-between pl-1.5 sm:pl-0 gap-2 lg:gap-0'>
        <ButtonSidebar toggleSidebar={toggleSidebar} />

        <div className='sm:block ml-2 hidden'>
          <OperacionGuardias />
        </div>

        <div className='sm:block hidden'>
          <TurnoActual shift={shift} timeLeft={timeLeft} />
        </div>

        <div className='flex items-center gap-4'>
          <Reloj currentTime={currentTime} />
          <div className='h-10 w-px bg-border' />
          <DropDownNavbar />
        </div>
      </div>
    </header>
  )
}
