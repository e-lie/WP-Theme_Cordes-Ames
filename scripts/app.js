jQuery.noConflict();
(function($) {
    $(function() {
      
	if($('body').hasClass("single-product")){
	  var stickyHeaderTop = $('section.purchase').offset().top;
  
	  $(window).scroll(function(){
		  if( $(window).scrollTop() > stickyHeaderTop ) {
			  $('section.purchase').css({position: 'fixed', top: '0'});
		  } else {
			  $('section.purchase').css({position: 'static', top: 'auto' });
		  }
	  });
	}
// 	
       // {{{ change display mode : list/grid 

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
                    console.log('grid 1');
                    $.cookie('mode','grid');
                    grid();
                }
            },
            function(){
                if ( $.cookie('mode') == 'list') {
                    console.log('grid 2');
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
                    console.log('grid 12');
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
    //}}}

    //{{{ AJAX get archives and display
      
      $("a.page-numbers").each(function() {
          $(this).attr("page", $(this).attr("href").split("//")[1]);
      });
      $("a.page-numbers").attr("href", "#archive-wrapper");
    
      $("a.page-numbers").click( function() { load_content($(this).attr("page")); });

      $("#archive-browser select").change( function() { load_content( '1' ); });/*function() {
      
        $("#archive-wrapper")
          .empty()
          .html("<div style='text-align: center; padding: 30px;'><img src='/cordesetames/wp-content/themes/Theme_Cordes&Ames/images/ajax-loader.gif' /></div>");
      
        var dateArray = $("#date-choice").val().split("/");
        var y = dateArray[4];
        var m = dateArray[5];
        var cat = $("#cat").val();
        var target = $("#archive-browser").attr("target");
        var type = $("#archive-browser").attr("type");
        var page = 1;

        
        $.ajax({
        
          url: target,
          dataType: "html",
          type: "POST",
          data: ({
            "cea_t" : type,
            "cea_y" : y,
            "cea_m" : m,
            "cea_c" : cat,
            "cea_p" : page
          }),
          success: function(data) {
            $("#archive-wrapper").html(data);

            if( $.cookie('mode') == 'grid' ) {
              $('ul.products').addClass('grid').removeClass('list');
            }else{
              $('ul.products').addClass('list').removeClass('grid');
            }
            
            $("a.page-numbers").each(function() {
                $(this).attr("page", $(this).attr("href").split("//")[1]);
            });
            $("a.page-numbers").attr("href", "#archive-wrapper");
          
            $("a.page-numbers").click( function() { load_page($(this).attr("page")); });
          }
          
        });
        
      });
      */

    })

  function load_content( page ) {

    $("#archive-wrapper")
      .empty()
      .html("<div style='text-align: center; padding: 30px;'><img src='/cordesetames/wp-content/themes/Theme_Cordes&Ames/images/ajax-loader.gif' /></div>");
  
    var dateArray = $("#date-choice").val().split("/");
    var y = dateArray[4];
    var m = dateArray[5];
    var cat = $("#cat").val();
    var target = $("#archive-browser").attr("target");
    var type = $("#archive-browser").attr("type");
    var orderby = $("#orderby").val();

    
    $.ajax({
    
      url: target,
      dataType: "html",
      type: "POST",
      data: ({
        "cea_t" : type,
        "cea_y" : y,
        "cea_m" : m,
        "cea_c" : cat,
        "cea_p" : page,
        "cea_o" : orderby
      }),
      success: function(data) {
        $("#archive-wrapper").html(data);

        if( $.cookie('mode') == 'grid' ) {
          $('ul.products').addClass('grid').removeClass('list');
        }else{
          $('ul.products').addClass('list').removeClass('grid');
        }
        
        $("a.page-numbers").each(function() {
            $(this).attr("page", $(this).attr("href").split("//")[1]);
        });
        $("a.page-numbers").attr("href", "#archive-wrapper");
      
        $("a.page-numbers").click( function() { load_content($(this).attr("page")); });
      }
      
    });
    
  }

//}}}



})(jQuery);
