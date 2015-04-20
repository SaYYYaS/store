function updateActive($link, response){
    if($link instanceof $){
        var original_url = $link.attr('href');
        var switch_url = $link.attr('data-url');
        var $icon = $link.children('i');
        $link.attr('href',switch_url);
        $link.attr('data-url',original_url);
        //switching icon
        if($icon.hasClass('fa-times') || $icon.hasClass('fa-check')){
            $icon.toggleClass('fa fa-check');
            $icon.toggleClass('fa fa-times');
        }
        else{
            $icon.toggleClass('fa fa-star');
            $icon.toggleClass('fa fa-star-o');
        }
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

function updateState($link,response){
    if($link instanceof $){
        //Parcourt les message de la response et les affiche
        //Disable this and search closest to remove disable
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
    $link = $(this);
    $.ajax({
        url: $link.attr('href')
    }).done(function (response) {
        updateActive($link,response);
    })
});

//Update this function
$('.switchable-element a').on('click', function(e) {
    var $link = $(this);
    $.ajax({
        url: $link.attr('href')
    }).done(function (response) {
        $link.parent().children('.btn').removeClass('disabled');
        $link.addClass('disabled');
        updateState($link,response);
    })
});
