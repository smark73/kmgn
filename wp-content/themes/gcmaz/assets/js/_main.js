// Modified http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// Only fires on body class (working off strictly WordPress body_class)

var GcmazSite = {
  // All pages
  common: {
    init: function() {
        
        // ****  START PAGE TAKEOVER
        // page takeover header shrink from 250 to 100
        // hdr wraps hdr1 and hdr2
        var $tkohdr = $(document).find('.takeover-hdr');
        var $tkohdr1 = $(document).find('.takeover-hdr1');
        var $tkohdr2 = $(document).find('.takeover-hdr2');
        
        //create the object to store hdr vars
        function Tko($tkohdr, $tkohdr1, $tkohdr2){
            this.tkohdr = $tkohdr;
            this.tkohdr1 = $tkohdr1;
            this.tkohdr2 = $tkohdr2;
            this.h1 = this.tkohdr1.height();
            this.h2 = this.tkohdr2.height();
            this.set_h = function(p){ this.h2 = Math.round(150*p); this.tkohdr2.height = this.h; this.tkohdr.height = this.h1 + this.h2; };
        }
        var t = new Tko($tkohdr, $tkohdr1, $tkohdr2);
        
        //initialize percentage then heights
        var p = t.tkohdr2.innerWidth()/1000;
        t.set_h(p);
        
        //window resize funx
        $(window).resize(function(){
            //set timer cuz window.resize needs to wait to get final heights
            function resizedw(){
                //reset percentage then height
                var p = t.tkohdr2.innerWidth()/1000;
                t.set_h(p);
            }
            var wait;
            clearTimeout(wait);
            wait = setTimeout(resizedw , 1000);
        });

        //hover funx
        $(function(){
           t.tkohdr2.delay(10000).animate({ height:0, bottom:0, marginTop:0},
            function(){
                t.tkohdr.mouseover(function(){
                    t.tkohdr2.stop().animate({ height: t.h2, bottom: t.h2, marginTop:0});
                });
                t.tkohdr.mouseout(function(){
                    t.tkohdr2.stop().animate({ height:0, bottom:0, marginTop:0});
                });
            });
        });
        // **** END PAGE TAKEOVER
        
        //****  START exp leaderboard banner 
        var $exp = $(document).find('.expldrbrd');
        $(function(){
            $exp.delay(10000).animate({ height:20, bottom:0}, function(){
                //show hide funx
                $exp.mouseover(function(){
                    $exp.stop().animate({ height:150, bottom:150});
                });
                $exp.mouseout(function(){
                    $exp.stop().animate({ height:18, bottom:0});
                });
            });
        });
        //***** END exp leaderboard
        
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
    var namespace = GcmazSite;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {

    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });

    UTIL.fire('common', 'finalize');
  }
};

$(document).ready(UTIL.loadEvents);
