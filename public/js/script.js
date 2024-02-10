$('#iHealthRefLink').on('click', function() {
    var input = document.createElement('textarea');
    input.innerHTML = $(this).data('ref-link');
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    return false;
});
