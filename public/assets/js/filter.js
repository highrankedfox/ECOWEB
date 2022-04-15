$(document).ready(function(){
    $('#live_search').on('keyup', function(e){
        var input = $(this).val();
        var $search = $('#live_search');

        $.ajax({
            url:        'formations/search',
            type:       'GET',
            dataType:   'json',
            async:      true,

            success: function(response) {
                $('#search_results').replaceWith(response);
            },
            error : function() {
                alert('Une erreur est survenue');
            }
        });
    });
});