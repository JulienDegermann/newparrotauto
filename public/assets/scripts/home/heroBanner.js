// get all services from heroBanner
const services = document.querySelectorAll('.services')

/**
 * active class toggler on mouse enter
 * @param {Event} e 
 */
const handleHoverEnter = (e) => {
  services.forEach(service => {
    service.classList.remove('active')
    e.target.classList.add('active')
  })
}

// mouse enter declenching toggle
services.forEach(service => {
  service.addEventListener('mouseenter', handleHoverEnter)
})


