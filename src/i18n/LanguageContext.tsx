import { createContext, useContext, useEffect, useMemo, useState, type ReactNode } from 'react'

export type Language = 'en' | 'bn'

const copy = {
  en: {
    brandSubtitle: 'Bus routes & road construction',
    planJourney: 'Plan a journey',
    busRoutes: 'Bus routes',
    roadUpdates: 'Road updates',
    skip: 'Skip to main content',
    openMenu: 'Open menu',
    closeMenu: 'Close menu',
    dhakaTransport: 'Dhaka public transport',
    heroTitle: 'Know the way before you start moving.',
    heroText: 'Search any place in Dhaka, compare available buses, check road work, and estimate your fare.',
    start: 'Starting point',
    destination: 'Where to?',
    placePlaceholder: 'Type any place in Dhaka',
    findRoutes: 'Find routes',
    swap: 'Swap starting point and destination',
    useLocation: 'Use my current location',
    suggestions: 'Suggestions appear as you type.',
    findingLocation: 'Finding your location…',
    locationSelected: 'Current location selected.',
    locationUnavailable: 'Location access was not available. Type your starting place instead.',
    locationUnsupported: 'Location is not supported by this browser.',
    quickAccess: 'Quick access',
    whereGoing: 'Where are you going?',
    seeRoadUpdates: 'See road updates',
    findBusesFrom: 'Find buses from',
    changeJourney: 'Change journey',
    journeyResults: 'Journey results',
    to: 'to',
    routesFound: 'bus routes found',
    trafficUpdated: 'Traffic updated 2 minutes ago',
    noDirectRoutes: 'No direct bus found for this journey',
    noDirectText: 'Try a nearby major stop or view all available buses.',
    showAllBuses: 'Show all available buses',
    sort: 'Sort',
    fastest: 'Fastest',
    lowestFare: 'Lowest fare',
    bestFare: 'Best fare',
    every: 'Every',
    duration: 'duration',
    distance: 'distance',
    estFare: 'est. fare',
    viewRoute: 'View route',
    roadMayAffect: 'Road work may affect this journey',
    roadMayAffectText: 'Begum Rokeya Avenue has a lane restriction near Kazipara.',
    viewUpdate: 'View update',
    backRoutes: 'Back to all routes',
    selectedBus: 'Selected bus',
    stopsRoute: 'Stops on this route',
    openGoogle: 'Open in Google Maps',
    checkRoad: 'Check road updates',
    googleRoute: 'Google Maps route',
    backPlanner: 'Back to journey planner',
    liveStatus: 'Live status',
    constructionTitle: 'Road construction updates',
    constructionText: 'Plan around active repairs, lane closures, and construction work across Dhaka. Records include their latest update time.',
    remaining: 'remaining',
    updated: 'Updated',
    planDifferent: 'Plan a different journey',
    activeDhaka: 'Active in Dhaka',
    reportedWorks: 'reported road works',
    lightTraffic: 'Light traffic',
    moderateTraffic: 'Moderate traffic',
    heavyTraffic: 'Heavy traffic',
    highImpact: 'High impact',
    mediumImpact: 'Medium impact',
    lowImpact: 'Low impact',
    currentLocation: 'Current location, Dhaka',
  },
  bn: {
    brandSubtitle: 'বাস রুট ও সড়ক নির্মাণ ব্যবস্থা',
    planJourney: 'যাত্রা পরিকল্পনা',
    busRoutes: 'বাস রুট',
    roadUpdates: 'সড়ক আপডেট',
    skip: 'মূল অংশে যান',
    openMenu: 'মেনু খুলুন',
    closeMenu: 'মেনু বন্ধ করুন',
    dhakaTransport: 'ঢাকা গণপরিবহন',
    heroTitle: 'যাত্রা শুরুর আগেই সঠিক পথ জেনে নিন।',
    heroText: 'ঢাকার যেকোনো স্থান খুঁজুন, বাস তুলনা করুন, সড়কের কাজ দেখুন এবং ভাড়া জানুন।',
    start: 'যাত্রা শুরুর স্থান',
    destination: 'কোথায় যাবেন?',
    placePlaceholder: 'ঢাকার যেকোনো স্থান লিখুন',
    findRoutes: 'বাস রুট খুঁজুন',
    swap: 'শুরুর স্থান ও গন্তব্য অদলবদল করুন',
    useLocation: 'আমার বর্তমান অবস্থান ব্যবহার করুন',
    suggestions: 'লিখতে শুরু করলে স্থানের পরামর্শ দেখা যাবে।',
    findingLocation: 'আপনার অবস্থান খোঁজা হচ্ছে…',
    locationSelected: 'বর্তমান অবস্থান নির্বাচন করা হয়েছে।',
    locationUnavailable: 'অবস্থান পাওয়া যায়নি। শুরুর স্থানটি লিখুন।',
    locationUnsupported: 'এই ব্রাউজারে অবস্থান সেবা নেই।',
    quickAccess: 'দ্রুত নির্বাচন',
    whereGoing: 'আপনি কোথায় যেতে চান?',
    seeRoadUpdates: 'সড়ক আপডেট দেখুন',
    findBusesFrom: 'এখান থেকে বাস খুঁজুন:',
    changeJourney: 'যাত্রা পরিবর্তন করুন',
    journeyResults: 'যাত্রার ফলাফল',
    to: 'থেকে',
    routesFound: 'টি বাস রুট পাওয়া গেছে',
    trafficUpdated: 'ট্রাফিক ২ মিনিট আগে আপডেট হয়েছে',
    noDirectRoutes: 'এই যাত্রার জন্য সরাসরি বাস পাওয়া যায়নি',
    noDirectText: 'কাছাকাছি কোনো প্রধান স্টপ চেষ্টা করুন অথবা সব বাস দেখুন।',
    showAllBuses: 'সব বাস দেখুন',
    sort: 'সাজান',
    fastest: 'দ্রুততম',
    lowestFare: 'সর্বনিম্ন ভাড়া',
    bestFare: 'সেরা ভাড়া',
    every: 'প্রতি',
    duration: 'সময়',
    distance: 'দূরত্ব',
    estFare: 'আনুমানিক ভাড়া',
    viewRoute: 'রুট দেখুন',
    roadMayAffect: 'সড়কের কাজ এই যাত্রায় প্রভাব ফেলতে পারে',
    roadMayAffectText: 'কাজীপাড়ার কাছে বেগম রোকেয়া সরণির একটি লেন সীমিত রয়েছে।',
    viewUpdate: 'আপডেট দেখুন',
    backRoutes: 'সব রুটে ফিরে যান',
    selectedBus: 'নির্বাচিত বাস',
    stopsRoute: 'এই রুটের স্টপসমূহ',
    openGoogle: 'গুগল ম্যাপে খুলুন',
    checkRoad: 'সড়ক আপডেট দেখুন',
    googleRoute: 'গুগল ম্যাপ রুট',
    backPlanner: 'যাত্রা পরিকল্পনায় ফিরুন',
    liveStatus: 'সরাসরি অবস্থা',
    constructionTitle: 'সড়ক নির্মাণ আপডেট',
    constructionText: 'ঢাকার চলমান মেরামত, বন্ধ লেন ও নির্মাণকাজ দেখে আপনার যাত্রা পরিকল্পনা করুন। প্রতিটি তথ্যের সর্বশেষ আপডেট সময় দেওয়া আছে।',
    remaining: 'বাকি',
    updated: 'আপডেট',
    planDifferent: 'অন্য যাত্রা পরিকল্পনা করুন',
    activeDhaka: 'ঢাকায় চলমান',
    reportedWorks: 'টি সড়কের কাজ',
    lightTraffic: 'হালকা যানজট',
    moderateTraffic: 'মাঝারি যানজট',
    heavyTraffic: 'ভারী যানজট',
    highImpact: 'উচ্চ প্রভাব',
    mediumImpact: 'মাঝারি প্রভাব',
    lowImpact: 'কম প্রভাব',
    currentLocation: 'বর্তমান অবস্থান, ঢাকা',
  },
} as const

type LanguageContextValue = {
  language: Language
  setLanguage: (language: Language) => void
  t: (key: keyof typeof copy.en) => string
}

const LanguageContext = createContext<LanguageContextValue | null>(null)

export function LanguageProvider({ children }: { children: ReactNode }) {
  const [language, setLanguageState] = useState<Language>(() => (localStorage.getItem('route-dhaka-language') === 'bn' ? 'bn' : 'en'))

  useEffect(() => {
    document.documentElement.lang = language
  }, [language])

  const value = useMemo(() => ({
    language,
    setLanguage: (next: Language) => {
      localStorage.setItem('route-dhaka-language', next)
      setLanguageState(next)
    },
    t: (key: keyof typeof copy.en) => copy[language][key],
  }), [language])

  return <LanguageContext.Provider value={value}>{children}</LanguageContext.Provider>
}

export function useLanguage() {
  const value = useContext(LanguageContext)
  if (!value) throw new Error('useLanguage must be used inside LanguageProvider')
  return value
}
