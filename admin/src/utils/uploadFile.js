import { ref, uploadBytes, getDownloadURL } from 'firebase/storage'
import { storage } from '../api/db/firebaseConfig'

export const uploadFileToFirebase = async (file, path) => {
  if (!file) return null

  try {
    const fileName = `${path}/${crypto.randomUUID()}_${file.name}`
    const storageRef = ref(storage, fileName)

    await uploadBytes(storageRef, file)

    return await getDownloadURL(storageRef)
  } catch (error) {
    console.error('Error al subir archivo:', error)
    throw error
  }
}

export const uploadFoto = async (data) => {
  const nombre = `${data.nombre} ${data.apellido_p} ${data.apellido_m}`
  const path = `guardias/fotos de perfil/${nombre}`
  return await uploadFileToFirebase(data.foto, path)
}

export const uploadCurp = async (data) => {
  const nombre = `${data.nombre} ${data.apellido_p} ${data.apellido_m}`
  const path = `guardias/documentos/${nombre}_curp`
  return await uploadFileToFirebase(data.curp, path)
}

export const uploadIne = async (data) => {
  const nombre = `${data.nombre} ${data.apellido_p} ${data.apellido_m}`
  const path = `guardias/documentos/${nombre}_ine`
  return await uploadFileToFirebase(data.ine, path)
}

export const uploadActaNacimiento = async (data) => {
  const nombre = `${data.nombre} ${data.apellido_p} ${data.apellido_m}`
  const path = `guardias/documentos/${nombre}_acta_nacimiento`
  return await uploadFileToFirebase(data.acta_nacimiento, path)
}

export const uploadComprobanteDomicilio = async (data) => {
  const nombre = `${data.nombre} ${data.apellido_p} ${data.apellido_m}`
  const path = `guardias/documentos/${nombre}_comprobante_domicilio`
  return await uploadFileToFirebase(data.comprobante_domicilio, path)
}
