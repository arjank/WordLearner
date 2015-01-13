(function ($) {
    var $modal = $('.modal-content');

    $modal.on('click', "[type='submit']", function(event){
        event.preventDefault();
        var $button = $(event.target);
        console.log($button.parents('form').serialize());
    });
}(jQuery));
