const more = document.querySelector('#more')
const form = document.querySelector('#detail #detailForm')
const images = document.querySelector('#detail .images')

const moreText = more.innerHTML

more.addEventListener('click', () => {
  form.classList.toggle('active')
  more.classList.toggle('CTA')
  images.classList.toggle('hidden')
  more.classList.toggle('outlined')
  more.innerHTML = form.classList.contains('active') ? 'Masquer le formulaire' : 'Plus d\'informations'
});