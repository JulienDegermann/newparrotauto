const storeSelected = document.getElementById('storeSelected');
const storeSelect = document.getElementById('storeSelect');
const url = new URL('/contact', window.location.origin)

const createCard = datas => {

  // format date to HH:MM
  const formatTime = (dateTimeStr) => {
    const date = new Date(dateTimeStr)
    const hours = date.getUTCHours().toString().padStart(2, '0');
    const minutes = date.getUTCMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
  };


  const formatPlage = (plage) => {
    console.log(plage[0])
    return `${formatTime(plage[0])} - ${formatTime(plage[1])}`
  }

  return (
    `
      <div class="store">
        <h4>${datas.city.toUpperCase()}</h4>
        <p>📍 : ${datas.address}</p>
        <p>📞 : <a class="link" href="tel:${datas.phone}">${datas.phone}</a></p>
        <h5>Horaires d'ouverture :</h5>
        <ul>
          ${Object.keys(datas.openings).map( key => {
            return (
              `<li>${key} : ${datas.openings[key].map( plage => {
                return formatPlage(plage)
                }).join( ' // ' ) } </li>`
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
  // window.location.href = url
  console.log(datas)

  storeSelected.innerHTML = ''
  const newCard = createCard(datas)
  storeSelected.innerHTML = newCard

}

storeSelect.addEventListener('change', handleChange)