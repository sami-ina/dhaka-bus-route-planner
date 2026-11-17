import { useEffect, useState, type FormEvent } from 'react'
import type { Journey } from '../App'
import Icon from '../components/Icon'
import PlaceInput from '../components/PlaceInput'
import { displayPlace } from '../data/transit'
import { useLanguage } from '../i18n/LanguageContext'

type Props = {
  journey: Journey
  onSearch: (journey: Journey) => void
  navigate: (path: string) => void
}

export default function HomePage({ journey, onSearch, navigate }: Props) {
  const { language, t } = useLanguage()
  const [from, setFrom] = useState(journey.from)
  const [to, setTo] = useState(journey.to)
  const [locationMessage, setLocationMessage] = useState('')

  useEffect(() => {
    setFrom((value) => displayPlace(value, language))
    setTo((value) => displayPlace(value, language))
  }, [language])

  function submit(event: FormEvent) {
    event.preventDefault()
    if (from.trim() && to.trim()) onSearch({ from: from.trim(), to: to.trim() })
  }

  function useLocation() {
    if (!navigator.geolocation) {
      setLocationMessage(t('locationUnsupported'))
      return
    }
    setLocationMessage(t('findingLocation'))
    navigator.geolocation.getCurrentPosition(
      () => {
        setFrom(t('currentLocation'))
        setLocationMessage(t('locationSelected'))
      },
      () => setLocationMessage(t('locationUnavailable')),
    )
  }

  return (
    <>
      <section className="border-b border-[#dde6e3] bg-[#ecf4f1]">
        <div className="mx-auto max-w-[1500px] px-5 py-12 lg:px-8 lg:py-20">
          <div className="mx-auto max-w-4xl text-center">
            <p className="mb-3 text-xs font-extrabold uppercase tracking-[.18em] text-[#087f5b]">{t('dhakaTransport')}</p>
            <h1 className="text-[40px] font-extrabold leading-[1.06] tracking-[-.05em] text-[#142622] md:text-[62px]">{t('heroTitle')}</h1>
            <p className="mx-auto mt-5 max-w-xl text-[16px] leading-7 text-[#5e746f]">{t('heroText')}</p>
          </div>

          <form onSubmit={submit} className="mx-auto mt-10 max-w-5xl rounded-[22px] border border-[#d7e2de] bg-white p-3 shadow-[0_16px_45px_rgba(32,70,61,.12)] lg:p-4">
            <div className="grid items-center gap-2 lg:grid-cols-[1fr_44px_1fr_auto]">
              <PlaceInput id="journey-from" label={t('start')} value={from} onChange={setFrom} />
              <button type="button" onClick={() => { setFrom(to); setTo(from) }} className="mx-auto grid h-10 w-10 rotate-90 place-items-center rounded-full border border-[#d8e2df] bg-white text-[#617772] transition hover:border-[#087f5b] hover:text-[#087f5b] lg:rotate-0" aria-label={t('swap')}>
                <Icon name="swap" size={18} />
              </button>
              <PlaceInput id="journey-to" label={t('destination')} value={to} onChange={setTo} destination />
              <button type="submit" className="primary-button h-[58px]"><Icon name="search" size={19} /> {t('findRoutes')}</button>
            </div>
            <div className="mt-3 flex flex-wrap items-center justify-between gap-2 px-1">
              <button type="button" onClick={useLocation} className="inline-flex items-center gap-1.5 text-xs font-bold text-[#087f5b] hover:underline"><Icon name="locate" size={15} /> {t('useLocation')}</button>
              <p className="text-xs text-[#70827e]" role="status">{locationMessage || t('suggestions')}</p>
            </div>
          </form>
        </div>
      </section>

      <section className="mx-auto max-w-[1200px] px-5 py-12 lg:px-8">
        <div className="mb-6 flex items-end justify-between">
          <div><p className="eyebrow">{t('quickAccess')}</p><h2 className="section-title">{t('whereGoing')}</h2></div>
          <button onClick={() => navigate('/road-updates')} className="text-button">{t('seeRoadUpdates')} <Icon name="arrow" size={16} /></button>
        </div>
        <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
          {['Farmgate', 'Motijheel', 'Gulshan 1', 'Uttara'].map((place) => (
            <button key={place} onClick={() => { setTo(place); onSearch({ from, to: place }) }} className="group flex items-center justify-between rounded-2xl border border-[#dce5e2] bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-[#8ab8aa] hover:shadow-lg">
              <span><span className="block text-sm font-extrabold">{displayPlace(place, language)}</span><span className="mt-1 block text-xs text-[#748681]">{t('findBusesFrom')} {from}</span></span>
              <span className="grid h-9 w-9 place-items-center rounded-full bg-[#edf6f3] text-[#087f5b] transition group-hover:bg-[#087f5b] group-hover:text-white"><Icon name="arrow" size={17} /></span>
            </button>
          ))}
        </div>
      </section>
    </>
  )
}
