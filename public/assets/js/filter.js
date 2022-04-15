$('#live_search').on('keyup', function() {
    let input = $(this).val();
    $('.card').hide();
    $('.card').filter(function() {
        return new RegExp(input, 'i').test($(this).text())
    }).show();
});