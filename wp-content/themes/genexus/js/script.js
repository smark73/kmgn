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
                    var $sInput = $sForm.children('.search-field');
                    $sBar.removeClass('hide-me');
                    $sForm.removeClass('hide-me');
                    $sBar.toggleClass('search-hide search-show');
                    if($sBar.hasClass('search-show')){
                        $sInput.focus();
                    }
                    if($sBar.hasClass('search-hide')){
                        $sInput.val('');
                        $sInput.blur();
                    }
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

//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm1haW4uanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6InNjcmlwdC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIE1vZGlmaWVkIGh0dHA6Ly9wYXVsaXJpc2guY29tLzIwMDkvbWFya3VwLWJhc2VkLXVub2J0cnVzaXZlLWNvbXByZWhlbnNpdmUtZG9tLXJlYWR5LWV4ZWN1dGlvbi9cclxuLy8gT25seSBmaXJlcyBvbiBib2R5IGNsYXNzICh3b3JraW5nIG9mZiBzdHJpY3RseSBXb3JkUHJlc3MgYm9keV9jbGFzcylcclxuXHJcbnZhciBHZW5leHVzU2l0ZSA9IHtcclxuICAvLyBBbGwgcGFnZXNcclxuICBjb21tb246IHtcclxuICAgIGluaXQ6IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgIFxyXG4gICAgICAgIGpRdWVyeShmdW5jdGlvbigkKSB7XHJcblxyXG4gICAgICAgICAgICAkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyBVU0VSIEhEUiBOQVYgSUNPTlxyXG4gICAgICAgICAgICAgICAgdmFyICR1c2VyTmF2ID0gJChkb2N1bWVudCkuZmluZCgnLnVzZXItbmF2Jyk7XHJcblxyXG4gICAgICAgICAgICAgICAgJHVzZXJOYXYuaG92ZXIoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRidXR0b24sICRtZW51O1xyXG4gICAgICAgICAgICAgICAgICAgICRidXR0b24gPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgICRtZW51ID0gJGJ1dHRvbi5jaGlsZHJlbignLmRyb3Bkb3duJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJG1lbnUudG9nZ2xlQ2xhc3MoJ3Nob3ctbWUgaGlkZS1tZScpO1xyXG4gICAgICAgICAgICAgICAgICAgICRtZW51LmNoaWxkcmVuKCdsaScpLmNsaWNrKGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkbWVudS5yZW1vdmVDbGFzcygnc2hvdy1tZSBoaWRlLW1lJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vJGJ1dHRvbi5odG1sKCQodGhpcykuaHRtbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vIFNFQVJDSCBIRFIgTkFWIElDT05cclxuICAgICAgICAgICAgICAgIHZhciAkc2VhcmNoTmF2ID0gJChkb2N1bWVudCkuZmluZCgnLnNlYXJjaC1uYXYnKTtcclxuICAgICAgICAgICAgICAgIFxyXG4gICAgICAgICAgICAgICAgJHNlYXJjaE5hdi5jbGljayhmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGJ1dHRvbjtcclxuICAgICAgICAgICAgICAgICAgICAkYnV0dG9uID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHNCYXIgPSAkKGRvY3VtZW50KS5maW5kKCcuc2VhcmNoYmFyJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzRm9ybSA9ICRzQmFyLmNoaWxkcmVuKCcuc2VhcmNoYmFyLWZvcm0nKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHNJbnB1dCA9ICRzRm9ybS5jaGlsZHJlbignLnNlYXJjaC1maWVsZCcpO1xyXG4gICAgICAgICAgICAgICAgICAgICRzQmFyLnJlbW92ZUNsYXNzKCdoaWRlLW1lJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJHNGb3JtLnJlbW92ZUNsYXNzKCdoaWRlLW1lJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgJHNCYXIudG9nZ2xlQ2xhc3MoJ3NlYXJjaC1oaWRlIHNlYXJjaC1zaG93Jyk7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoJHNCYXIuaGFzQ2xhc3MoJ3NlYXJjaC1zaG93Jykpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc0lucHV0LmZvY3VzKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCRzQmFyLmhhc0NsYXNzKCdzZWFyY2gtaGlkZScpKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHNJbnB1dC52YWwoJycpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc0lucHV0LmJsdXIoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgLy8gTU9CSUxFIFNMSURJTkcgTkFWXHJcbiAgICAgICAgICAgICAgICAvLyBjb2RlIGZyb20gc2xpZGluZyBwYW5lbCBjb21wb25lbnQgZnJvbSBib3VyYm9uIHJlZmlsbHNcclxuICAgICAgICAgICAgICAgICQoJy5tb2JpbGUtbmF2LWJ0biwuc2xpZGluZy1wYW5lbC1mYWRlLXNjcmVlbiwuc2xpZGluZy1wYW5lbC1jbG9zZScpLm9uKCdjbGljayB0b3VjaHN0YXJ0JyxmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgICAgICQoJy5zbGlkaW5nLXBhbmVsLWNvbnRlbnQsLnNsaWRpbmctcGFuZWwtZmFkZS1zY3JlZW4nKS50b2dnbGVDbGFzcygnaXMtdmlzaWJsZScpO1xyXG4gICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0pO1xyXG4gICAgICAgIFxyXG4gICAgfSxcclxuICAgIGZpbmFsaXplOiBmdW5jdGlvbigpIHsgfVxyXG4gIH0sXHJcbiAgLy8gSG9tZSBwYWdlXHJcbiAgaG9tZToge1xyXG4gICAgaW5pdDogZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgLy8gSlMgaGVyZVxyXG4gICAgfVxyXG4gIH0sXHJcbiAgLy8gQWJvdXQgcGFnZVxyXG4gIGFib3V0OiB7XHJcbiAgICBpbml0OiBmdW5jdGlvbigpIHtcclxuICAgICAgLy8gSlMgaGVyZVxyXG4gICAgfVxyXG4gIH1cclxuXHJcbn07XHJcblxyXG52YXIgVVRJTCA9IHtcclxuICBmaXJlOiBmdW5jdGlvbihmdW5jLCBmdW5jbmFtZSwgYXJncykge1xyXG4gICAgdmFyIG5hbWVzcGFjZSA9IEdlbmV4dXNTaXRlO1xyXG4gICAgZnVuY25hbWUgPSAoZnVuY25hbWUgPT09IHVuZGVmaW5lZCkgPyAnaW5pdCcgOiBmdW5jbmFtZTtcclxuICAgIGlmIChmdW5jICE9PSAnJyAmJiBuYW1lc3BhY2VbZnVuY10gJiYgdHlwZW9mIG5hbWVzcGFjZVtmdW5jXVtmdW5jbmFtZV0gPT09ICdmdW5jdGlvbicpIHtcclxuICAgICAgbmFtZXNwYWNlW2Z1bmNdW2Z1bmNuYW1lXShhcmdzKTtcclxuICAgIH1cclxuICB9LFxyXG4gIGxvYWRFdmVudHM6IGZ1bmN0aW9uKCkge1xyXG5cclxuICAgIFVUSUwuZmlyZSgnY29tbW9uJyk7XHJcblxyXG4gICAgalF1ZXJ5LmVhY2goZG9jdW1lbnQuYm9keS5jbGFzc05hbWUucmVwbGFjZSgvLS9nLCAnXycpLnNwbGl0KC9cXHMrLyksZnVuY3Rpb24oaSxjbGFzc25tKSB7XHJcbiAgICAgIFVUSUwuZmlyZShjbGFzc25tKTtcclxuICAgIH0pO1xyXG5cclxuICAgIFVUSUwuZmlyZSgnY29tbW9uJywgJ2ZpbmFsaXplJyk7XHJcbiAgfVxyXG59O1xyXG5cclxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShVVElMLmxvYWRFdmVudHMpO1xyXG4iXX0=
