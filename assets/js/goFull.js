(function($) {
    $.fn.extend({
        goFull: function(options) {
            var items = this;
            options = $.extend( {}, $.goFull.defaults, options );
            this.each(function() {
                var item = $(this);
                new $.goFull($(this),options);
                $.goFull.windowWidth = $(window).width();
                $(window).resize(function(){
                    if($(this).width() !== $.goFull.windowWidth)
                    {
                        $.goFull.windowWidth = $(this).width();
                        $.goFull($(item),options);
                    }
                });
            });
            return this;
        }
    });

    // item is the element, options is the set of defaults + user options
    $.goFull = function( item, options ) {
        $(item).height($(window).height()-options.navBarHeight);
        $(item).prop('tabindex','0');
        //Center Image
        var bg = $(item).find(options.bgClass);
        $.goFull.centerItem(bg);
        $(bg).load(function(){
            $.goFull.centerItem(this);
        });
        //Center the Logo
        $(item).find(options.logoClass).each(function(idx,elem){
            $(elem).load(function(){
                /*
                 Adding a loading event is necessary because the image might not be
                 loaded by the time the script runs.
                 */
                $.goFull.makeLogo(item,this,options);
            });
            $.goFull.makeLogo(item,elem,options);
        });
        //Set button
        var btn = $(item).find(options.btnClass);
        $.goFull.centerItem(btn);
        //Set button at the bot.
        $(btn).css({
            top: $(item).height() - $(btn).height() - options.btnMargin
        });

        //Check if transit JS is active:
        if(jQuery().transit){
            $(btn).hover(function(){
                $(this)
                    .transition({y:-4})
                    .transition({y:4})
                    .transition({y:-2})
                    .transition({y:2});
            },function(){});
        }

        $(btn).click(function(){
            $('html,body').animate({
              scrollTop : Math.round(Math.min($(item).height(),$(item).height() + options.navBarHeight -$('body').offset().top))
            })
        });

        if($.goFull.isFunction(options.done))
            options.done();
    };

    // option defaults
    $.goFull.defaults = {
        logoClass : ".goFull-logo",
        bgClass : ".goFull-bg",
        captionClass : '.goFull-caption',
        btnClass : ".goFull-button",
        logoBg : true,
        logoBgPadding : 50,
        navBarHeight : 0, //By default this assumes navbar won't be on screen.
        captionTopOffset : 0,
        captionLeftOffset : 0,
        btnMargin: 0,
        fixResize: true,
        done: undefined
    };

    $.goFull.makeLogo = function(gfContent,logo,options){
        $.goFull.centerItem(logo);
        //Add BG
        if(options.logoBg){
            $.goFull.createLogoBg(gfContent,options);
        }
        //Add captions
        var captions  = $(gfContent).find(options.captionClass);
        $(captions).css("width",$(gfContent).width());
        $.goFull.centerItem(
            $(gfContent).find(options.captionClass),
            (options.logoBg ? $(gfContent).find('.goFull-logoBG').height()/2 : $(gfContent).find(options.logoClass).height()/2)
            + options.captionTopOffset,
            options.captionLeftOffset
        );

    };


    //THANKS TO ALEX GRANDE FROM STACKOVERFLOW FOR THIS.
    $.goFull.isFunction = function(object) {
        return object && typeof object === 'function';
    };

    $.goFull.centerItem = function(item,heightOffset,widthOffset){
        //Default values :
        heightOffset = typeof heightOffset !== 'undefined' ? heightOffset : 0;
        widthOffset = typeof widthOffset !== 'undefined' ? widthOffset : 0;

        $(item).css({
            position: "absolute",
            left: $(item).parent().width() /2 - $(item).width()/2 + widthOffset,
            top: $(item).parent().height() /2 - $(item).height()/2 + heightOffset
        });
    };

    $.goFull.windowWidth = 0;

    $.goFull.createLogoBg = function(gfContent,options){ //gfContent = goFull Content
        $(gfContent).find(".goFull-logoBG").remove(); //Delete all previous created BG.
        var bg = $('<div></div>').addClass("goFull-logoBG").css({
            width: $(gfContent).width(),
            height: $(gfContent).find(options.logoClass).height() + options.logoBgPadding*2,
            position : "absolute",
            left: 0,
            top: parseInt($(gfContent).find(options.logoClass).css('top'))-options.logoBgPadding
        });
       // alert($(gfContent).find(options.logoClass).height());
        $(gfContent).find(options.logoClass).before(bg);
    }

})(jQuery);
