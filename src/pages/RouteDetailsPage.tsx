import type { Journey } from '../App'
import Icon from '../components/Icon'
import { displayPlace, routes } from '../data/transit'
import { useLanguage } from '../i18n/LanguageContext'

type Props = { routeId: number; journey: Journey; navigate: (path: string) => void }

export default function RouteDetailsPage({ routeId, journey, navigate }: Props) {
  const { language, t } = useLanguage()
  const route = routes.find((item) => item.id === routeId) ?? routes[0]
  const origin = encodeURIComponent(`${journey.from}, Dhaka, Bangladesh`)
  const destination = encodeURIComponent(`${journey.to}, Dhaka, Bangladesh`)
  const mapUrl = `https://www.google.com/maps?output=embed&saddr=${origin}&daddr=${destination}&travelmode=transit`
  const fullMapUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}&travelmode=transit`
  const localUnit = (value: string) => language === 'bn' ? value.replace('min', 'মিনিট').replace('km', 'কিমি') : value

  return (
    <section className="mx-auto max-w-[1500px] px-5 py-6 lg:px-8">
      <button onClick={() => navigate('/routes')} className="back-button"><Icon name="back" size={17} /> {t('backRoutes')}</button>
      <div className="mt-5 grid gap-5 lg:grid-cols-[370px_minmax(0,1fr)]">
        <aside className="rounded-[22px] border border-[#dce5e2] bg-white p-5 shadow-sm">
          <div className="flex items-start gap-3">
            <span className="grid h-12 w-12 place-items-center rounded-xl text-white" style={{ backgroundColor: route.color }}><Icon name="bus" size={24} /></span>
            <div><p className="eyebrow">{t('selectedBus')}</p><h1 className="text-xl font-extrabold">{route.bus}</h1><p className="mt-1 text-xs text-[#70827e]">{route.number} · {t('every')} {localUnit(route.frequency)}</p></div>
          </div>
          <div className="my-5 grid grid-cols-3 divide-x divide-[#e0e7e5] rounded-xl bg-[#f5f8f7] py-3">
            <span className="result-stat"><strong>{localUnit(route.duration)}</strong><small>{t('duration')}</small></span>
            <span className="result-stat"><strong>{localUnit(route.distance)}</strong><small>{t('distance')}</small></span>
            <span className="result-stat"><strong>৳{route.fare}</strong><small>{t('estFare')}</small></span>
          </div>
          <h2 className="text-sm font-extrabold">{t('stopsRoute')}</h2>
          <ol className="mt-4">
            {route.stops.map((stop, index) => (
              <li key={stop} className="flex min-h-14 gap-3">
                <span className="flex flex-col items-center"><span className="grid h-7 w-7 place-items-center rounded-full border-2 border-[#087f5b] bg-white text-[10px] font-extrabold text-[#087f5b]">{index + 1}</span>{index < route.stops.length - 1 && <span className="w-px flex-1 bg-[#b8cbc5]" />}</span>
                <span className="pt-1 text-sm font-bold">{displayPlace(index === 0 ? journey.from : index === route.stops.length - 1 ? journey.to : stop, language)}</span>
              </li>
            ))}
          </ol>
          <button onClick={() => window.open(fullMapUrl, '_blank', 'noopener,noreferrer')} className="primary-button mt-3 w-full"><Icon name="map" size={18} /> {t('openGoogle')}</button>
          <button onClick={() => navigate('/road-updates')} className="secondary-button mt-2 w-full"><Icon name="cone" size={18} /> {t('checkRoad')}</button>
        </aside>
        <div className="relative min-h-[560px] overflow-hidden rounded-[22px] border border-[#d7e1de] bg-[#dce5e1] shadow-sm">
          <iframe title={`Google Maps route from ${journey.from} to ${journey.to}`} src={mapUrl} className="absolute inset-0 h-full w-full border-0" loading="lazy" referrerPolicy="no-referrer-when-downgrade" />
          <div className="map-summary absolute left-4 top-4">
            <span className="grid h-9 w-9 place-items-center rounded-lg bg-[#087f5b] text-white"><Icon name="route" size={19} /></span>
            <div><p className="text-[10px] font-bold uppercase tracking-[.12em] text-[#758883]">{t('googleRoute')}</p><p className="text-sm font-extrabold">{displayPlace(journey.from, language)} → {displayPlace(journey.to, language)}</p></div>
          </div>
        </div>
      </div>
    </section>
  )
}
