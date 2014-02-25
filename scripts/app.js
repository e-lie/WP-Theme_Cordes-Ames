jQuery.noConflict();
(function($) {
    $(function() {
      
// 	if($('body').hasClass("single-product")){
// 	  var stickyHeaderTop = $('section.purchase').offset().top;
//   
// 	  $(window).scroll(function(){
// 		  if( $(window).scrollTop() > stickyHeaderTop ) {
// 			  $('section.purchase').css({position: 'fixed', top: '0'});
// 		  } else {
// 			  $('section.purchase').css({position: 'static', top: 'auto' });
// 		  }
// 	  });
// 	}
// 	
       // {{{ change display mode : list/grid 
      
					   		   
	//-----------------------------------------------------
	
	var popID = "a-la-une";

	//Faire apparaitre la pop-up et ajouter le bouton de fermeture
	$('.' + popID).fadeIn().prepend('<a href="#" class="close">fermer la fenêtre</a>');
	
	//Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
	var boxWidth = parseInt($('.'+popID).css('paddingLeft'))  +  $('.'+popID).width()  + parseInt($('.'+popID).css('paddingRight'));
	var popMargLeft = ($('body').width()-boxWidth)/$('body').width()/2*100;
	//Apply Margin to Popup
	$('.' + popID).css({ 
		'left' : popMargLeft +'%'
	});
	
	//Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues d'anciennes versions de IE
	$('body').append('<div id="fade"></div>');
	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
	
	//Close Popups and Fade Layer
	$('a.close').click( function() { //Au clic sur le body...
		$('.'+popID).fadeOut();
	});
	
	
	//-----------------------------------------------------


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
    //}}}

    //{{{ AJAX get archives and display
    if($('body').hasClass("post-type-archive-product") || $('body').hasClass("page-template-archive-artist-php") ){
      
      $("a.page-numbers").each(function() {
          $(this).attr("page", $(this).attr("href").split("//")[1]);
      });
      $("a.page-numbers").attr("href", "#archive-wrapper");
    
      $("a.page-numbers").click( function() { load_content($(this).attr("page")); });

      $("#archive-browser select").change( function() { load_content( '1' ); });
    }

    })

  function load_content( page ) {

    $("#archive-wrapper")
      .empty()
      .html("<div style='text-align: center; padding: 30px;'><img src='" + $('#archive-browser').attr('theme-path') + "' /></div>");
  
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
        
    if($('body').hasClass("post-type-archive-product") || $('body').hasClass("page-template-archive-artist-php") ){
        $("a.page-numbers").each(function() {
            $(this).attr("page", $(this).attr("href").split("//")[1]);
        });
        $("a.page-numbers").attr("href", "#archive-wrapper");
      
        $("a.page-numbers").click( function() { load_content($(this).attr("page")); });
      }
    }
      
    });
    
  }

//}}}



})(jQuery);
