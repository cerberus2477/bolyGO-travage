const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;
const navLinks = document.querySelectorAll('.navlink');
const planet = document.querySelector('.scrolling-planet');
const headerContent = document.querySelector('.header-content');
const cards = document.querySelectorAll('.card');
const bigCards = document.querySelectorAll('.big-card');
let pxScrolled;

// görgetésre változó dolgok ------------------------------------------------------------------------------------
window.onscroll = function () {
    pxScrolled = window.scrollY;

    // nav szinezése 
    nav.dataset.scrolled = pxScrolled > navHeight;

    // planet csusztatasa görgetésre és szöveg változtatása
    if (planet) { //csak az index.phpn
        planet.style.right = -100 + pxScrolled * 0.5 + 'px';
        // headerContent.style.fontSize = (3 - pxScrolled / 500) + 'rem';
    }
    

    //nav linkek aláhúzása
    if (planet) {
        navLinks.forEach(link => {
            const sectionId = link.getAttribute('href').substring(10); // le kell vágni az elejéről az index.php# -t
            const section = document.getElementById(sectionId);
            console.log(sectionId);

            // ha a megfelelő section tetejénél lejjebb tekertünk de az aljáig meg nem "active" lesz az arra mutató menüpont
            link.dataset.active = section.offsetTop <= pxScrolled && section.offsetTop + section.offsetHeight > pxScrolled;
        });
    }
}


// nav kinyitása - becsukása (hamburger menü)
const toggleNav = () => {
    nav.dataset.state = nav.dataset.state == "closed" ? "open" : "closed";
}


// menüpontra kattintásra kicsit feljebb görget mint magától tenné, így a navbar nem takarja ki a rész tetejét
// navLinks.forEach(link => {
//     link.addEventListener('click', function (e) {
//         e.preventDefault();
//         const sectionId = link.getAttribute('href').substring(1);
//         const section = document.getElementById(sectionId);

//         window.scrollTo({
//             top: section.offsetTop,
//             behavior: 'smooth'
//         });
//     });
// });





// minden nagy kártya ugyanolyan színű mint a megfelelő kis kártya
bigCards.forEach(bigCard => {
    const csomagId = bigCard.dataset.csomagid;
    cards.forEach(card => {
        if (card.dataset.csomagid === csomagId) {
            bigCard.dataset.color = card.dataset.color;
        }
    });
});
    
// kártyák szinezése (hover és hover nélkül) data-color alapján-------------------------------------------------------------------------------------------------------
cards.forEach(card => {
    const color = card.dataset.color || 'white';
    card.style.setProperty('--accent-color', `var(--clr-${color})`);
    const lightColors = ['teal', 'green', 'yellow'];
    if (!lightColors.includes(color)) {
        card.style.setProperty('--text-color', `var(--clr-white)`);
    }
});



//bővebben kártyák váltása -------------------------------------------------------------------------------------------------------
let currentIndex = 0;

//azért hogy az első látható legyen alapból de a többi ne
showNextCard();
showPrevCard();

function showNextCard() {
    bigCards[currentIndex].classList.add('card-hidden');
    currentIndex = (currentIndex + 1) % bigCards.length;
    bigCards[currentIndex].classList.remove('card-hidden');
}

function showPrevCard() {
    bigCards[currentIndex].classList.add('card-hidden');
    currentIndex = (currentIndex - 1 + bigCards.length) % bigCards.length;
    // ugyanaz mint currentIndex = currentIndex === 0 ? cards.length - 1 : currentIndex - 1;
    bigCards[currentIndex].classList.remove('card-hidden');
}

function jumpTo(csomagid) {
    bigCards[currentIndex].classList.add('card-hidden');
    let currentCard = document.querySelector(`.big-card[data-csomagid="${csomagid}"]`);
    currentCard.classList.remove('card-hidden');
    currentIndex = [].indexOf.call(bigCards, currentCard);
    document.getElementById("bovebben").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
}
