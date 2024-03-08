const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;
const smallCards = document.querySelectorAll('#csomagok .card');
const bigCards = document.querySelectorAll('.big-card');
const navLinks = document.querySelectorAll('nav a');
const planet = document.querySelector('.scrolling-planet');

var scrolled = 0;

// nav szinezése és bolygó eltolása-------------------------------------------------------------------------------------------------------
window.onscroll = function () {
    scrolled = window.scrollY;

    nav.dataset.scrolled = window.pageYOffset > navHeight;
    planet.style.right = planet.getAttribute('--offset-x') + scrolled * 0.5 + 'px';

    navLinks.forEach(link => {
        const sectionId = link.getAttribute('href').substring(1);
        const section = document.getElementById(sectionId);

        if (section.offsetTop <= scrolled && section.offsetTop + section.offsetHeight > scrolled) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

//nav linkeken smooth scrolling (nem lesz a cím a navbar mögött)
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const sectionId = link.getAttribute('href').substring(1); //le kell vágni a #-et
        const section = document.getElementById(sectionId);

        window.scrollTo({
            top: section.offsetTop,
            behavior: 'smooth'
        });
    });
});

// nav kinyitása becsukása (hamburger menü) -------------------------------------------------------------------------------------------------------
const toggleNav = () => {
    nav.dataset.state = nav.dataset.state == "closed" ? "open" : "closed";
}




// kártyák szinezése (hover és hover nélkül) data-color alapján-------------------------------------------------------------------------------------------------------
smallCards.forEach(card => {
    const color = card.dataset.color || 'white';
    if (color){
        card.style.setProperty('--accent-color', `var(--clr-${color})`);
    }
});

//minden nagy kártya ugyanolyan színű mint a megfelelő kis kártya
bigCards.forEach(bigCard => {
    bigCard.dataset.color = document.querySelector(`.csomag-container .card[data-csomagid="${bigCard.dataset.csomagid}"]`).dataset.color;
});
    



//bővebben kártyák váltása -------------------------------------------------------------------------------------------------------
let currentCardIndex = 0;
console.log(currentCardIndex);

//azért hogy az első látható legyen alapból de a többi ne
showNextCard();
showPrevCard();

function showNextCard() {
    const cards = document.querySelectorAll('.big-card');
    cards[currentCardIndex].classList.add('card-hidden');
    currentCardIndex = (currentCardIndex + 1) % cards.length;
    cards[currentCardIndex].classList.remove('card-hidden');
}

function showPrevCard() {
    const cards = document.querySelectorAll('.big-card');
    cards[currentCardIndex].classList.add('card-hidden');
    currentCardIndex = (currentCardIndex - 1 + cards.length) % cards.length;
    // ugyanaz mint currentCardIndex = currentCardIndex === 0 ? cards.length - 1 : currentCardIndex - 1;
    cards[currentCardIndex].classList.remove('card-hidden');
}

function jumpTo(csomagid) {
    const cards = document.querySelectorAll('.big-card');
    cards[currentCardIndex].classList.add('card-hidden');
    let currentCard = document.querySelector(`.big-card[data-csomagid="${csomagid}"]`);
    console.log(currentCard);
    currentCard.classList.remove('card-hidden');
    currentCardIndex = [].indexOf.call(cards, currentCard);
    document.getElementById("hosszuleiras").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
}