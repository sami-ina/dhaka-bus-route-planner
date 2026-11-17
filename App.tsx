import { useEffect, useState } from 'react'
import Header from './components/Header'
import HomePage from './pages/HomePage'
import RoadUpdatesPage from './pages/RoadUpdatesPage'
import RouteDetailsPage from './pages/RouteDetailsPage'
import RoutesPage from './pages/RoutesPage'
import { LanguageProvider } from './i18n/LanguageContext'

export type Journey = {
  from: string
  to: string
}

function getPath() {
  return window.location.hash.replace(/^#/, '') || '/'
}

export default function App() {
  const [path, setPath] = useState(getPath)
  const [journey, setJourney] = useState<Journey>({ from: 'Mirpur 10', to: 'Farmgate' })

  useEffect(() => {
    const handleHashChange = () => {
      setPath(getPath())
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }
    window.addEventListener('hashchange', handleHashChange)
    return () => window.removeEventListener('hashchange', handleHashChange)
  }, [])

  function navigate(nextPath: string) {
    if (getPath() === nextPath) {
      setPath(nextPath)
      window.scrollTo({ top: 0, behavior: 'smooth' })
      return
    }
    window.location.hash = nextPath
  }

  function search(nextJourney: Journey) {
    setJourney(nextJourney)
    navigate('/routes')
  }

  let page
  if (path === '/routes') {
    page = <RoutesPage journey={journey} navigate={navigate} />
  } else if (path.startsWith('/route/')) {
    page = <RouteDetailsPage routeId={Number(path.split('/')[2]) || 1} journey={journey} navigate={navigate} />
  } else if (path === '/road-updates') {
    page = <RoadUpdatesPage navigate={navigate} />
  } else {
    page = <HomePage journey={journey} onSearch={search} navigate={navigate} />
  }

  return (
    <LanguageProvider>
      <div className="min-h-screen bg-[#f5f7f8] text-[#172725]">
        <Header path={path} navigate={navigate} />
        <main id="main-content">{page}</main>
      </div>
    </LanguageProvider>
  )
}
