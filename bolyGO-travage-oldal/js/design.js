const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;

// nav szinezése -------------------------------------------------------------------------------------------------------
window.onscroll = function () {
    if (window.pageYOffset > navHeight) {
        nav.dataset.scrolled = "true";
    } else {
        nav.dataset.scrolled = "false";
    }
}

// nav kinyitása becsukása (hamburger menü) -------------------------------------------------------------------------------------------------------
const toggleNav = () => {
    if (nav.dataset.state == "closed") {
        nav.dataset.state = "open";
    } else {
        nav.dataset.state = "closed";
    }
}

// planet csusztatasa görgetésre----------------------------------------------------------------------------------
window.addEventListener('scroll', function () {
    var scrolled = window.scrollY;
    var planet = document.querySelector('.scrolling-planet');
    planet.style.right = -100 + scrolled * 0.5 + 'px';
});

// kártyák szinezése (hover és hover nélkül) data-color alapján-------------------------------------------------------------------------------------------------------
document.querySelectorAll('.card').forEach(card => {
    const color = card.dataset.color || 'white';
    if (color){
        card.style.setProperty('--accent-color', `var(--clr-${color})`);
    }
});

//minden nagy kártya ugyanolyan színű mint a megfelelő kis kártya
document.querySelectorAll('.big-card').forEach(bigCard => {
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