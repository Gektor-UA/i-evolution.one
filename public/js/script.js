// $('#iHealthRefLink').on('click', function() {
//     var input = document.createElement('textarea');
//     input.innerHTML = $(this).data('ref-link');
//     document.body.appendChild(input);
//     input.select();
//     var result = document.execCommand('copy');
//     document.body.removeChild(input);
//     return false;
// });

document.getElementById('iHealthRefLink').addEventListener('click', function() {
    var refLink = this.getAttribute('data-ref-link');

    var input = document.createElement('textarea');
    input.value = refLink;
    document.body.appendChild(input);

    input.select();
    var result = document.execCommand('copy');

    document.body.removeChild(input);

    return false;
});
