(function (root, $) {

    function init(container, actionItems) {
        var $modal = $(container);

        $modal.on('click', actionItems, function(event){
            event.preventDefault();
            var $button = $(event.target);
            console.log($button.parents('form').serialize());
        });
    }

    root.WLModal = {
        init: init
    };

}(window, jQuery));
