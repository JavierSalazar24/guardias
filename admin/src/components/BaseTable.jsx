import { useEffect } from 'react'
import { useTable } from '../hooks/useTable'
import { Pagination } from './Pagination'
import { SearchBar } from './SearchBar'
import { TheadTable } from './TheadTable'
import { TbodyTable } from './TbodyTable'

export const BaseTable = ({ columns, data, title, loading }) => {
  const { currentData, setData, handleClass } = useTable()

  useEffect(() => {
    setData(
      data,
      columns.map((col) => col.key)
    )
  }, [data, columns, setData])

  return (
    <>
      <SearchBar title={title} data={data} />

      <div className='bg-white shadow rounded-lg overflow-hidden'>
        <div className='overflow-x-auto'>
          <table className='min-w-full divide-y divide-gray-200'>
            <TheadTable columns={columns} />
            <TbodyTable
              loading={loading}
              columns={columns}
              currentData={currentData}
              handleClass={handleClass}
            />
          </table>
        </div>

        <Pagination />
      </div>
    </>
  )
}
