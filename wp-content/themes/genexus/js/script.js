// Modified http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// Only fires on body class (working off strictly WordPress body_class)

var GenexusSite = {
  // All pages
  common: {
    init: function() {
        
        jQuery(function($) {

            $(document).ready(function() {

                // USER HDR NAV ICON
                var $userNav = $(document).find('.user-nav');

                $userNav.hover(function() {
                    var $button, $menu;
                    $button = $(this);
                    $menu = $button.children('.dropdown');
                    $menu.toggleClass('show-me hide-me');
                    $menu.children('li').click(function() {
                        $menu.removeClass('show-me hide-me');
                        //$button.html($(this).html());
                    });
                });

                // SEARCH HDR NAV ICON
                var $searchNav = $(document).find('.search-nav');
                
                $searchNav.click(function() {
                    var $button;
                    $button = $(this);
                    var $sBar = $(document).find('.searchbar');
                    var $sForm = $sBar.children('.searchbar-form');
                    $sBar.removeClass('hide-me');
                    $sForm.removeClass('hide-me');
                    $sBar.toggleClass('search-hide search-show');

                });


                // MOBILE SLIDING NAV
                // code from sliding panel component from bourbon refills
                $('.mobile-nav-btn,.sliding-panel-fade-screen,.sliding-panel-close').on('click touchstart',function (e) {
                    $('.sliding-panel-content,.sliding-panel-fade-screen').toggleClass('is-visible');
                    e.preventDefault();
                });


            });
        });
        
    },
    finalize: function() { }
  },
  // Home page
  home: {
    init: function() {
        // JS here
    }
  },
  // About page
  about: {
    init: function() {
      // JS here
    }
  }

};

var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = GenexusSite;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {

    UTIL.fire('common');

    jQuery.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });

    UTIL.fire('common', 'finalize');
  }
};

jQuery(document).ready(UTIL.loadEvents);

//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm1haW4uanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJzY3JpcHQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBNb2RpZmllZCBodHRwOi8vcGF1bGlyaXNoLmNvbS8yMDA5L21hcmt1cC1iYXNlZC11bm9idHJ1c2l2ZS1jb21wcmVoZW5zaXZlLWRvbS1yZWFkeS1leGVjdXRpb24vXHJcbi8vIE9ubHkgZmlyZXMgb24gYm9keSBjbGFzcyAod29ya2luZyBvZmYgc3RyaWN0bHkgV29yZFByZXNzIGJvZHlfY2xhc3MpXHJcblxyXG52YXIgR2VuZXh1c1NpdGUgPSB7XHJcbiAgLy8gQWxsIHBhZ2VzXHJcbiAgY29tbW9uOiB7XHJcbiAgICBpbml0OiBmdW5jdGlvbigpIHtcclxuICAgICAgICBcclxuICAgICAgICBqUXVlcnkoZnVuY3Rpb24oJCkge1xyXG5cclxuICAgICAgICAgICAgJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8gVVNFUiBIRFIgTkFWIElDT05cclxuICAgICAgICAgICAgICAgIHZhciAkdXNlck5hdiA9ICQoZG9jdW1lbnQpLmZpbmQoJy51c2VyLW5hdicpO1xyXG5cclxuICAgICAgICAgICAgICAgICR1c2VyTmF2LmhvdmVyKGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYnV0dG9uLCAkbWVudTtcclxuICAgICAgICAgICAgICAgICAgICAkYnV0dG9uID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICAkbWVudSA9ICRidXR0b24uY2hpbGRyZW4oJy5kcm9wZG93bicpO1xyXG4gICAgICAgICAgICAgICAgICAgICRtZW51LnRvZ2dsZUNsYXNzKCdzaG93LW1lIGhpZGUtbWUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkbWVudS5jaGlsZHJlbignbGknKS5jbGljayhmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJG1lbnUucmVtb3ZlQ2xhc3MoJ3Nob3ctbWUgaGlkZS1tZScpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyRidXR0b24uaHRtbCgkKHRoaXMpLmh0bWwoKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyBTRUFSQ0ggSERSIE5BViBJQ09OXHJcbiAgICAgICAgICAgICAgICB2YXIgJHNlYXJjaE5hdiA9ICQoZG9jdW1lbnQpLmZpbmQoJy5zZWFyY2gtbmF2Jyk7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgICRzZWFyY2hOYXYuY2xpY2soZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRidXR0b247XHJcbiAgICAgICAgICAgICAgICAgICAgJGJ1dHRvbiA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzQmFyID0gJChkb2N1bWVudCkuZmluZCgnLnNlYXJjaGJhcicpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkc0Zvcm0gPSAkc0Jhci5jaGlsZHJlbignLnNlYXJjaGJhci1mb3JtJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJHNCYXIucmVtb3ZlQ2xhc3MoJ2hpZGUtbWUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkc0Zvcm0ucmVtb3ZlQ2xhc3MoJ2hpZGUtbWUnKTtcclxuICAgICAgICAgICAgICAgICAgICAkc0Jhci50b2dnbGVDbGFzcygnc2VhcmNoLWhpZGUgc2VhcmNoLXNob3cnKTtcclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgLy8gTU9CSUxFIFNMSURJTkcgTkFWXHJcbiAgICAgICAgICAgICAgICAvLyBjb2RlIGZyb20gc2xpZGluZyBwYW5lbCBjb21wb25lbnQgZnJvbSBib3VyYm9uIHJlZmlsbHNcclxuICAgICAgICAgICAgICAgICQoJy5tb2JpbGUtbmF2LWJ0biwuc2xpZGluZy1wYW5lbC1mYWRlLXNjcmVlbiwuc2xpZGluZy1wYW5lbC1jbG9zZScpLm9uKCdjbGljayB0b3VjaHN0YXJ0JyxmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJy5zbGlkaW5nLXBhbmVsLWNvbnRlbnQsLnNsaWRpbmctcGFuZWwtZmFkZS1zY3JlZW4nKS50b2dnbGVDbGFzcygnaXMtdmlzaWJsZScpO1xyXG4gICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0pO1xyXG4gICAgICAgIFxyXG4gICAgfSxcclxuICAgIGZpbmFsaXplOiBmdW5jdGlvbigpIHsgfVxyXG4gIH0sXHJcbiAgLy8gSG9tZSBwYWdlXHJcbiAgaG9tZToge1xyXG4gICAgaW5pdDogZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgLy8gSlMgaGVyZVxyXG4gICAgfVxyXG4gIH0sXHJcbiAgLy8gQWJvdXQgcGFnZVxyXG4gIGFib3V0OiB7XHJcbiAgICBpbml0OiBmdW5jdGlvbigpIHtcclxuICAgICAgLy8gSlMgaGVyZVxyXG4gICAgfVxyXG4gIH1cclxuXHJcbn07XHJcblxyXG52YXIgVVRJTCA9IHtcclxuICBmaXJlOiBmdW5jdGlvbihmdW5jLCBmdW5jbmFtZSwgYXJncykge1xyXG4gICAgdmFyIG5hbWVzcGFjZSA9IEdlbmV4dXNTaXRlO1xyXG4gICAgZnVuY25hbWUgPSAoZnVuY25hbWUgPT09IHVuZGVmaW5lZCkgPyAnaW5pdCcgOiBmdW5jbmFtZTtcclxuICAgIGlmIChmdW5jICE9PSAnJyAmJiBuYW1lc3BhY2VbZnVuY10gJiYgdHlwZW9mIG5hbWVzcGFjZVtmdW5jXVtmdW5jbmFtZV0gPT09ICdmdW5jdGlvbicpIHtcclxuICAgICAgbmFtZXNwYWNlW2Z1bmNdW2Z1bmNuYW1lXShhcmdzKTtcclxuICAgIH1cclxuICB9LFxyXG4gIGxvYWRFdmVudHM6IGZ1bmN0aW9uKCkge1xyXG5cclxuICAgIFVUSUwuZmlyZSgnY29tbW9uJyk7XHJcblxyXG4gICAgalF1ZXJ5LmVhY2goZG9jdW1lbnQuYm9keS5jbGFzc05hbWUucmVwbGFjZSgvLS9nLCAnXycpLnNwbGl0KC9cXHMrLyksZnVuY3Rpb24oaSxjbGFzc25tKSB7XHJcbiAgICAgIFVUSUwuZmlyZShjbGFzc25tKTtcclxuICAgIH0pO1xyXG5cclxuICAgIFVUSUwuZmlyZSgnY29tbW9uJywgJ2ZpbmFsaXplJyk7XHJcbiAgfVxyXG59O1xyXG5cclxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShVVElMLmxvYWRFdmVudHMpO1xyXG4iXX0=
