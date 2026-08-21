import { useEffect } from 'react'

type Props = {
  message: string | null
  onDismiss: () => void
}

/** Short-lived status for Save / calendar actions. */
export function Toast({ message, onDismiss }: Props) {
  useEffect(() => {
    if (!message) return
    const id = window.setTimeout(onDismiss, 2800)
    return () => window.clearTimeout(id)
  }, [message, onDismiss])

  if (!message) return null

  return (
    <div
      role="status"
      aria-live="polite"
      className="fixed bottom-4 left-1/2 z-50 max-w-[min(92vw,24rem)] -translate-x-1/2 rounded-xl bg-ink px-4 py-3 text-center text-sm font-medium text-white shadow-soft"
    >
      {message}
    </div>
  )
}
