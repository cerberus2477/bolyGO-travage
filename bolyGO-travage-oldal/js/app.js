const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;
window.onscroll = function () {
    if (window.pageYOffset > navHeight) {
        nav.dataset.scrolled = "true";
    } else {
        nav.dataset.scrolled = "false";
    }
}


// kártyák szinezése
document.querySelectorAll('.card').forEach(card => {
    const color = card.dataset.color || 'white';
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
