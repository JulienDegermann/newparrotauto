const burgerMenu = document.querySelector('#burgerMenu');
const navigation = document.querySelector('#header .navigation');

const icons = document.querySelectorAll('#burgerMenu svg');

console.log(burgerMenu);

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