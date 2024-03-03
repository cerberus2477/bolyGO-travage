const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;

// nav szinezése
window.onscroll = function () {
    if (window.pageYOffset > navHeight) {
        nav.dataset.scrolled = "true";
    } else {
        nav.dataset.scrolled = "false";
    }
}

// nav kinyitása becsukása (hamburger menü)
const toggleNav = () => {
    if (nav.dataset.state == "closed") {
        nav.dataset.state = "open";
    } else {
        nav.dataset.state = "closed";
    }
}

// kártyák szinezése (hover és hover nélkül) data-color alapján
document.querySelectorAll('.card').forEach(card => {
    const color = card.dataset.color || 'white';
    //a színkód a css globális változóiból jön
    card.addEventListener('mouseenter', () => {
        card.style.border = `1px solid var(--clr-${color})`;
        card.style.boxShadow = `0 8px 16px var(--clr-${color})`;
        console.log(`0 8px 16px var(--clr-${color})`);
    });
    card.addEventListener('mouseleave', () => {
        card.style.boxShadow = `0 4px 8px rgba(0, 0, 0, 0.1)`;
        console.log(`0 4px 8px rgba(0, 0, 0, 0.1)`);
    });
});


//bővebben kártyák váltása

let currentCardIndex = 0;

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
    cards[currentCardIndex].classList.remove('card-hidden');
}