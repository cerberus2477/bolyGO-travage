//nav toggle and color change on scroll

const nav = document.querySelector(".main-nav");
const toggleNav = () => {
    if (nav.dataset.state == "closed") {
        nav.dataset.state = "open";
    } else {
        nav.dataset.state = "closed";
    }
}


// const header = document.querySelector('header');
const navHeight = nav.getBoundingClientRect().height;

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



window.onscroll = function () {
    if (window.pageYOffset > navHeight) {
        nav.dataset.scrolled = "true";
    } else {
        nav.dataset.scrolled = "false";
    }
}


//FILTER IMAGES IN GALERIA.HTML
const filter = (category) => {
    // if (category == "Összes"){
    //     document.querySelectorAll(img).style.show; //markup
    // }
    console.log(category);
};