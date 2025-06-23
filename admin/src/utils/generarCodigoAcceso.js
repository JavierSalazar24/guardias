export const generarCodigoAcceso = (longitud = 8) => {
  const mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
  const minusculas = 'abcdefghijklmnopqrstuvwxyz'
  const numeros = '0123456789'
  const simbolos = '!@#$%^&*'

  const todos = mayusculas + minusculas + numeros + simbolos

  const valores = new Uint32Array(longitud)
  window.crypto.getRandomValues(valores)

  let password = [
    mayusculas[valores[0] % mayusculas.length],
    minusculas[valores[1] % minusculas.length],
    numeros[valores[2] % numeros.length],
    simbolos[valores[3] % simbolos.length]
  ]

  for (let i = 4; i < longitud; i++) {
    password.push(todos[valores[i] % todos.length])
  }

  return password.sort(() => 0.5 - Math.random()).join('')
}
