import Icon from './Icon'
import { dhakaPlaces, displayPlace } from '../data/transit'
import { useLanguage } from '../i18n/LanguageContext'

type Props = {
  id: string
  label: string
  value: string
  onChange: (value: string) => void
  destination?: boolean
}

export default function PlaceInput({ id, label, value, onChange, destination = false }: Props) {
  const { t, language } = useLanguage()
  return (
    <label className="location-field" htmlFor={id}>
      <span className={`field-icon ${destination ? 'bg-[#fff1df] text-[#e17727]' : 'bg-[#e6f5ef] text-[#087f5b]'}`}><Icon name="pin" size={18} /></span>
      <span className="min-w-0 flex-1">
        <span className="field-label">{label}</span>
        <input
          id={id}
          list={`${id}-places`}
          value={value}
          onChange={(event) => onChange(event.target.value)}
          className="field-select"
          placeholder={t('placePlaceholder')}
          autoComplete="off"
          required
        />
        <datalist id={`${id}-places`}>
          {dhakaPlaces.map((place) => <option value={displayPlace(place, language)} key={place} />)}
        </datalist>
      </span>
    </label>
  )
}
