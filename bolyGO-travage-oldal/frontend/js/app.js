const nav = document.getElementsByTagName("nav")[0];
const navHeight = nav.getBoundingClientRect().height;
window.onscroll = function () {
    if (window.pageYOffset > navHeight) {
        nav.dataset.scrolled = "true";
    } else {
        nav.dataset.scrolled = "false";
    }
}

//TOGGLE NAV
// const toggleNav = () => {
//     if (nav.dataset.state == "closed") {
//         nav.dataset.state = "open";
//     } else {
//         nav.dataset.state = "closed";
//     }
// }

// EZ LENNE AHHOZ HOGY CSAK A NAV ALATT SZINEZŐDJÖN KI DE NEM KELL SZERINTEM
// const header = document.querySelector('header');
// function updateNavColor(entries) {
//     const [entry] = entries;
//     if (!entry.isIntersecting) {
//         nav.dataset.scrolled = "true";
//     } else {
//         nav.dataset.scrolled = "false";
//     }

// }

// const headerObserver = new IntersectionObserver(updateNavColor, {
//     root: null,
//     threshold: 0,
//     rootMargin: `-${navHeight}px`
// });

// headerObserver.observe(header)




//FILTER IMAGES
// const filter = (category) => {
//     // if (category == "Összes"){
//     //     document.querySelectorAll(img).style.show; //markup
//     // }
//     console.log(category);
// };