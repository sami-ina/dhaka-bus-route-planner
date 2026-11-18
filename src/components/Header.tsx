import { useState } from 'react'
import Icon from './Icon'
import { useLanguage } from '../i18n/LanguageContext'

type Props = {
  path: string
  navigate: (path: string) => void
}

export default function Header({ path, navigate }: Props) {
  const [mobileMenu, setMobileMenu] = useState(false)
  const { language, setLanguage, t } = useLanguage()

  function go(pathname: string) {
    navigate(pathname)
    setMobileMenu(false)
  }

  return (
    <header className="sticky top-0 z-30 border-b border-[#dfe6e4] bg-white/95 backdrop-blur">
      <a href="#main-content" className="skip-link">{t('skip')}</a>
      <div className="mx-auto flex h-[72px] max-w-[1500px] items-center justify-between px-5 lg:px-8">
        <button onClick={() => go('/')} className="flex items-center gap-3 text-left" aria-label="Route Dhaka home">
          <span className="grid h-10 w-10 place-items-center rounded-xl bg-[#087f5b] text-white shadow-[0_6px_18px_rgba(8,127,91,.22)]">
            <Icon name="bus" size={23} />
          </span>
            <span>
              <span className="block text-[19px] font-extrabold leading-5 tracking-[-.03em]">RouteDhaka</span>
              <span className="block max-w-[190px] text-[8px] font-bold uppercase tracking-[.08em] text-[#77908b]">{t('brandSubtitle')}</span>
            </span>
        </button>

        <nav className="hidden items-center gap-1 md:flex" aria-label="Primary navigation">
          <button onClick={() => go('/')} className={`nav-link ${path === '/' ? 'active' : ''}`}><Icon name="search" size={17} /> {t('planJourney')}</button>
          <button onClick={() => go('/routes')} className={`nav-link ${path.startsWith('/route') ? 'active' : ''}`}><Icon name="bus" size={17} /> {t('busRoutes')}</button>
          <button onClick={() => go('/road-updates')} className={`nav-link ${path === '/road-updates' ? 'active' : ''}`}><Icon name="cone" size={17} /> {t('roadUpdates')}</button>
        </nav>

        <div className="flex items-center gap-2">
          <button onClick={() => setLanguage(language === 'en' ? 'bn' : 'en')} className="rounded-full border border-[#dce5e2] px-3 py-2 text-xs font-bold text-[#38504c] transition hover:border-[#087f5b] hover:text-[#087f5b] sm:px-4 sm:text-sm" aria-label={language === 'en' ? 'Switch website to Bangla' : 'ওয়েবসাইট ইংরেজিতে দেখুন'}>
            {language === 'en' ? 'বাংলা' : 'English'}
          </button>
          <button onClick={() => setMobileMenu(!mobileMenu)} className="grid h-10 w-10 place-items-center rounded-xl border border-[#dce5e2] md:hidden" aria-label={mobileMenu ? t('closeMenu') : t('openMenu')} aria-expanded={mobileMenu}>
            <Icon name={mobileMenu ? 'close' : 'menu'} />
          </button>
        </div>
      </div>
      {mobileMenu && (
        <nav className="border-t border-[#e8eeec] bg-white p-4 md:hidden" aria-label="Mobile navigation">
          <button onClick={() => go('/')} className="mobile-link w-full text-left">{t('planJourney')}</button>
          <button onClick={() => go('/routes')} className="mobile-link w-full text-left">{t('busRoutes')}</button>
          <button onClick={() => go('/road-updates')} className="mobile-link w-full text-left">{t('roadUpdates')}</button>
        </nav>
      )}
    </header>
  )
}
