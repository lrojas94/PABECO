/**
 * Created by Luis on 5/16/2015.
 */
var page = $("html, body");

$(function(){
    Pace.on('hide',function(){
        //ON DOCUMENT READY:
        paceDone();
    });
});



function paceDone(){
    //Site loaded using PACE
    $('#content').show();
    $('#content').ready(function(){
    });
    $('#productos-imgs').slick({
        autoplay: true,
        speed: 400,
        autoplaySpeed: 1500,
        infinite: true,
        mobileFirst: true,
        dots: false,
        lazyLoad: 'ondemand'
    });
    $('.goFull').goFull({
        logoBgPadding: 15,
        captionTopOffset : 15,
        btnMargin: 10,
        navBarHeight: 75
    });

    $('#sendMail').click(function(e){
        e.preventDefault();
        var data = new FormData($('form')[0]);
        $.ajax({
            type: "POST",
            url : baseURL + "/main/mail",
            data: data,
            dataType: 'json',
            success : function(data) {
                console.log(data)
            },
            cache: false,
            contentType: false,
            processData: false

        })
    });

    /*
    TODO:
    - FIX/MAKE centerImage Plugin. The one used is simply not working.
    as a temp fix, $.centerItem (Which is supposed to be private) is doing the job.
     */

    $('.centered-bg').centerImage();
    $('.centered-bg-fit').centerImage({
        fitContainer: true
    });
    //$.centerItem($('.centered-bg').first());
    page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
        page.stop();
    });


}