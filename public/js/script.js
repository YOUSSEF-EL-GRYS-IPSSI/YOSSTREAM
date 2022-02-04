


const burger = document.querySelector('.burgerMobile');
const croix = document.querySelector('.croixMobile');

const navbar = document.querySelector('.nav-mobile');



burger.addEventListener('click', () => {

    navbar.style.display = 'flex';
    burger.style.display='none';
    croix.style.display='block';

})

croix.addEventListener('click', () => {

     navbar.style.display = 'none';
    burger.style.display='block';
    croix.style.display='none';

})


