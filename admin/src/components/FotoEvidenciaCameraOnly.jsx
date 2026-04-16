import { useEffect, useRef, useState } from 'react'
import { AlertaCard } from './AlertaCard'

export const FotoEvidenciaCameraOnly = ({
  text = 'Evidencia',
  name = 'evidencia',
  view,
  formData,
  document,
  onCapture
}) => {
  const videoRef = useRef(null)
  const canvasRef = useRef(null)
  const streamRef = useRef(null)

  const [cameraError, setCameraError] = useState('')
  const [loadingCamera, setLoadingCamera] = useState(false)

  useEffect(() => {
    if (view) return

    const startCamera = async () => {
      try {
        setLoadingCamera(true)
        setCameraError('')

        const stream = await navigator.mediaDevices.getUserMedia({
          video: {
            facingMode: { ideal: 'environment' }
          },
          audio: false
        })

        streamRef.current = stream

        if (videoRef.current) {
          videoRef.current.srcObject = stream
        }
      } catch (error) {
        console.error(error)
        setCameraError('No se pudo acceder a la cámara.')
      } finally {
        setLoadingCamera(false)
      }
    }

    startCamera()

    return () => {
      if (streamRef.current) {
        streamRef.current.getTracks().forEach((track) => track.stop())
      }
    }
  }, [view])

  const takePhoto = () => {
    const video = videoRef.current
    const canvas = canvasRef.current
    if (!video || !canvas) return

    canvas.width = video.videoWidth
    canvas.height = video.videoHeight

    const ctx = canvas.getContext('2d')
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height)

    canvas.toBlob(
      (blob) => {
        if (!blob) return

        const file = new File([blob], `${name}-${Date.now()}.jpg`, {
          type: 'image/jpeg'
        })

        onCapture(name, file)
      },
      'image/jpeg',
      0.9
    )
  }

  return (
    <>
      <div className='sm:col-span-6 md:col-span-2'>
        <AlertaCard text={text} />
      </div>

      <div className='sm:col-span-6 md:col-span-2 sm:w-96 mx-auto'>
        {formData.preview || document ? (
          <div className='border rounded-lg p-4'>
            <img
              src={
                formData.preview ||
                formData?.foto_url ||
                formData?.evidencia_url
              }
              alt='Evidencia'
              className='max-h-60 mx-auto rounded-md object-contain'
            />
          </div>
        ) : (
          <div className='border rounded-lg p-4'>
            {!view && (
              <>
                <div className='rounded-lg overflow-hidden bg-black'>
                  <video
                    ref={videoRef}
                    autoPlay
                    playsInline
                    muted
                    className='w-full h-auto'
                  />
                </div>

                <canvas ref={canvasRef} className='hidden' />

                {loadingCamera && (
                  <p className='text-sm text-gray-500 mt-3'>
                    Abriendo cámara...
                  </p>
                )}

                {cameraError && (
                  <p className='text-sm text-red-500 mt-3'>{cameraError}</p>
                )}

                <button
                  type='button'
                  onClick={takePhoto}
                  className='mt-4 w-full rounded-lg bg-blue-600 text-white py-2 px-4 hover:bg-blue-700'
                  disabled={loadingCamera || !!cameraError}
                >
                  Tomar foto
                </button>
              </>
            )}
          </div>
        )}
      </div>
    </>
  )
}
