import { useLocation } from 'react-router'
import { VentaActions } from './VentaActions'
import { GuardiaActions } from './GuardiaActions'
import { BlacklistActions } from './BlacklistActions'
import { RecorridosGuardiaActions } from './RecorridosGuardiaActions'

export const TableActionsDispatcher = ({ data, openModal }) => {
  const { pathname } = useLocation()

  switch (pathname) {
    case '/ventas':
      return <VentaActions data={data} openModal={openModal} />
    case '/guardias':
      return <GuardiaActions data={data} openModal={openModal} />
    case '/blacklist':
      return <BlacklistActions data={data} openModal={openModal} />
    case '/recorridos-guardia':
      return <RecorridosGuardiaActions data={data} />
    default:
      return null
  }
}
