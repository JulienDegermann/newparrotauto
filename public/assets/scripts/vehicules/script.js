const more = document.querySelector('#more')
const form = document.querySelector('#detail #detailForm')
const moreText = more.innerHTML
const mainImage = document.querySelector('#detail #mainPicture')
const images = document.querySelectorAll('#detail .imageCarousel img')

more.addEventListener('click', () => {
  form.classList.toggle('active')
  more.innerHTML = form.classList.contains('active') ? 'Masquer le formulaire' : 'Plus d\'informations'
  more.classList.toggle('CTA')
  more.classList.toggle('outlined')
  images.classList.toggle('hidden')
});



images.forEach(image => {
  image.addEventListener('click', () => {
    console.log(image.src)
    mainImage.src = image.src
  })
})