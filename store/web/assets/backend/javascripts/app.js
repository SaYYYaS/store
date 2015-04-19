function updateActive($link, response){
    if($link instanceof $){
        var original_url = $link.attr('href');
        var switch_url = $link.attr('data-url');
        $link.attr('href',switch_url);
        $link.attr('data-url',original_url);
        $link.children('i').toggleClass('fa fa-check');
        $link.children('i').toggleClass('fa fa-times');
        //Parcourt les message de la response et les affiche
        $.each(response.messages[response.template],function(key,msg){
            var $flash = $('\
                        <div class="alert alert-dark alert-'+ response.template + '">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <span aria-hidden="true">&times;</span>\
                        </button>' + msg + '</div>")'
            );
            var $content = $('#content-wrapper .table-primary.table.table-bordered');
            $content.parent().find('.alert.alert-dark').remove();
            $content.before($flash);
        });
        return true;
    }
    else{
        return false;
    }
}

//Adding event listener to activate-element
$('.activable-element a').on('click', function(e) {
    e.preventDefault();
    var $link = $(this);
    $.ajax({
        url: $link.attr('href')
    }).done(function (response) {
        updateActive($link,response);
    })
});
