import { z } from 'zod'

export const sucursalEmpresaSchema = z.object({
  nombre_contacto: z
    .string({ required_error: 'El nombre de contacto es requerido' })
    .min(1, 'El nombre de contacto es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre de contacto solo puede contener letras'
    ),
  telefono_contacto: z
    .string({ required_error: 'El teléfono de contacto es requerido' })
    .min(10, 'El teléfono de contacto debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de contacto debe tener máximo 15 dígitos'),
  correo_contacto: z
    .string({ required_error: 'El correo de contacto es requerido' })
    .email('El correo de contacto no es válido'),
  cp: z.preprocess(
    (val) =>
      typeof val === 'number' ? String(val).padStart(5, '0') : String(val),
    z
      .string({
        required_error: 'El código postal es requerido',
        invalid_type_error: 'El código postal debe ser un string válido'
      })
      .regex(/^\d{5}$/, {
        message: 'El código postal debe tener exactamente 5 dígitos'
      })
  ),
  telefono_sucursal: z
    .string({ required_error: 'El teléfono de la sucursal es requerido' })
    .min(10, 'El teléfono de la sucursal debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de la sucursal debe tener máximo 15 dígitos')
})

export const guardiaSchema = z.object({
  nombre: z
    .string({ required_error: 'El nombre del guardia es requerido' })
    .min(1, 'El nombre del guardia es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre del guardia solo puede contener letras'
    ),
  apellido_p: z
    .string({ required_error: 'El apellido paterno es requerido' })
    .min(1, 'El apellido paterno es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El apellido paterno solo puede contener letras'
    ),
  apellido_m: z
    .string({ required_error: 'El apellido materno es requerido' })
    .min(1, 'El apellido materno es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El apellido materno solo puede contener letras'
    ),
  edad: z.coerce
    .number({
      required_error: 'La edad es requerida',
      invalid_type_error: 'La edad debe ser un número válido'
    })
    .int()
    .gte(18, { message: 'La edad debe estar entre 18 y 99 años' })
    .lte(99, { message: 'La edad debe estar entre 18 y 99 años' }),
  telefono: z
    .string({ required_error: 'El teléfono del guardia es requerido' })
    .min(10, 'El teléfono del guardia debe tener al menos 10 dígitos')
    .max(15, 'El teléfono del guardia debe tener máximo 15 dígitos'),
  correo: z
    .string({ required_error: 'El correo del guardia es requerido' })
    .email('El correo del guardia no es válido'),
  cp: z.preprocess(
    (val) =>
      typeof val === 'number' ? String(val).padStart(5, '0') : String(val),
    z
      .string({
        required_error: 'El código postal es requerido',
        invalid_type_error: 'El código postal debe ser un string válido'
      })
      .regex(/^\d{5}$/, {
        message: 'El código postal debe tener exactamente 5 dígitos'
      })
  ),
  telefono_emergencia: z
    .string({ required_error: 'El teléfono de emergencia es requerido' })
    .min(10, 'El teléfono de emergencia debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de emergencia debe tener máximo 15 dígitos'),
  contacto_emergencia: z
    .string({
      required_error: 'El nombre del contacto de emergencia es requerido'
    })
    .min(1, 'El nombre del contacto de emergencia es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre del contacto de emergencia solo puede contener letras'
    )
})

export const clienteSchema = z.object({
  nombre_contacto_admin: z
    .string({
      required_error: 'El nombre del contacto administrativo es requerido'
    })
    .min(1, 'El nombre del contacto administrativo es requerido')
    .regex(/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/, 'El nombre solo puede contener letras'),
  telefono_contacto_admin: z
    .string({
      required_error: 'El teléfono del contacto administrativo es requerido'
    })
    .min(
      10,
      'El teléfono del contacto administrativo debe tener al menos 10 dígitos'
    )
    .max(
      15,
      'El teléfono del contacto administrativo debe tener máximo 15 dígitos'
    ),
  correo_contacto_admin: z
    .string({
      required_error: 'El correo del contacto administrativo es requerido'
    })
    .email('El correo del contacto administrativo no es válido'),

  nombre_contacto_opera: z
    .string({ required_error: 'El nombre del contacto operativo es requerido' })
    .min(1, 'El nombre del contacto operativo es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre del contacto operativo solo puede contener letras'
    ),
  telefono_contacto_opera: z
    .string({
      required_error: 'El teléfono del contacto operativo es requerido'
    })
    .min(
      10,
      'El teléfono del contacto operativo debe tener al menos 10 dígitos'
    )
    .max(15, 'El teléfono del contacto operativo debe tener máximo 15 dígitos'),
  correo_contacto_opera: z
    .string({ required_error: 'El correo del contacto operativo es requerido' })
    .email('El correo del contacto operativo no es válido'),

  cp: z.preprocess(
    (val) =>
      typeof val === 'number' ? String(val).padStart(5, '0') : String(val),
    z
      .string({
        required_error: 'El código postal es requerido',
        invalid_type_error: 'El código postal debe ser un string válido'
      })
      .regex(/^\d{5}$/, {
        message: 'El código postal debe tener exactamente 5 dígitos'
      })
  ),
  telefono_empresa: z
    .string({ required_error: 'El teléfono de la empresa es requerido' })
    .min(10, 'El teléfono de la empresa debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de la empresa debe tener máximo 15 dígitos'),
  rfc: z
    .string({ required_error: 'El RFC es requerida' })
    .min(12, 'El RFC debe tener mínimo 12 caracteres')
    .max(13, 'El RFC debe tener máximo 13 caracteres')
})

export const sucursalClienteSchema = z.object({
  nombre_contacto: z
    .string({ required_error: 'El nombre de contacto es requerido' })
    .min(1, 'El nombre de contacto es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre de contacto solo puede contener letras'
    ),
  telefono_contacto: z
    .string({ required_error: 'El teléfono de contacto es requerido' })
    .min(10, 'El teléfono de contacto debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de contacto debe tener máximo 15 dígitos'),
  correo_contacto: z
    .string({ required_error: 'El correo de contacto es requerido' })
    .email('El correo de contacto no es válido'),
  cp: z.preprocess(
    (val) =>
      typeof val === 'number' ? String(val).padStart(5, '0') : String(val),
    z
      .string({
        required_error: 'El código postal es requerido',
        invalid_type_error: 'El código postal debe ser un string válido'
      })
      .regex(/^\d{5}$/, {
        message: 'El código postal debe tener exactamente 5 dígitos'
      })
  ),
  telefono_empresa: z
    .string({ required_error: 'El teléfono de la sucursal es requerido' })
    .min(10, 'El teléfono de la sucursal debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de la sucursal debe tener máximo 15 dígitos'),
  rfc: z
    .string({ required_error: 'El RFC es requerida' })
    .min(12, 'El RFC debe tener mínimo 12 caracteres')
    .max(13, 'El RFC debe tener máximo 13 caracteres')
})

export const proveedorSchema = z.object({
  nombre_contacto: z
    .string({ required_error: 'El nombre de contacto es requerido' })
    .min(1, 'El nombre de contacto es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre de contacto solo puede contener letras'
    ),
  telefono_contacto: z
    .string({ required_error: 'El teléfono de contacto es requerido' })
    .min(10, 'El teléfono de contacto debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de contacto debe tener máximo 15 dígitos'),
  correo_contacto: z
    .string({ required_error: 'El correo de contacto es requerido' })
    .email('El correo de contacto no es válido'),
  cp: z.preprocess(
    (val) =>
      typeof val === 'number' ? String(val).padStart(5, '0') : String(val),
    z
      .string({
        required_error: 'El código postal es requerido',
        invalid_type_error: 'El código postal debe ser un string válido'
      })
      .regex(/^\d{5}$/, {
        message: 'El código postal debe tener exactamente 5 dígitos'
      })
  ),
  telefono_empresa: z
    .string({ required_error: 'El teléfono de la empresa es requerido' })
    .min(10, 'El teléfono de la empresa debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de la empresa debe tener máximo 15 dígitos'),
  rfc: z
    .string({ required_error: 'El RFC es requerida' })
    .min(12, 'El RFC debe tener mínimo 12 caracteres')
    .max(13, 'El RFC debe tener máximo 13 caracteres')
})

export const cotizacionSchema = z.object({
  nombre_contacto: z
    .string({ required_error: 'El nombre de contacto es requerido' })
    .min(1, 'El nombre de contacto es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre de contacto solo puede contener letras'
    )
    .optional(),
  telefono_contacto: z
    .string({ required_error: 'El teléfono de contacto es requerido' })
    .min(10, 'El teléfono de contacto debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de contacto debe tener máximo 15 dígitos')
    .optional(),
  correo_contacto: z
    .string({ required_error: 'El correo de contacto es requerido' })
    .email('El correo no es válido')
    .optional(),
  cp: z
    .preprocess(
      (val) =>
        typeof val === 'number' ? String(val).padStart(5, '0') : String(val),
      z
        .string({
          required_error: 'El código postal es requerido',
          invalid_type_error: 'El código postal debe ser un string válido'
        })
        .regex(/^\d{5}$/, {
          message: 'El código postal debe tener exactamente 5 dígitos'
        })
    )
    .optional(),
  telefono_empresa: z
    .string({ required_error: 'El teléfono de la empresa es requerido' })
    .min(10, 'El teléfono de la empresa debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de la empresa debe tener máximo 15 dígitos')
    .optional(),
  rfc: z
    .string({ required_error: 'El RFC es requerida' })
    .min(12, 'El RFC debe tener mínimo 12 caracteres')
    .max(13, 'El RFC debe tener máximo 13 caracteres')
    .optional()
})

export const ordenServicioSchema = z.object({
  nombre_responsable_sitio: z
    .string({ required_error: 'El nombre de contacto es requerido' })
    .min(1, 'El nombre de contacto es requerido')
    .regex(
      /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/,
      'El nombre de contacto solo puede contener letras'
    )
    .optional(),
  telefono_responsable_sitio: z
    .string({ required_error: 'El teléfono de contacto es requerido' })
    .min(10, 'El teléfono de contacto debe tener al menos 10 dígitos')
    .max(15, 'El teléfono de contacto debe tener máximo 15 dígitos')
    .optional()
})

export const usuarioSchema = z.object({
  nombre_completo: z
    .string({ required_error: 'El nombre es requerido' })
    .min(1, 'El nombre es requerido')
    .regex(/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/, 'El nombre solo puede contener letras'),

  email: z
    .string({ required_error: 'El correo es requerido' })
    .email('El correo no es válido'),
  password: z
    .string({ required_error: 'La contraseña es requerida' })
    .min(6, { message: 'La contraseña debe tener al menos 6 caracteres' })
    .optional()
})
