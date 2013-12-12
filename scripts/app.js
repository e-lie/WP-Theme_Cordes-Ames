jQuery.noConflict();
(function($) {
    $(function() {

        /*** View mode ***/

        if ( $.cookie('mode') == 'grid' ) {
            grid_update();
        } else if ( $.cookie('mode') == 'list' ) {
            list_update();
        }

        $('#mode').toggle(
            function(){
                if ( $.cookie('mode') == 'grid' ) {
                    $.cookie('mode','list');
                    list();
                } else {
                    $.cookie('mode','grid');
                    grid();
                }
            },
            function(){
                if ( $.cookie('mode') == 'list') {
                    $.cookie('mode','grid');
                    grid();
                } else {
                    $.cookie('mode','list');
                    list();
                }
            }
        );

        function grid(){
            $('#mode').addClass('flip');
            $('ul.products')
                .fadeOut('fast', function(){
                    grid_update();
                    $(this).fadeIn('fast');
                })
            ;
        }

        function list(){
            $('#mode').removeClass('flip');
            $('ul.products')
                .fadeOut('fast', function(){
                    list_update();
                    $(this).fadeIn('fast');
                })
            ;
        }

        function grid_update(){
            $('ul.products').addClass('grid').removeClass('list');
            $.cookie('mode','grid');
        }

        function list_update(){
            $('ul.products').addClass('list').removeClass('grid');
            $.cookie('mode', 'list');
        }

    })
})(jQuery);
