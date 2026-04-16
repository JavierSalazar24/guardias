export const getRiskBadge = (riesgo) => {
  const styles = {
    alto: 'bg-danger/20 text-danger border-danger/30',
    medio: 'bg-warning-dark/20 text-warning-dark border-warning-dark/30',
    bajo: 'bg-yellow-400/20 text-yellow-400 border-yellow-400/30'
  }
  const labels = {
    alto: 'Alto',
    medio: 'Medio',
    bajo: 'Bajo'
  }
  return (
    <span
      className={`inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border ${styles[riesgo]}`}
    >
      {labels[riesgo]}
    </span>
  )
}
