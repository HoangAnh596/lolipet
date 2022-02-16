/**
 * @note: status active detail-product
 * hungtm
 * down
 */

let productDescription = document.querySelector('.product-description');
let shippingDetails = document.querySelector('.shipping-details');
let reviews = document.querySelector('.reviews');
let writeCommment = document.querySelector('.write-comment');

var btnPD = document.getElementById('btn-product-description');
var btnSD = document.getElementById('btn-shipping-details');
var btnRV = document.getElementById('btn-reviews');
var btnRVC = document.getElementById('btn-write-comment');

document.addEventListener('click', function(event) {
    var isClickInsidePD = btnPD.contains(event.target);
    var isClickInsideSD = btnSD.contains(event.target);
    var isClickInsideRV = btnRV.contains(event.target);
    var isClickInsideRVC = btnRVC.contains(event.target);

    if (isClickInsidePD) {
        productDescription.classList.add('active');
        shippingDetails.classList.remove('active');
        reviews.classList.remove('active');
    }

    if (isClickInsideSD) {
        shippingDetails.classList.add('active');
        reviews.classList.remove('active');
        productDescription.classList.remove('active');
    }

    if (isClickInsideRV) {
        reviews.classList.add('active');
        productDescription.classList.remove('active');
        shippingDetails.classList.remove('active');
    }

    if (isClickInsideRVC) {
        writeCommment.classList.toggle('active');
    }
});