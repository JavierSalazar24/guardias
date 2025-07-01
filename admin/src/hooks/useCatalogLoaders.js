// hooks/useCatalogLoaders.js

import { getCliente } from '../api/clientes'
import { getBanco } from '../api/bancos'
import { getProveedor } from '../api/proveedores'
import { getArticulo } from '../api/articulos'
import { getCotizacion } from '../api/cotizaciones'
import { getVentaOrdenServicio } from '../api/ventas'
import {
  getGuardias,
  getGuardiasBySucursal,
  getSupervisores
} from '../api/guardias'
import { getRol } from '../api/roles'
import { getModulo } from '../api/modulos'
import { getPrestamoPendiente } from '../api/prestamos'
import { getSucursalEmpresa } from '../api/sucursales-empresa'
import { getModuloDescuento } from '../api/modulo-descuentos'
import { getModuloPrestamo } from '../api/modulo-prestamos'
import { getVehiculo } from '../api/vehiculos'
import { getOrdenServicio } from '../api/ordenes-servicios'
import { getModuloConcepto } from '../api/modulo-conceptos'
import { getSucursalByCliente } from '../api/sucursales'
import { getAlmacenDisponibles } from '../api/almacen'
import { getTipoServicio } from '../api/tipos-servicios'
import { toFloat } from '../utils/numbers'

// Loader genérico simple (label normal)
function genericLoader(getter, labelKey) {
  let cache = null
  return async (inputValue) => {
    if (!cache) cache = await getter()
    const filtered = cache.filter((item) =>
      (item[labelKey] ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase())
    )
    return filtered.map((item) => ({
      value: item.id,
      label: item[labelKey]
    }))
  }
}

// Loader para etiquetas compuestas o lógica custom
function customLoader(getter, filterFn, mapFn) {
  let cache = null
  return async (inputValue) => {
    if (!cache) cache = await getter()
    const filtered = cache.filter((item) => filterFn(item, inputValue))
    return filtered.map(mapFn)
  }
}

// Todos los loaders simples y compuestos:
export const useCatalogLoaders = () => ({
  loadOptionsBancos: genericLoader(getBanco, 'nombre'),
  loadOptionsProveedores: genericLoader(getProveedor, 'nombre_empresa'),
  loadOptionsArticulos: genericLoader(getArticulo, 'nombre'),
  loadOptionsCotizaciones: genericLoader(getCotizacion, 'nombre_empresa'),
  loadOptionsSucursalesEmpresa: genericLoader(
    getSucursalEmpresa,
    'nombre_sucursal'
  ),
  loadOptionsModuloConcepto: genericLoader(getModuloConcepto, 'nombre'),
  loadOptionsModuloDescuento: genericLoader(getModuloDescuento, 'nombre'),
  loadOptionsModuloPrestamo: genericLoader(getModuloPrestamo, 'nombre'),
  loadOptionsRoles: genericLoader(getRol, 'nombre'),
  loadOptionsModulos: genericLoader(getModulo, 'nombre'),
  loadOptionsOrdenServicio: genericLoader(
    getOrdenServicio,
    'codigo_orden_servicio'
  ),
  // Etiquetas compuestas:
  loadOptionsVehiculos: customLoader(
    getVehiculo,
    (data, inputValue) =>
      (data.tipo_vehiculo ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.placas ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: `${data.tipo_vehiculo} (${data.placas})`
    })
  ),
  loadOptionsPrestamos: customLoader(
    getPrestamoPendiente,
    (data, inputValue) =>
      (data.nombre ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.monto_total_format ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: `${data.nombre} (${data.monto_total_format})`
    })
  ),
  loadOptionsClientes: customLoader(
    getCliente,
    (data, inputValue) =>
      (data.nombre_empresa ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: data.nombre_empresa,
      credito_dias: data.credito_dias
    })
  ),
  loadOptionsVentas: customLoader(
    getVentaOrdenServicio,
    (data, inputValue) =>
      (data.nombre_empresa ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.numero_factura ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: `${data.nombre_empresa} (${
        data?.numero_factura || 'SIN FACTURA'
      })`,
      direccion: data.direccion,
      jefe_turno: data.cotizacion?.jefe_turno,
      supervisor: data.cotizacion?.supervisor,
      fecha_servicio: data.fecha_servicio
    })
  ),
  loadOptionsTodosGuardias: customLoader(
    getGuardias,
    (data, inputValue) =>
      (data.nombre_completo ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.numero_empleado ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: `${data.nombre_completo} (${data.numero_empleado})`
    })
  ),
  loadOptionsGuardias: customLoader(
    getGuardias,
    (data, inputValue) =>
      (data.nombre_completo ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.numero_empleado ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: `${data.nombre_completo} (${data.numero_empleado})`
    })
  ),
  loadOptionsSupervisores: customLoader(
    getSupervisores,
    (data, inputValue) =>
      (data.nombre_completo ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.numero_empleado ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: `${data.nombre_completo} (${data.numero_empleado})`,
      numero_empleado: data.numero_empleado,
      email: data.correo,
      nombre_completo: data.nombre_completo
    })
  ),
  loadOptionsArticulosDisponibles: customLoader(
    getAlmacenDisponibles,
    (data, inputValue) =>
      (data.articulo.nombre ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()) ||
      (data.numero_serie ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.articulo.id,
      label: `${data.articulo.nombre} (${data.numero_serie})`,
      numero_serie: data.numero_serie
    })
  ),
  loadOptionsTiposServicios: customLoader(
    getTipoServicio,
    (data, inputValue) =>
      (data.nombre ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase()),
    (data) => ({
      value: data.id,
      label: data.nombre,
      costo: toFloat(data.costo)
    })
  )
})

// Loader contextual (factory) para guardias por sucursal
export const makeLoaderGuardiasBySucursal = (sucursalId) => {
  const cache = {}
  return async (inputValue) => {
    if (!sucursalId) return []
    if (!cache[sucursalId])
      cache[sucursalId] = await getGuardiasBySucursal(sucursalId)
    const all = cache[sucursalId]
    const filtered = all.filter(
      (g) =>
        (g.nombre_completo ?? '')
          .toLowerCase()
          .includes((inputValue ?? '').toLowerCase()) ||
        (g.numero_empleado ?? '')
          .toLowerCase()
          .includes((inputValue ?? '').toLowerCase())
    )
    return filtered.map((g) => ({
      value: g.id,
      label: `${g.nombre_completo} (${g.numero_empleado})`
    }))
  }
}

// Loader contextual (factory) para sucursales por cliente
export const makeLoaderSucursalesByCliente = (clienteId) => {
  const cache = {}
  return async (inputValue) => {
    if (!clienteId) return []
    if (!cache[clienteId])
      cache[clienteId] = await getSucursalByCliente(clienteId)
    const all = cache[clienteId]
    const filtered = all.filter((s) =>
      (s.nombre_empresa ?? '')
        .toLowerCase()
        .includes((inputValue ?? '').toLowerCase())
    )
    return filtered.map((s) => ({
      value: s.id,
      label: s.nombre_empresa
    }))
  }
}
