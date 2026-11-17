import type { ReactNode } from 'react'

export type IconName =
  | 'bus' | 'map' | 'cone' | 'search' | 'pin' | 'arrow' | 'swap'
  | 'clock' | 'walk' | 'route' | 'chevron' | 'layers' | 'locate'
  | 'warning' | 'close' | 'menu' | 'back' | 'calendar' | 'check'

export default function Icon({ name, size = 20, className = '' }: { name: IconName; size?: number; className?: string }) {
  const paths: Record<IconName, ReactNode> = {
    bus: <><path d="M5 16V6.8C5 4.7 6.8 3 9 3h6c2.2 0 4 1.7 4 3.8V16" /><path d="M5 11h14M8 7h8M7 16h10v3H7zM8 19v2M16 19v2" /><circle cx="8.5" cy="14" r=".8" fill="currentColor" stroke="none" /><circle cx="15.5" cy="14" r=".8" fill="currentColor" stroke="none" /></>,
    map: <><path d="m3 6 5-3 8 3 5-3v15l-5 3-8-3-5 3zM8 3v15M16 6v15" /></>,
    cone: <><path d="M8 18 12 3l4 15M6 18h12M9.3 13h5.4M10.5 8h3" /></>,
    search: <><circle cx="11" cy="11" r="7" /><path d="m16 16 5 5" /></>,
    pin: <><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="2.5" /></>,
    arrow: <><path d="M5 12h14M14 7l5 5-5 5" /></>,
    swap: <><path d="M7 7h11l-3-3M18 17H7l3 3" /></>,
    clock: <><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" /></>,
    walk: <><circle cx="13" cy="4" r="2" /><path d="m10 21 2-7-3-3 2-4 4 3 3 1M12 14l4 3 1 4" /></>,
    route: <><circle cx="6" cy="18" r="2" /><circle cx="18" cy="6" r="2" /><path d="M8 18h3a3 3 0 0 0 3-3v-6a3 3 0 0 1 3-3" /></>,
    chevron: <path d="m9 18 6-6-6-6" />,
    layers: <><path d="m12 3 9 5-9 5-9-5z" /><path d="m3 12 9 5 9-5M3 16l9 5 9-5" /></>,
    locate: <><circle cx="12" cy="12" r="4" /><path d="M12 2v3M12 19v3M2 12h3M19 12h3" /></>,
    warning: <><path d="M12 3 2.7 20h18.6z" /><path d="M12 9v4M12 17h.01" /></>,
    close: <path d="m6 6 12 12M18 6 6 18" />,
    menu: <><path d="M4 7h16M4 12h16M4 17h16" /></>,
    back: <><path d="M19 12H5M10 7l-5 5 5 5" /></>,
    calendar: <><rect x="3" y="5" width="18" height="16" rx="2" /><path d="M16 3v4M8 3v4M3 10h18" /></>,
    check: <path d="m5 12 4 4L19 6" />,
  }

  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className={className} aria-hidden="true">
      {paths[name]}
    </svg>
  )
}
