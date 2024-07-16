/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import Glide, {Controls} from '@glidejs/glide';

// const test = document.querySelector('#commentCarousel')

const commentCarousel = new Glide('#commentCarousel', {
    type: 'carousel',
    startAt: 0,
    perView: 3,
    focusAt: 0,
    autoplay: 5000,   
    arrows: true,
    hoverpause: true,
    animationDuration: 500,
    animationTimingFunc: 'ease-in-out',
    breakpoints: {
        1024: {
            perView: 2
        },
        600: {
            perView: 1
        }
    }
});

commentCarousel.mount();