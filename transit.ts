export type BusRoute = {
  id: number
  bus: string
  number: string
  duration: string
  distance: string
  fare: number
  traffic: string
  color: string
  stops: string[]
  note: string
  frequency: string
}

export const dhakaPlaces = [
  'Abdullahpur', 'Agargaon', 'Airport', 'Asad Gate', 'Azimpur', 'Badda',
  'Banani', 'Bashundhara', 'Dhanmondi 27', 'Farmgate', 'Gabtoli', 'Gulistan',
  'Gulshan 1', 'Jatrabari', 'Kakrail', 'Kalabagan', 'Kazipara', 'Khilgaon',
  'Malibagh', 'Mirpur 1', 'Mirpur 10', 'Mohakhali', 'Motijheel', 'New Market',
  'Paltan', 'Rampura', 'Shahbagh', 'Shyamoli', 'Uttara', 'Wari',
]

export const banglaPlaces: Record<string, string> = {
  Abdullahpur: 'আব্দুল্লাহপুর', Agargaon: 'আগারগাঁও', Airport: 'বিমানবন্দর', 'Asad Gate': 'আসাদ গেট',
  Azimpur: 'আজিমপুর', Badda: 'বাড্ডা', Banani: 'বনানী', Bashundhara: 'বসুন্ধরা',
  'Dhanmondi 27': 'ধানমন্ডি ২৭', Farmgate: 'ফার্মগেট', Gabtoli: 'গাবতলী', Gulistan: 'গুলিস্তান',
  'Gulshan 1': 'গুলশান ১', Jatrabari: 'যাত্রাবাড়ী', Kakrail: 'কাকরাইল', Kalabagan: 'কলাবাগান',
  Kazipara: 'কাজীপাড়া', Khilgaon: 'খিলগাঁও', Malibagh: 'মালিবাগ', 'Mirpur 1': 'মিরপুর ১',
  'Mirpur 10': 'মিরপুর ১০', Mohakhali: 'মহাখালী', Motijheel: 'মতিঝিল', 'New Market': 'নিউ মার্কেট',
  Paltan: 'পল্টন', Rampura: 'রামপুরা', Shahbagh: 'শাহবাগ', Shyamoli: 'শ্যামলী', Uttara: 'উত্তরা',
  Wari: 'ওয়ারী', Shewrapara: 'শেওড়াপাড়া', Technical: 'টেকনিক্যাল',
}

export function displayPlace(place: string, language: 'en' | 'bn') {
  const englishPlace = Object.entries(banglaPlaces).find(([, bangla]) => bangla === place)?.[0] ?? place
  return language === 'bn' ? banglaPlaces[englishPlace] ?? place : englishPlace
}

function canonicalPlace(place: string) {
  const banglaEntry = Object.entries(banglaPlaces).find(([, bangla]) => bangla === place.trim())
  return (banglaEntry?.[0] ?? place).toLowerCase().trim()
}

export const routes: BusRoute[] = [
  {
    id: 1, bus: 'Bahon Express', number: 'B-17', duration: '48 min', distance: '12.4 km',
    fare: 45, traffic: 'moderate', color: '#f59e0b',
    stops: ['Mirpur 10', 'Kazipara', 'Shewrapara', 'Agargaon', 'Farmgate', 'Shahbagh', 'Paltan', 'Motijheel'],
    note: 'Fastest route', frequency: '12–15 min',
  },
  {
    id: 2, bus: 'Shikor Paribahan', number: 'S-08', duration: '42 min', distance: '10.1 km',
    fare: 40, traffic: 'light', color: '#18a572',
    stops: ['Mirpur 10', 'Mirpur 2', 'Technical', 'Shyamoli', 'Dhanmondi 27', 'New Market', 'Azimpur'],
    note: 'Less crowded', frequency: '15–20 min',
  },
  {
    id: 3, bus: 'Bihanga Paribahan', number: 'B-22', duration: '55 min', distance: '14.6 km',
    fare: 50, traffic: 'heavy', color: '#ef6a54',
    stops: ['Mirpur 10', 'Agargaon', 'Mohakhali', 'Gulshan 1', 'Badda'],
    note: 'More seats', frequency: '18–22 min',
  },
  {
    id: 4, bus: 'Airport Bangabandhu Avenue', number: 'A-11', duration: '49 min', distance: '15.2 km',
    fare: 55, traffic: 'moderate', color: '#3b82f6',
    stops: ['Uttara', 'Airport', 'Banani', 'Mohakhali', 'Farmgate', 'Shahbagh'],
    note: 'Airport route', frequency: '10–15 min',
  },
  {
    id: 5, bus: 'Victor Classic', number: 'V-05', duration: '44 min', distance: '11.8 km',
    fare: 40, traffic: 'heavy', color: '#8b5cf6',
    stops: ['Badda', 'Rampura', 'Malibagh', 'Kakrail', 'Paltan', 'Motijheel'],
    note: 'City route', frequency: '12–18 min',
  },
  {
    id: 6, bus: 'Turag Transport', number: 'T-19', duration: '58 min', distance: '16.3 km',
    fare: 60, traffic: 'moderate', color: '#0ea5a4',
    stops: ['Jatrabari', 'Gulistan', 'Paltan', 'Shahbagh', 'Farmgate', 'Mohakhali'],
    note: 'Long route', frequency: '15–20 min',
  },
  {
    id: 7, bus: 'Achim Paribahan', number: 'A-07', duration: '52 min', distance: '13.9 km',
    fare: 50, traffic: 'light', color: '#db2777',
    stops: ['Gabtoli', 'Shyamoli', 'Asad Gate', 'Dhanmondi 27', 'Kalabagan', 'Shahbagh', 'Gulistan'],
    note: 'Popular route', frequency: '14–18 min',
  },
  {
    id: 8, bus: 'Raida Enterprise', number: 'R-03', duration: '47 min', distance: '14.1 km',
    fare: 50, traffic: 'moderate', color: '#ca8a04',
    stops: ['Abdullahpur', 'Uttara', 'Airport', 'Bashundhara', 'Badda', 'Rampura'],
    note: 'Northern route', frequency: '10–16 min',
  },
]

export function routesForJourney(from: string, to: string) {
  const origin = canonicalPlace(from)
  const destination = canonicalPlace(to)
  return routes.filter((route) => {
    const stops = route.stops.map((stop) => stop.toLowerCase())
    const fromIndex = stops.findIndex((stop) => stop.includes(origin) || origin.includes(stop))
    const toIndex = stops.findIndex((stop) => stop.includes(destination) || destination.includes(stop))
    return fromIndex >= 0 && toIndex >= 0 && fromIndex !== toIndex
  })
}

export const constructionItems = [
  { id: 1, road: 'Begum Rokeya Avenue', roadBn: 'বেগম রোকেয়া সরণি', area: 'Kazipara to Shewrapara', areaBn: 'কাজীপাড়া থেকে শেওড়াপাড়া', status: 'Lane restricted', statusBn: 'লেন সীমিত', remaining: '12 days', remainingBn: '১২ দিন', level: 'High impact', updated: '8 min ago', updatedBn: '৮ মিনিট আগে', detail: 'Utility relocation is restricting the left lane. Use Mirpur Road through Agargaon as an alternative.', detailBn: 'ইউটিলিটি স্থানান্তরের কারণে বাম লেন সীমিত। বিকল্প হিসেবে আগারগাঁও হয়ে মিরপুর রোড ব্যবহার করুন।' },
  { id: 2, road: 'Airport Road', roadBn: 'বিমানবন্দর সড়ক', area: 'Banani rail crossing', areaBn: 'বনানী রেল ক্রসিং', status: 'Night work only', statusBn: 'শুধু রাতে কাজ', remaining: '5 days', remainingBn: '৫ দিন', level: 'Low impact', updated: '24 min ago', updatedBn: '২৪ মিনিট আগে', detail: 'Resurfacing work runs from 11:00 PM to 5:00 AM. Daytime traffic is operating normally.', detailBn: 'রাত ১১টা থেকে ভোর ৫টা পর্যন্ত সড়ক মেরামত চলে। দিনের বেলা যান চলাচল স্বাভাবিক।' },
  { id: 3, road: 'Moghbazar Flyover', roadBn: 'মগবাজার ফ্লাইওভার', area: 'Moghbazar intersection', areaBn: 'মগবাজার মোড়', status: 'One lane closed', statusBn: 'একটি লেন বন্ধ', remaining: '8 days', remainingBn: '৮ দিন', level: 'Medium impact', updated: '41 min ago', updatedBn: '৪১ মিনিট আগে', detail: 'Expansion joint repair is underway. Expect delays during the evening peak period.', detailBn: 'এক্সপ্যানশন জয়েন্ট মেরামত চলছে। সন্ধ্যার ব্যস্ত সময়ে বিলম্ব হতে পারে।' },
]
