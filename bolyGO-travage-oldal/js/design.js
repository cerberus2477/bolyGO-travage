const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;
const navLinks = document.querySelectorAll('nav a');
const planet = document.querySelector('.scrolling-planet');
const headerContent = document.querySelector('.header-content');
const smallcards = document.querySelectorAll('#csomag-container .card');
const bigcards = document.querySelectorAll('.big-card');
let pxScrolled;

// görgetésre változó dolgok ------------------------------------------------------------------------------------
window.onscroll = function () {
    pxScrolled = window.scrollY;

    // nav szinezése 
    nav.dataset.scrolled = pxScrolled > navHeight;

    // planet csusztatasa görgetésre és szöveg
    planet.style.right = -100 + pxScrolled * 0.5 + 'px';
    headerContent.style.fontSize = (3 - pxScrolled / 500) + 'rem';

    //nav linkek aláhúzása
    setActiveLink();
}


// nav kinyitása - becsukása (hamburger menü)
const toggleNav = () => {
    nav.dataset.state = nav.dataset.state == "closed" ? "open" : "closed";
}

//nav linkek aláhúzása görgetés alapján
function setActiveLink() {
    navLinks.forEach(link => {
        const sectionId = link.getAttribute('href').substring(1); // ???
        const section = document.getElementById(sectionId);

        if (section.offsetTop <= pxScrolled && section.offsetTop + section.offsetHeight > pxScrolled) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}


// hogy alapból alá legyen húzva aminek kell
setActiveLink();

// kattintásra kicsit feljebb görget mint magától tenné, így a navbar nem takarja ki a címet pl
navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const sectionId = link.getAttribute('href').substring(1);
        const section = document.getElementById(sectionId);

        window.scrollTo({
            top: section.offsetTop,
            behavior: 'smooth'
        });
    });
});



// kártyák szinezése (hover és hover nélkül) data-color alapján-------------------------------------------------------------------------------------------------------
smallcards.forEach(card => {
    const color = card.dataset.color || 'white';
    if (color){
        card.style.setProperty('--accent-color', `var(--clr-${color})`);
    }
});

//minden nagy kártya ugyanolyan színű mint a megfelelő kis kártya
bigcards.forEach(bigCard => {
    bigCard.dataset.color = document.querySelector(`.csomag-container .card[data-csomagid="${bigCard.dataset.csomagid}"]`).dataset.color;
});
    


//bővebben kártyák váltása -------------------------------------------------------------------------------------------------------
let currentIndex = 0;

//azért hogy az első látható legyen alapból de a többi ne
showNextCard();
showPrevCard();

function showNextCard() {
    bigcards[currentIndex].classList.add('card-hidden');
    currentIndex = (currentIndex + 1) % bigcards.length;
    bigcards[currentIndex].classList.remove('card-hidden');
}

function showPrevCard() {
    bigcards[currentIndex].classList.add('card-hidden');
    currentIndex = (currentIndex - 1 + cards.length) % cards.length;
    // ugyanaz mint currentIndex = currentIndex === 0 ? cards.length - 1 : currentIndex - 1;
    bigcards[currentIndex].classList.remove('card-hidden');
}

function jumpTo(csomagid) {
    bigcards[currentIndex].classList.add('card-hidden');
    let currentCard = document.querySelector(`div[data-csomagid="${csomagid}"]`);
    currentCard.classList.remove('card-hidden');
    currentIndex = [].indexOf.call(bigcards, currentCard);
    document.getElementById("hosszuleiras").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
}