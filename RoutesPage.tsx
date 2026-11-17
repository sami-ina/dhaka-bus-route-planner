import { useState } from 'react'
import type { Journey } from '../App'
import Icon from '../components/Icon'
import { displayPlace, routes, routesForJourney } from '../data/transit'
import { useLanguage } from '../i18n/LanguageContext'

type Props = { journey: Journey; navigate: (path: string) => void }

export default function RoutesPage({ journey, navigate }: Props) {
  const [sort, setSort] = useState<'fastest' | 'cheapest'>('fastest')
  const [showAll, setShowAll] = useState(false)
  const { language, t } = useLanguage()
  const matchingRoutes = routesForJourney(journey.from, journey.to)
  const visibleRoutes = showAll ? routes : matchingRoutes
  const sortedRoutes = [...visibleRoutes].sort((a, b) => sort === 'fastest' ? Number(a.duration.split(' ')[0]) - Number(b.duration.split(' ')[0]) : a.fare - b.fare)
  const trafficText = (traffic: string) => t(traffic === 'light' ? 'lightTraffic' : traffic === 'heavy' ? 'heavyTraffic' : 'moderateTraffic')
  const localUnit = (value: string) => language === 'bn' ? value.replace('min', 'মিনিট').replace('km', 'কিমি') : value

  return (
    <section className="mx-auto max-w-[1180px] px-5 py-8 lg:px-8 lg:py-12">
      <button onClick={() => navigate('/')} className="back-button"><Icon name="back" size={17} /> {t('changeJourney')}</button>
      <div className="mt-5 flex flex-col justify-between gap-4 border-b border-[#dce5e2] pb-7 sm:flex-row sm:items-end">
        <div>
          <p className="eyebrow">{t('journeyResults')}</p>
          <h1 className="page-title">{displayPlace(journey.from, language)} <span className="text-[#8a9b97]">{t('to')}</span> {displayPlace(journey.to, language)}</h1>
          <p className="mt-2 text-sm text-[#637873]">{matchingRoutes.length} {t('routesFound')} · {t('trafficUpdated')}</p>
        </div>
        <button onClick={() => setSort(sort === 'fastest' ? 'cheapest' : 'fastest')} className="secondary-button" aria-label={`Currently sorting by ${sort}. Click to change.`}>
          {t('sort')}: {sort === 'fastest' ? t('fastest') : t('lowestFare')} <Icon name="swap" size={16} />
        </button>
      </div>

      {matchingRoutes.length === 0 && !showAll && (
        <div className="mt-7 rounded-2xl border border-[#dce5e2] bg-white p-8 text-center">
          <span className="mx-auto grid h-12 w-12 place-items-center rounded-full bg-[#edf6f3] text-[#087f5b]"><Icon name="bus" size={23} /></span>
          <h2 className="mt-4 text-lg font-extrabold">{t('noDirectRoutes')}</h2>
          <p className="mt-2 text-sm text-[#6b7e79]">{t('noDirectText')}</p>
          <button onClick={() => setShowAll(true)} className="primary-button mt-5">{t('showAllBuses')}</button>
        </div>
      )}
      <div className="mt-7 grid gap-4">
        {sortedRoutes.map((route, index) => (
          <article key={route.id} className="route-result">
            <div className="flex flex-col gap-5 lg:flex-row lg:items-center">
              <div className="flex min-w-0 flex-1 items-start gap-4">
                <span className="grid h-12 w-12 shrink-0 place-items-center rounded-xl text-white" style={{ backgroundColor: route.color }}><Icon name="bus" size={24} /></span>
                <div>
                  <div className="flex flex-wrap items-center gap-2">
                    <h2 className="text-lg font-extrabold">{route.bus}</h2>
                    <span className="rounded-md bg-[#edf1f0] px-2 py-1 text-[10px] font-bold">{route.number}</span>
                    {index === 0 && <span className="rounded-full bg-[#daf3e9] px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-[#087f5b]">{sort === 'fastest' ? t('fastest') : t('bestFare')}</span>}
                  </div>
                  <p className="mt-1 text-xs text-[#70827e]">{t('every')} {localUnit(route.frequency)} · {trafficText(route.traffic)}</p>
                  <div className="mt-4 flex max-w-lg items-center">
                    {route.stops.map((stop, stopIndex) => (
                      <div key={stop} className={`flex items-center ${stopIndex < route.stops.length - 1 ? 'flex-1' : ''}`}>
                        <span className="h-2.5 w-2.5 shrink-0 rounded-full border-2 border-[#087f5b] bg-white" />
                        {stopIndex < route.stops.length - 1 && <span className="h-px flex-1 bg-[#b9c8c4]" />}
                      </div>
                    ))}
                  </div>
                  <div className="mt-2 flex max-w-lg justify-between gap-2 text-[9px] font-semibold text-[#71837f]">
                    {route.stops.map((stop, stopIndex) => <span key={stop} className={stopIndex > 0 && stopIndex < route.stops.length - 1 ? 'hidden sm:block' : ''}>{displayPlace(stop, language)}</span>)}
                  </div>
                </div>
              </div>

              <div className="grid grid-cols-3 divide-x divide-[#e0e7e5] rounded-xl bg-[#f5f8f7] px-2 py-3 lg:w-[300px]">
                <span className="result-stat"><Icon name="clock" size={15} /><strong>{localUnit(route.duration)}</strong><small>{t('duration')}</small></span>
                <span className="result-stat"><Icon name="route" size={15} /><strong>{localUnit(route.distance)}</strong><small>{t('distance')}</small></span>
                <span className="result-stat"><b className="text-base">৳</b><strong>{route.fare}</strong><small>{t('estFare')}</small></span>
              </div>
              <button onClick={() => navigate(`/route/${route.id}`)} className="primary-button lg:w-auto">{t('viewRoute')} <Icon name="arrow" size={17} /></button>
            </div>
          </article>
        ))}
      </div>

      <div className="mt-8 rounded-2xl border border-[#f0d9cd] bg-[#fff8f4] p-5 sm:flex sm:items-center sm:justify-between">
        <div className="flex items-start gap-3"><span className="text-[#dc6841]"><Icon name="warning" /></span><div><h2 className="text-sm font-extrabold">{t('roadMayAffect')}</h2><p className="mt-1 text-xs text-[#796f6b]">{t('roadMayAffectText')}</p></div></div>
        <button onClick={() => navigate('/road-updates')} className="mt-4 text-button text-[#c95a36] sm:mt-0">{t('viewUpdate')} <Icon name="arrow" size={15} /></button>
      </div>
    </section>
  )
}
