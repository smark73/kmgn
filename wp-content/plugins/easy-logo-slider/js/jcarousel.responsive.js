function create_jcarousel(id){
 var ID = '#'+id;
 jQuery.noConflict();
 jQuery(document).ready(function($) {

    $(function() {

        var jcarousel = $(ID + ' .jcarousel');

        jcarousel

            .on('jcarousel:reload jcarousel:create', function () {

                var width = jcarousel.innerWidth();

                if (width >= 1100) {

                    width = width / 8;

                } else if (width >= 992) {

                    width = width / 6;

                } else if (width >= 768) {

                    width = width / 5;

                } else if (width >= 600) {

                    width = width / 4;

                } else if (width >= 480) {

                    width = width / 3;

                }else if (width >= 320) {

                    width = width / 2;

                }else if (width < 320) {

                    width = width / 1;
                }

                jcarousel.jcarousel('items').css('width', width + 'px');
            })

            .jcarousel({

                wrap: 'circular',
				rtl: false

            });

        $(ID + ' .jcarousel-control-prev')

            .jcarouselControl({

                target: '-=1'

            });

        $(ID + ' .jcarousel-control-next')

            .jcarouselControl({

                target: '+=1'

            });
        

        $(ID + ' .jcarousel-pagination')

            .on('jcarouselpagination:active', 'a', function() {

                $(this).addClass('active');

            })

            .on('jcarouselpagination:inactive', 'a', function() {

                $(this).removeClass('active');

            })

            .on('click', function(e) {

                e.preventDefault();

            })

            .jcarouselPagination({

                perPage: 1,

                item: function(page) {

                    return '<a href="#' + page + '">' + page + '</a>';

                }

            });
		$(ID + ' .jcarousel').jcarouselAutoscroll({

   			 interval: 2500,

			create: $(ID + ' .jcarousel').hover(function(){
				$(this).jcarouselAutoscroll('stop');
			},
			function(){
				$(this).jcarouselAutoscroll('start');
			})
		});

    });

 });
}