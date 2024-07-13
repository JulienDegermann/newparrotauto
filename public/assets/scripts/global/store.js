const storeSelected = document.getElementById('storeSelected');
const storeSelect = document.getElementById('storeSelect');

const storeSeletects = document.querySelectorAll('.storeSelect');
const storesSecleted = document.querySelectorAll('.storeSelected');

const url = new URL('/contact', window.location.origin)

// format time to hh:mm
const formatTime = (dateTimeStr) => {
  const date = new Date(dateTimeStr)
  const hours = date.getUTCHours().toString().padStart(2, '0');
  const minutes = date.getUTCMinutes().toString().padStart(2, '0');

  return `${hours}:${minutes}`;
};

//  format openings hours [open - close]
const formatPlage = (plage) => {
  return `${formatTime(plage[0])} - ${formatTime(plage[1])}`
}

// card template
const createCard = datas => {
console.log(datas.openings)
  return (
    `
      <div class="storeSelected">
        
        <p>📍 : ${datas.address}</p>
        <p>📞 : <a class="link" href="tel:${datas.phone}">${datas.phone}</a></p>
        <h5>Horaires d'ouverture :</h5>
        <ul>
          ${Object.keys(datas.openings).map(key => {
      return (
        `<li>${key} : ${datas.openings[key].map(plage => {
          return formatPlage(plage)
        }).join(' // ')} </li>`
      )
    }).join('')}
        </ul>
      </div>
  `
  )
}

const updateStore = async (url) => {
  try {
    const res = await fetch(url, { method: 'GET', headers: { Accept: 'application/json' } });
    const data = await res.json()

    return data
  } catch {
    e => console.log(e)
  }
}

const handleChange = async (e) => {

  const params = new URLSearchParams()
  params.append('store', e.target.value)
  url.search = params.toString()

  const datas = await updateStore(url) 

  // delete previous card
  storeSelected.innerHTML = ''
  storesSecleted.forEach(store => {
    store.innerHTML = ''
  })

  // create new card
  const newCard = createCard(datas)

  // insert new card
  storeSelected.innerHTML = newCard
  storesSecleted.forEach(store => {
    store.innerHTML = newCard
  })

  // update selects values
  storeSeletects.forEach(select => {
    select.value = e.target.value
  })

}

storeSelect.addEventListener('change', handleChange)

storeSeletects.forEach(select => {
  select.addEventListener('change', handleChange)
})