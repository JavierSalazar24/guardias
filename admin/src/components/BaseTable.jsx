import { useEffect } from 'react'
import { useTable } from '../hooks/useTable'
import { Pagination } from './Pagination'
import { SearchBar } from './SearchBar'
import { TheadTable } from './TheadTable'
import { TbodyTable } from './TbodyTable'

export const BaseTable = ({ columns, data, title, loading, openModal }) => {
  const {
    currentData,
    setData,
    handleClass,
    indexOfFirstItem,
    indexOfLastItem,
    filteredData,
    currentPage,
    totalPages,
    goToPage,
    searchTerm,
    setSearchTerm,
    setCurrentPage
  } = useTable()

  useEffect(() => {
    setData(
      data,
      columns.map((col) => col.key)
    )
  }, [data, columns, setData])

  return (
    <>
      <SearchBar
        title={title}
        data={data}
        searchTerm={searchTerm}
        setSearchTerm={setSearchTerm}
        setCurrentPage={setCurrentPage}
        openModal={openModal}
      />

      <div className='bg-white shadow rounded-lg overflow-hidden'>
        <div className='overflow-x-auto'>
          <table className='min-w-full divide-y divide-gray-200'>
            <TheadTable columns={columns} />
            <TbodyTable
              loading={loading}
              columns={columns}
              currentData={currentData}
              handleClass={handleClass}
              openModal={openModal}
            />
          </table>
        </div>

        <Pagination
          indexOfFirstItem={indexOfFirstItem}
          indexOfLastItem={indexOfLastItem}
          filteredData={filteredData}
          currentPage={currentPage}
          totalPages={totalPages}
          goToPage={goToPage}
        />
      </div>
    </>
  )
}
