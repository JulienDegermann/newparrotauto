const formInputs = document.querySelectorAll('.formInput');

// regex
const nameInput = new RegExp(/^[a-zA-Z0-9\s\-\p{L}]{2,255}$/u);
const textInput = new RegExp(/^[a-zA-Z0-9\s.,'?!\-\p{L}]{2,}$/u);
const emailInput = new RegExp(/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/);
const phoneInput = new RegExp(/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2,})$/);

formInputs.forEach(formInput => {
  formInput.addEventListener('input', e => {
    const value = e.target.value
    const name = e.target.name;
    let isValid = false;

    if (name === 'contact[author][firstName]' || name === 'comment[name]' || name === 'contact[author][lastName]') {
      isValid = nameInput.test(value);
    }

    if (name === 'contact[author][email]') {
      isValid = emailInput.test(value);
    }

    if (name === 'contact[author][phone]') {
      isValid = phoneInput.test(value);
    }

    if (name === 'contact[text]' || name === 'comment[text]') {
      isValid = textInput.test(value);
    }


    if (name === 'comment[note]' && !isNaN(value)) {
      isValid = true;
    } else if (isValid) {
      formInput.classList.add('valid');
      formInput.classList.remove('notValid');
    } else {
      formInput.classList.remove('valid');
      formInput.classList.add('notValid');
    }
  })
})