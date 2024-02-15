// $('#iHealthRefLink').on('click', function() {
//     var input = document.createElement('textarea');
//     input.innerHTML = $(this).data('ref-link');
//     document.body.appendChild(input);
//     input.select();
//     var result = document.execCommand('copy');
//     document.body.removeChild(input);
//     return false;
// });

var iHealthRefLinkElement = document.getElementById('iHealthRefLink');

if (iHealthRefLinkElement) {
    iHealthRefLinkElement.addEventListener('click', function() {
        var refLink = this.getAttribute('data-ref-link');

        var input = document.createElement('textarea');
        input.value = refLink;
        document.body.appendChild(input);

        input.select();
        var result = document.execCommand('copy');

        document.body.removeChild(input);

        return false;
    });
}

let burgerOpenBtn = document.querySelector('#burger');
let burgerMenu = document.querySelector('#burger__menu');
let burgerCloseBtn = document.querySelector('#burger__menu__close');

burgerOpenBtn.addEventListener('click', function() {
    burgerMenu.classList.add('burger-active');
});

burgerCloseBtn.addEventListener('click', function() {
    burgerMenu.classList.remove('burger-active');
});

document.addEventListener('click', function(event) {
    let isClickInside = burgerMenu.contains(event.target) || burgerOpenBtn.contains(event.target);

    if (!isClickInside) {
        burgerMenu.classList.remove('burger-active');
    }
});
