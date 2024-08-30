import './contact/form.js';

const burgerMenu = document.querySelector('#burgerMenu');
const navigation = document.querySelector('#header .navigation');
const flash = document.querySelectorAll('.flash');
const icons = document.querySelectorAll('#burgerMenu svg');

burgerMenu.addEventListener('click', () => {
  navigation.classList.toggle('active');

  icons.forEach(icon => {
    icon.classList.toggle('active');
  })
});

const all = document.querySelectorAll('main *');

all.forEach(e => {
  e.addEventListener('click', () => {
    navigation.classList.remove('active');
  });
})

// close flash message
const hideFlash = e => {
  e.remove()
}

flash.forEach(e => {
  // autoclose
  setTimeout(() => { hideFlash(e) }, 15000);

  // close on click
  const close = e.querySelector('.close');
  close.addEventListener('click', () => {
    hideFlash(e);
  });
})

