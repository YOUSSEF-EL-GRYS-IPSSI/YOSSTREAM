

const burger = document.querySelector('.burgerMobile');
console.log(burger);
const croix = document.querySelector('.croixMobile');

const navbar = document.querySelector('.nav-mobile');
console.log(navbar);



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



///////////////////////////////

const questionr = document.querySelector('.foire-question-r');
const reponser = document.querySelector('.reponse-r');
const pr = document.querySelector('.pr');
console.log(questionr);
console.log(reponser);
console.log(pr);

const questiona = document.querySelector('.foire-question-a');
const reponsea = document.querySelector('.reponse-a');
const pa = document.querySelector('.pa');

const questionz = document.querySelector('.foire-question-z');
const reponsez = document.querySelector('.reponse-z');
const pz = document.querySelector('.pz');

const questione = document.querySelector('.foire-question-e');
const reponsee = document.querySelector('.reponse-e');
const pe = document.querySelector('.pe');




questionr.addEventListener('click', () => {

reponser.classList.toggle("reponse-r");
pr.classList.toggle("pr");

})

questiona.addEventListener('click', () => {

    reponsea.classList.toggle("reponse-a");
    pa.classList.toggle("pa");
    
    })


questionz.addEventListener('click', () => {

    reponsez.classList.toggle("reponse-z");
    pz.classList.toggle("pz");

})

questione.addEventListener('click', () => {

    reponsee.classList.toggle("reponse-e");
    pe.classList.toggle("pe");

})
// questione.addEventListener('click', () => {

//     reponsee.style.display = 'block';;
//    pe.style.display='block';

// })




/////////////////////////////////////



// questiona.addEventListener('click', () => {

//     reponsea.style.display = 'none';
//    pa.style.display='none';

// })
// questionz.addEventListener('click', () => {

//     reponsez.style.display = 'none';
//    pz.style.display='none';

// })
// questione.addEventListener('click', () => {

//     reponsee.style.display = 'none';
//    pe.style.display='none';

// })



