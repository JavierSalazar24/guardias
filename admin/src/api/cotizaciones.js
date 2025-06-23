import dayjs from 'dayjs'
import { apiClient, apiClientForm } from './configAxios'

// Crear un registro
export const createCotizacion = async (data) => {
  try {
    const formData = new FormData()

    // Si existe cliente aquí se manda
    if (data?.cliente_id) formData.append('cliente_id', data?.cliente_id)
    if (data?.sucursal_id) formData.append('sucursal_id', data?.sucursal_id)

    // Si no existe cliente aquí se manda
    if (data?.nombre_contacto)
      formData.append('nombre_contacto', data?.nombre_contacto)
    if (data?.correo_contacto)
      formData.append('correo_contacto', data?.correo_contacto)
    if (data?.telefono_contacto)
      formData.append('telefono_contacto', data?.telefono_contacto)
    if (data?.whatsapp_contacto)
      formData.append('whatsapp_contacto', data?.whatsapp_contacto)
    if (data?.nombre_empresa)
      formData.append('nombre_empresa', data?.nombre_empresa)
    if (data?.calle) formData.append('calle', data?.calle)
    if (data?.numero) formData.append('numero', data?.numero)
    if (data?.colonia) formData.append('colonia', data?.colonia)
    if (data?.estado) formData.append('estado', data?.estado)
    if (data?.municipio) formData.append('municipio', data?.municipio)
    if (data?.cp) formData.append('cp', data?.cp)
    if (data?.pais) formData.append('pais', data?.pais)
    if (data?.telefono_empresa)
      formData.append('telefono_empresa', data?.telefono_empresa)
    if (data?.extension_empresa)
      formData.append('extension_empresa', data?.extension_empresa)
    if (data?.rfc) formData.append('rfc', data?.rfc)
    if (data?.razon_social) formData.append('razon_social', data?.razon_social)
    if (data?.uso_cfdi) formData.append('uso_cfdi', data?.uso_cfdi)
    if (data?.regimen_fiscal)
      formData.append('regimen_fiscal', data?.regimen_fiscal)
    if (data.situacion_fiscal instanceof File) {
      formData.append('situacion_fiscal', data.situacion_fiscal)
    }

    // Datos obligatorios
    formData.append('sucursal_empresa_id', data.sucursal_empresa_id)
    formData.append('credito_dias', data.credito_dias)
    formData.append('servicios', data.servicios)
    formData.append('guardias_dia', data.guardias_dia)
    formData.append('precio_guardias_dia', data.precio_guardias_dia)
    formData.append('precio_guardias_dia_total', data.precio_guardias_dia_total)
    formData.append('guardias_noche', data.guardias_noche)
    formData.append('precio_guardias_noche', data.precio_guardias_noche)
    formData.append(
      'precio_guardias_noche_total',
      data.precio_guardias_noche_total
    )
    formData.append('cantidad_guardias', data.cantidad_guardias)
    formData.append('jefe_turno', data.jefe_turno)
    if (data?.precio_jefe_turno)
      formData.append('precio_jefe_turno', data?.precio_jefe_turno)
    formData.append('supervisor', data.supervisor)
    if (data?.precio_supervisor)
      formData.append('precio_supervisor', data?.precio_supervisor)
    formData.append('fecha_servicio', data.fecha_servicio)

    if (data?.requisitos_pago_cliente)
      formData.append('requisitos_pago_cliente', data?.requisitos_pago_cliente)
    formData.append('soporte_documental', data.soporte_documental)
    if (data?.observaciones_soporte_documental)
      formData.append(
        'observaciones_soporte_documental',
        data?.observaciones_soporte_documental
      )

    formData.append('impuesto', data.impuesto)
    formData.append('subtotal', data.subtotal)
    if (data?.descuento_porcentaje)
      formData.append('descuento_porcentaje', data?.descuento_porcentaje)
    if (data?.costo_extra) formData.append('costo_extra', data?.costo_extra)
    formData.append('total', data.total)
    if (data?.notas) formData.append('notas', data?.notas)

    const response = await apiClientForm.post('cotizaciones', formData)
    return response.data
  } catch (error) {
    console.error('Error al crear el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Leer registros
export const getCotizacion = async () => {
  try {
    const response = await apiClient.get('cotizaciones')
    const { data } = response

    const newData = Array.isArray(data)
      ? data.map((cotizacion) => {
          const cliente_existente = !!cotizacion.sucursal

          const nombre_contacto = cliente_existente
            ? cotizacion.sucursal.nombre_contacto
            : cotizacion.nombre_contacto
          const nombre_empresa = cliente_existente
            ? cotizacion.sucursal.nombre_empresa
            : cotizacion.nombre_empresa

          const clienteEmpresa = cotizacion.sucursal?.cliente
            ? cotizacion.sucursal.cliente.nombre_empresa
            : ''
          const clienteId = cotizacion.sucursal?.cliente
            ? cotizacion.sucursal.cliente.id
            : ''

          const cliente_id = cliente_existente
            ? { label: clienteEmpresa, value: clienteId }
            : { label: '', value: '' }

          const sucursal_id = cliente_existente ? cotizacion.sucursal.id : ''

          return {
            ...cotizacion,
            cliente_existente,
            cliente_id,
            sucursal_id,
            nombre_contacto,
            nombre_empresa,
            fecha_servicio_format: dayjs(cotizacion.fecha_servicio).format(
              'DD/MM/YYYY'
            ),
            total_servicio: `$${cotizacion.total}`,

            tipo_pago: cotizacion?.venta?.tipo_pago || null,
            metodo_pago: cotizacion?.venta?.metodo_pago || null,
            numero_factura: cotizacion?.venta?.numero_factura || null,
            fecha_emision: cotizacion?.venta?.fecha_emision || null,
            nota_credito: cotizacion?.venta?.nota_credito || null,
            sucursal_empresa_id: {
              label: cotizacion.sucursal_empresa.nombre_sucursal,
              value: cotizacion.sucursal_empresa.id
            }
          }
        })
      : []

    return newData
  } catch (error) {
    console.error('Error al obetener el registro', error)
    throw new Error(error.response.data.message)
  }
}

// Actualizar un registro
export const updateCotizacion = async (data) => {
  try {
    const { id } = data
    const formData = new FormData()
    formData.append('_method', 'PUT')

    // Si existe cliente aquí se manda
    if (data?.cliente_id) formData.append('cliente_id', data?.cliente_id)
    if (data?.sucursal_id) formData.append('sucursal_id', data?.sucursal_id)

    // Si no existe cliente aquí se manda
    if (data?.nombre_contacto)
      formData.append('nombre_contacto', data?.nombre_contacto)
    if (data?.correo_contacto)
      formData.append('correo_contacto', data?.correo_contacto)
    if (data?.telefono_contacto)
      formData.append('telefono_contacto', data?.telefono_contacto)
    if (data?.whatsapp_contacto)
      formData.append('whatsapp_contacto', data?.whatsapp_contacto)
    if (data?.nombre_empresa)
      formData.append('nombre_empresa', data?.nombre_empresa)
    if (data?.calle) formData.append('calle', data?.calle)
    if (data?.numero) formData.append('numero', data?.numero)
    if (data?.colonia) formData.append('colonia', data?.colonia)
    if (data?.estado) formData.append('estado', data?.estado)
    if (data?.municipio) formData.append('municipio', data?.municipio)
    if (data?.cp) formData.append('cp', data?.cp)
    if (data?.pais) formData.append('pais', data?.pais)
    if (data?.telefono_empresa)
      formData.append('telefono_empresa', data?.telefono_empresa)
    if (data?.extension_empresa)
      formData.append('extension_empresa', data?.extension_empresa)
    if (data?.rfc) formData.append('rfc', data?.rfc)
    if (data?.razon_social) formData.append('razon_social', data?.razon_social)
    if (data?.uso_cfdi) formData.append('uso_cfdi', data?.uso_cfdi)
    if (data?.regimen_fiscal)
      formData.append('regimen_fiscal', data?.regimen_fiscal)
    if (data.situacion_fiscal instanceof File) {
      formData.append('situacion_fiscal', data.situacion_fiscal)
    }

    // Datos obligatorios
    formData.append('sucursal_empresa_id', data.sucursal_empresa_id)
    formData.append('credito_dias', data.credito_dias)
    formData.append('servicios', data.servicios)
    formData.append('guardias_dia', data.guardias_dia)
    formData.append('precio_guardias_dia', data.precio_guardias_dia)
    formData.append('precio_guardias_dia_total', data.precio_guardias_dia_total)
    formData.append('guardias_noche', data.guardias_noche)
    formData.append('precio_guardias_noche', data.precio_guardias_noche)
    formData.append(
      'precio_guardias_noche_total',
      data.precio_guardias_noche_total
    )
    formData.append('cantidad_guardias', data.cantidad_guardias)
    formData.append('jefe_turno', data.jefe_turno)
    if (data?.precio_jefe_turno)
      formData.append('precio_jefe_turno', data?.precio_jefe_turno)
    formData.append('supervisor', data.supervisor)
    if (data?.precio_supervisor)
      formData.append('precio_supervisor', data?.precio_supervisor)
    formData.append('fecha_servicio', data.fecha_servicio)

    if (data?.requisitos_pago_cliente)
      formData.append('requisitos_pago_cliente', data?.requisitos_pago_cliente)
    formData.append('soporte_documental', data.soporte_documental)
    if (data?.observaciones_soporte_documental)
      formData.append(
        'observaciones_soporte_documental',
        data?.observaciones_soporte_documental
      )

    formData.append('impuesto', data.impuesto)
    formData.append('subtotal', data.subtotal)
    if (data?.descuento_porcentaje)
      formData.append('descuento_porcentaje', data?.descuento_porcentaje)
    if (data?.costo_extra) formData.append('costo_extra', data?.costo_extra)
    formData.append('total', data.total)
    if (data?.notas) formData.append('notas', data?.notas)

    // Si la cotización fue aceptada
    formData.append('aceptada', data.aceptada)
    if (data?.tipo_pago) formData.append('tipo_pago', data?.tipo_pago)
    if (data?.metodo_pago) formData.append('metodo_pago', data?.metodo_pago)
    if (data?.numero_factura)
      formData.append('numero_factura', data?.numero_factura)
    if (data?.fecha_emision)
      formData.append('fecha_emision', data?.fecha_emision)
    if (data?.nota_credito) formData.append('nota_credito', data?.nota_credito)

    const response = await apiClientForm.post(`cotizaciones/${id}`, formData)
    return response.data
  } catch (error) {
    console.error('Error al actualizar registro:', error)
    throw new Error(error.response.data.message)
  }
}

// Eliminar un registro
export const removeCotizacion = async (id) => {
  try {
    const response = await apiClient.delete(`cotizaciones/${id}`)
    return response.data
  } catch (error) {
    console.error('Error al eliminar registro:', error)
    throw new Error(error.response.data.message)
  }
}
