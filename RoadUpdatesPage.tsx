import Icon from '../components/Icon'
import { constructionItems } from '../data/transit'
import { useLanguage } from '../i18n/LanguageContext'

type Props = { navigate: (path: string) => void }

export default function RoadUpdatesPage({ navigate }: Props) {
  const { language, t } = useLanguage()
  const mapUrl = 'https://www.google.com/maps?output=embed&q=Dhaka%2C%20Bangladesh&z=12'

  return (
    <section className="mx-auto max-w-[1350px] px-5 py-8 lg:px-8 lg:py-12">
      <button onClick={() => navigate('/')} className="back-button"><Icon name="back" size={17} /> {t('backPlanner')}</button>
      <div className="mt-5">
        <p className="eyebrow">{t('liveStatus')}</p>
        <h1 className="page-title">{t('constructionTitle')}</h1>
        <p className="mt-2 max-w-2xl text-sm leading-6 text-[#637873]">{t('constructionText')}</p>
      </div>

      <div className="mt-8 grid gap-5 lg:grid-cols-[430px_minmax(0,1fr)]">
        <div className="space-y-3">
          {constructionItems.map((item) => (
            <article key={item.id} className="rounded-2xl border border-[#dce5e2] bg-white p-5 shadow-sm">
              <div className="flex items-start gap-3">
                <span className="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#fff0e9] text-[#df6941]"><Icon name="cone" /></span>
                <div className="min-w-0 flex-1">
                  <div className="flex flex-wrap items-center justify-between gap-2">
                    <h2 className="text-[15px] font-extrabold">{language === 'bn' ? item.roadBn : item.road}</h2>
                    <span className="rounded-full bg-[#fff0e9] px-2 py-1 text-[9px] font-extrabold uppercase tracking-wider text-[#cf5833]">{t(item.level === 'High impact' ? 'highImpact' : item.level === 'Medium impact' ? 'mediumImpact' : 'lowImpact')}</span>
                  </div>
                  <p className="mt-1 text-xs font-semibold text-[#657a75]">{language === 'bn' ? item.areaBn : item.area} · {language === 'bn' ? item.statusBn : item.status}</p>
                  <p className="mt-3 text-xs leading-5 text-[#71827e]">{language === 'bn' ? item.detailBn : item.detail}</p>
                  <div className="mt-4 flex flex-wrap gap-3 text-[10px] font-bold text-[#687b77]">
                    <span className="inline-flex items-center gap-1"><Icon name="calendar" size={13} /> {language === 'bn' ? item.remainingBn : item.remaining} {t('remaining')}</span>
                    <span className="inline-flex items-center gap-1"><Icon name="clock" size={13} /> {t('updated')} {language === 'bn' ? item.updatedBn : item.updated}</span>
                  </div>
                </div>
              </div>
            </article>
          ))}
          <button onClick={() => navigate('/')} className="primary-button w-full"><Icon name="search" size={18} /> {t('planDifferent')}</button>
        </div>
        <div className="relative min-h-[520px] overflow-hidden rounded-[22px] border border-[#d7e1de] bg-[#dce5e1] shadow-sm">
          <iframe title="Google Map of Dhaka road updates" src={mapUrl} className="absolute inset-0 h-full w-full border-0" loading="lazy" referrerPolicy="no-referrer-when-downgrade" />
          <div className="map-summary absolute left-4 top-4">
            <span className="grid h-9 w-9 place-items-center rounded-lg bg-[#df6941] text-white"><Icon name="warning" size={19} /></span>
            <div><p className="text-[10px] font-bold uppercase tracking-[.12em] text-[#758883]">{t('activeDhaka')}</p><p className="text-sm font-extrabold">{constructionItems.length} {t('reportedWorks')}</p></div>
          </div>
        </div>
      </div>
    </section>
  )
}
