/*=============== SHOW MODAL ===============*/
// const showModal = (openButton, modalContent) => {
//     const openBtn = document.getElementById(openButton),
//         modalContainer = document.getElementById(modalContent)

//     if (openBtn && modalContainer) {
//         openBtn.addEventListener('click', () => {
//             modalContainer.classList.add('show-modal')
//         })
//     }
// }
// showModal('open-modal', 'modal-container')

// /*=============== CLOSE MODAL ===============*/
// const closeBtn = document.querySelectorAll('.close-modal')

// function closeModal() {
//     const modalContainer = document.getElementById('modal-container')
//     modalContainer.classList.remove('show-modal')
// }
// closeBtn.forEach(c => c.addEventListener('click', closeModal))

/**
 * @note: status active ( cart, menu)
 * hungtm
 * down
 */

let navbar = document.querySelector('.navbar');

var menu = document.getElementById('menu-btn');
document.addEventListener('click', function(event) {
    var isClickInsideMenu = menu.contains(event.target);

    if (isClickInsideMenu) {
        navbar.classList.toggle('active');
    } else {
        navbar.classList.remove('active');
    }
});

window.onscroll = () => {
    navbar.classList.remove('active');
}

/**
 * @note: slider products
 * hungtm
 * down
 */
// var swiper = new Swiper(".category-slide", {
//     loop: true,
//     spaceBetween: 20,
//     autoplay: {
//         delay: 7500,
//         disableOnInteraction: false,
//     },
//     centeredSlides: true,
//     breakpoints: {
//         0: {
//             slidesPerView: 1,
//         },
//         768: {
//             slidesPerView: 2,
//         },
//         1020: {
//             slidesPerView: 3,
//         },
//     },
// });
/**
 * @note: slider review
 * hungtm
 * down
 */
// var swiper = new Swiper(".member-container", {
//     loop: true,
//     autoplay: {
//         delay: 7500,
//         disableOnInteraction: false,
//     },
//     centeredSlides: true,
//     breakpoints: {
//         0: {
//             slidesPerView: 1,
//         },
//         768: {
//             slidesPerView: 2,
//         },
//         1020: {
//             slidesPerView: 3,
//         },
//     },
// });
/**
 * @note: scroll to top
 * hungtm
 * down
 */

window.addEventListener("scroll", function() {
    var header = document.querySelector(".scrollToTop");
    header.classList.toggle("sticky", window.scrollY > 1000);
});

const scrollToTop = document.querySelector("#scrollToTop");
scrollToTop.addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
    });
});

/**
 * @note: slider
 * hungtm
 * down
 */
var swiper = new Swiper(".slider-container", {
    // spaceBetween: 30,
    // centeredSlides: true,
    // autoplay: {
    //     delay: 7500,
    //     disableOnInteraction: false,
    // },
    // navigation: {
    //     nextEl: ".swiper-button-next",
    //     prevEl: ".swiper-button-prev",
    // },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },
    // loop: true,
    loop: true,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    speed: 450,
    autoplay: {
        delay: 7000,
    },
});
// let slides = document.querySelectorAll('.sliders .sliders-container .slide');
// let index = 0;

// function next() {
//     slides[index].classList.remove('active');
//     index = (index + 1) % slides.length;
//     slides[index].classList.add('active');
// }

// function prev() {
//     slides[index].classList.remove('active');
//     index = (index - 1 + slides.length) % slides.length;
//     slides[index].classList.add('active');
// }
// detail

function changeImage(id) {
    let imagePath = document.getElementById(id).getAttribute('src');
    console.log(imagePath);
    document.getElementById('img-main').setAttribute('src', imagePath);
}



var swiper = new Swiper(".product-slider", {
    spaceBetween: 10,
    centeredSlides: true,
    autoplay: {
        delay: 7500,
        disableOnInteraction: false,
    },
    loop: true,
    breakpoints: {
        769: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        950: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        1390: {
            slidesPerView: 4,
            spaceBetween: 40,
        },
        1660: {
            slidesPerView: 5,
            spaceBetween: 50,
        },
    },
});

var currentLocation = window.location.pathname;
var end = currentLocation.length;

var start = currentLocation.lastIndexOf("\/");

var cut_one = currentLocation.slice(0, start);

var count = cut_one.lastIndexOf("\/");


if (count == -1) {
    var cut_two = currentLocation.slice(0, end);
} else {
    var cut_two = currentLocation.slice(0, count);
}

var home = document.getElementById('link_home');
var category = document.getElementById('link_category');
var product = document.getElementById('link_product');
var accessory = document.getElementById('link_accessory');
var blog = document.getElementById('link_blog');
var contact = document.getElementById('link_contact');

if (cut_two == '/trang-chu') {
    home.classList.add('active');
}
if (cut_two == '/') {
    home.classList.add('active');
}

if (cut_two == '/san-pham') {
    product.classList.add('active');
}

if (cut_two == '/phu-kien') {
    accessory.classList.add('active');
}

if (cut_two == '/bai-viet') {
    blog.classList.add('active');
}

if (cut_two == '/lien-he') {
    contact.classList.add('active');
}

var info = document.getElementById('link_info');
var order = document.getElementById('link_order');
var review = document.getElementById('link_review');


if (count == -1) {
    var nav_bar_C = currentLocation.slice(start, count);
} else {
    var nav_bar_C = currentLocation.slice(start, end);
}

if (cut_two == '/tai-khoan') {
    info.classList.add('active');
}

if (nav_bar_C == '/lich-su-don-hang') {
    order.classList.add('active');
}

if (cut_one == '/tai-khoan/chi-tiet-don-hang') {
    info.classList.remove('active');
    order.classList.add('active');
}

if (nav_bar_C == '/danh-gia-san-pham') {
    review.classList.add('active');
}