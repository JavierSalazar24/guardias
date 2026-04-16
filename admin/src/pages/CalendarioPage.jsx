import { useMemo, useState } from 'react'
import { CalendarClock, Edit, Plus, Trash2, X } from 'lucide-react'
import FullCalendar from '@fullcalendar/react'
import dayGridPlugin from '@fullcalendar/daygrid'
import dayjs from 'dayjs'
import esLocale from '@fullcalendar/core/locales/es'
import { BaseForm } from '../components/BaseForm'
import { ModalDelete } from '../components/ModalDelete'
import Loading from '../components/Loading'
import { useModal } from '../hooks/useModal'
import { useCalendario } from '../hooks/useCalendario'
import { useCatalogLoaders } from '../hooks/useCatalogLoaders'
import { useAuth } from '../context/AuthContext'

import 'dayjs/locale/es'
import { FormCalendario } from '../components/modals/FormCalendario'
import { hasPermission } from '../helpers/permissions'
dayjs.locale('es')

export default function CalendarioPage() {
  const { user } = useAuth()

  const [eventoSeleccionado, setEventoSeleccionado] = useState(null)
  const { data, isLoading, isError, error, handleSubmit, handleDelete } =
    useCalendario()

  const {
    openModal,
    modalType,
    add,
    closeModal,
    formData,
    currentItem,
    view,
    handleInputChange
  } = useModal()

  const { loadOptionsUsuarios } = useCatalogLoaders()

  const eventos = useMemo(() => {
    return data?.map((evento) => ({
      id: evento.id,
      title: evento.titulo,
      start: evento.fecha_hora,
      extendedProps: {
        id: evento.id,
        creador_id: evento.creador_id,
        invitado_id: evento.invitado_id,
        titulo: evento.titulo,
        descripcion: evento.descripcion,
        notas: evento.notas,
        fecha_hora: evento.fecha_hora
      }
    }))
  }, [data])

  if (isError) return <div>{error.message}</div>
  if (isLoading) return <Loading />

  function Evento(arg) {
    const { titulo, invitado_id } = arg.event.extendedProps
    const esParaMi = user.id === invitado_id?.value

    return (
      <div
        className={`flex items-center gap-1.5 px-2 py-1 mx-0.5 rounded-md text-xs font-medium text-white shadow-sm transition-opacity hover:opacity-90 overflow-hidden cursor-pointer ${
          esParaMi ? 'bg-green-600' : 'bg-blue-600'
        }`}
      >
        <CalendarClock className='w-3.5 h-3.5 shrink-0' />
        <span className='truncate'>{titulo}</span>
      </div>
    )
  }

  function handleEventClick(clickInfo) {
    setEventoSeleccionado(clickInfo.event)
  }

  return (
    <>
      <div className='mb-4 bg-white rounded-md shadow p-4'>
        {hasPermission(user, '/calendario', 'crear') && (
          <div className='flex justify-center mb-4'>
            <button
              onClick={() => openModal('add')}
              className='cursor-pointer flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-dark hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-dark'
            >
              <Plus className='h-5 w-5 mr-2' />
              Agregar evento
            </button>
          </div>
        )}
        <div className='flex flex-col md:flex-row gap-4 justify-center items-center'>
          <div className='flex items-center gap-1'>
            <div className='bg-green-600 w-5 h-5 rounded-md' />
            <p className='text-gray-700'>Evento para ti</p>
          </div>
          <div className='flex items-center gap-1'>
            <div className='bg-blue-600 w-5 h-5 rounded-md' />
            <p className='text-gray-700'>Evento creado por ti</p>
          </div>
        </div>
      </div>

      <FullCalendar
        plugins={[dayGridPlugin]}
        initialView='dayGridMonth'
        events={eventos}
        eventContent={Evento}
        eventClick={handleEventClick}
        height='auto'
        locale={esLocale}
      />

      {eventoSeleccionado && (
        <div className='fixed inset-0 flex items-center justify-center z-50 bg-gray-900/50 backdrop-blur-sm p-4 transition-all'>
          <div className='bg-white p-6 rounded-2xl shadow-2xl w-full max-w-md relative'>
            <button
              className='absolute top-4 right-4 text-gray-400 hover:text-gray-700 hover:bg-gray-100 p-1.5 rounded-full transition-colors cursor-pointer'
              onClick={() => setEventoSeleccionado(null)}
            >
              <X className='w-5 h-5' />
            </button>

            <div className='mb-6 mt-2'>
              <span className='inline-block bg-blue-50 text-blue-700 font-semibold text-xs px-2.5 py-1 rounded-md mb-3 border border-blue-100'>
                {eventoSeleccionado.title}
              </span>

              <h3 className='font-bold text-xl text-gray-900 mb-3 leading-tight'>
                {eventoSeleccionado.extendedProps.descripcion}
              </h3>

              <div className='flex items-center gap-2 bg-gray-50 text-gray-700 text-sm p-3 rounded-lg mb-4 border border-gray-100'>
                <CalendarClock className='w-4 h-4 text-gray-500 shrink-0' />
                {dayjs(eventoSeleccionado.extendedProps.fecha_hora).format(
                  'D [de] MMMM YYYY, h:mm A'
                )}
              </div>

              <div className='text-gray-600 text-sm whitespace-pre-line border-l-2 border-gray-200 pl-3'>
                {eventoSeleccionado.extendedProps.notas ||
                  'Sin notas adicionales.'}
              </div>
            </div>

            <div className='flex gap-3 justify-end pt-4 border-t border-gray-100'>
              {hasPermission(user, '/calendario', 'actualizar') && (
                <button
                  title='Editar registro'
                  onClick={() => {
                    setEventoSeleccionado(null)
                    openModal('edit', eventoSeleccionado.extendedProps)
                  }}
                  className='flex items-center justify-center gap-2 px-4 py-2 bg-green-50 text-green-700 hover:bg-green-600 hover:text-white rounded-lg text-sm font-medium transition-colors cursor-pointer'
                >
                  <Edit className='w-4 h-4' /> Editar
                </button>
              )}

              {hasPermission(user, '/calendario', 'eliminar') && (
                <button
                  title='Eliminar registro'
                  onClick={() => {
                    setEventoSeleccionado(null)
                    openModal('delete', eventoSeleccionado.extendedProps)
                  }}
                  className='flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white rounded-lg text-sm font-medium transition-colors cursor-pointer'
                >
                  <Trash2 className='w-4 h-4' /> Eliminar
                </button>
              )}
            </div>
          </div>
        </div>
      )}
      {(modalType === 'add' ||
        modalType === 'edit' ||
        modalType === 'view') && (
        <BaseForm
          handleSubmit={handleSubmit}
          view={view}
          add={add}
          closeModal={closeModal}
          Inputs={
            <FormCalendario
              view={view}
              formData={formData}
              handleInputChange={handleInputChange}
              loadOptionsUsuarios={loadOptionsUsuarios}
            />
          }
        />
      )}

      {modalType === 'delete' && currentItem && (
        <ModalDelete
          handleDelete={handleDelete}
          closeModal={closeModal}
          formData={formData}
        />
      )}
    </>
  )
}
