const stars = document.querySelectorAll('.stars');
const notes = document.querySelectorAll('input[name="comment[note]"]');

const newComment = document.querySelector('#newComment');
const addComment = document.querySelector('#addComment');


const handleShowForm = () => {
  addComment.style.display = 'block';
  addComment.classList.toggle('active');
  newComment.innerHTML = addComment.classList.contains('active') ? 'Annuler' : "Ajouter un commentaire";
}

newComment.addEventListener('click', handleShowForm)

/**
 * 
 * @param {node} star label of input (svg)
 * @param {number} value value of input
 * @param {number} index id of star in the list
 */
const toggleActiveStar = (star, value, index) => {
  if (index >= value) {
    star.classList.remove('active');
  } else {
    star.classList.add('active');
  }
}

notes.forEach(note => {
  note.addEventListener('input', e => {
    const value = e.target.value;

    stars.forEach((star, index) => {
      toggleActiveStar(star, value, index);
    })
  })
})



