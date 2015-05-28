(function($) {
    $.fn.extend({
        centerImage: function(options) {
            var items = this;
            options = $.extend( {}, $.centerImage.defaults, options );
            this.each(function() {
                var item = $(this);
                new $.centerImage($(this),options);
                $.centerImage.windowWidth = $(window).width();
                $(window).resize(function(){
                    if($(this).width() !== $.windowWidth)
                    {
                        $.centerImage.windowWidth = $(this).width();
                        $.centerImage($(item),options);
                    }
                });
            });
            return this;
        }
    });

    // item is the element, options is the set of defaults + user options
    $.centerImage = function( item, options ) {

        var parent = $(item).parent();
        $(parent).css({
            position:$(parent).css('position') == 'absolute' ? 'absolute' : 'relative',
            overflow: 'hidden'
        });

        if(options.fitContainer){
            //Make sure tot fit :(
            $(item).css(
           /*IF*/     $(item).width() > $(item).height() ?
                {
                    height: Math.max($(parent).height(),$(parent).width()),
                    width: 'auto'
                }
                    : //Else
                {
                    width: Math.max($(parent).height(),$(parent).width()),
                    height: 'auto'
                }
            )
        }
        //Make sure to at least fit container.
        if(options.minFit){
            $(item).css({
                minWidth: Math.round($(parent).outerWidth())+2,
                minHeight: Math.round($(parent).outerHeight())+2
            });
        }

        $(item).css({
            position: "absolute",
            left: Math.round($(parent).outerWidth() / 2) - Math.round($(item).outerWidth() / 2),
            top: Math.round($(parent).outerHeight() /2) - Math.round($(item).outerHeight()/2)
        });
    };

    // option defaults
    $.centerImage.defaults = {
        fitContainer: false,
        minFit: true
    };

    $.centerImage.windowWidth = 0;


    //THANKS TO ALEX GRANDE FROM STACKOVERFLOW FOR THIS.
    $.centerImage.isFunction = function(object) {
        return object && typeof object === 'function';
    };


})(jQuery);/**
 * Created by Luis on 5/25/2015.
 */
