// import { useEffect } from 'react'
// import { useCheerleaderStore } from '../store/useCheerleaderStore'
// import { useCoachStore } from '../store/useCoachStore'
// import { usePlayerStore } from '../store/usePlayerStore'
// import { useUserStore } from '../store/useUserStore'

// export const useCount = () => {
//   const usersCount = useUserStore((state) => state.usersCount)
//   const getDataUsers = useUserStore((state) => state.getDataUsers)

//   const playersCount = usePlayerStore((state) => state.playersCount)
//   const getDataPlayers = usePlayerStore((state) => state.getDataPlayers)

//   const cheerleadersCount = useCheerleaderStore(
//     (state) => state.cheerleadersCount
//   )
//   const getDataCheerleaders = useCheerleaderStore(
//     (state) => state.getDataCheerleaders
//   )

//   const coachesCount = useCoachStore((state) => state.coachesCount)
//   const getDataCoaches = useCoachStore((state) => state.getDataCoaches)

//   useEffect(() => {
//     const getUser = async () => await getDataUsers()
//     const getPlayer = async () => await getDataPlayers()
//     const getCheerleader = async () => await getDataCheerleaders()
//     const getCoach = async () => await getDataCoaches()

//     getUser()
//     getPlayer()
//     getCheerleader()
//     getCoach()
//   }, [getDataCheerleaders, getDataCoaches, getDataPlayers, getDataUsers])

//   return {
//     usersCount,
//     playersCount,
//     cheerleadersCount,
//     coachesCount
//   }
// }
