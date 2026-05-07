"use strict";

jQuery(document).ready(function ($) {
    /**---------------------------------------------*
     Mobile menu
     ---------------------------------------------
    $('.get_cate').find('a[href*=#]:not([href=#])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: (target.offset().top - 40)
                }, 1000);
                
                if ($('.navbar-toggle').css('display') != 'none') {
                    $(this).parents('.container').find(".navbar-toggle").trigger("click");
                }
                
               
                return false;
            }
        }
    });
   
    $('body').scrollspy({
        target: '.get_cate1',
        offset: 200
    }); 


    $('body').scrollspy({
        target: '.get_cate',
        offset: 200
    });
**/
    /*---------------------------------------------*
     * STICKY scroll
     ---------------------------------------------*/

    //$.localScroll();
    // $('.post1').localScroll();
    $(".get_cate").localScroll({
        duration: 800,
        offset: -180,
    });
    //console.log('clicked');
    $("#hscroll").localScroll({
        duration: 800,
        offset: -240,
    });

    /*---------------------------------------------*
     * WOW
     ---------------------------------------------*/

    var wow = new WOW({
        mobile: false, // trigger animations on mobile devices (default is true)
    });
    wow.init();

    // main-menu-scroll
    /**
    jQuery(window).scroll(function () {
        var top = jQuery(document).scrollTop();
        var height = 300;
        //alert(batas);

        if (top > height) {
            jQuery('.navbar-fixed-top').addClass('menu-scroll');
        } else {
            jQuery('.navbar-fixed-top').removeClass('menu-scroll');
        }
    });
**/
    // scroll Up

    $(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $(".scrollup").fadeIn("slow");
        } else {
            $(".scrollup").fadeOut("slow");
        }
        if (
            $(this).innerHeight() + $(this).scrollTop() + 30 >=
            $("body").height() - $("footer").height()
        ) {
            var delta =
                180 -
                ($(this).innerHeight() +
                    $(this).scrollTop() -
                    ($("body").height() - $("footer").height()) +
                    25);
            var deltaPx = delta + "px";
            $(".fix").css({ top: deltaPx });
        } else {
            $(".fix").css({ top: "180px" });
        }
        /**
        if($(this).scrollTop()> 400){
         
            console.log($(this).scrollTop());
            $('.post1').addClass('fix');
        }else{
            $('.post1').removeClass('fix');
        }
        **/
    });
    $(".scrollup").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });

    //    $('#menu').slicknav();

    $("#mixcontent").mixItUp({
        animation: {
            animateResizeContainer: false,
            effects: "fade rotateX(-45deg) translateY(-10%)",
        },
    });

    $(".dropdown-menu").click(function (e) {
        e.stopPropagation();
    });

    $(window).scroll(function () {
        var scrollTop = $(document).scrollTop();
        var current_href = $(".get_cate").find(".active").attr("href");
        var current_href2 = $("#hscroll div").find(".active").attr("href");
        var contentItems = $("#service #get_products").find(".get_product");

        var currentItem = "";
        contentItems.each(function (e) {
            var contentItem = $(this);
            var offsetTop = contentItem.offset().top;

            if (scrollTop > offsetTop - 400) {
                currentItem = "#" + contentItem.attr("id");
            }
        });
        var currItem_href = currentItem;

        if (currItem_href !== current_href) {
            $(".get_cate").find(".active").removeClass("active");
            $(".get_cate")
                .find('[href="' + currItem_href + '"]')
                .addClass("active");
            $("#hscroll div").find(".active").removeClass("active");
            $("#hscroll div")
                .find('[href="' + currItem_href + '"]')
                .addClass("active");
        }
        if (currItem_href !== current_href2) {
            $("#hscroll div").find(".active").removeClass("active");
            $("#hscroll div")
                .find('[href="' + currItem_href + '"]')
                .addClass("active");
            $(".get_cate").find(".active").removeClass("active");
            $(".get_cate")
                .find('[href="' + currItem_href + '"]')
                .addClass("active");
        }
    });

    $("#sc").on("click", function () {
        $("#sidebar").addClass("active");
        $(".overlay").fadeIn();
        $(".collapse.in").toggleClass("in");
        $("a[aria-expanded=true]").attr("aria-expanded", "false");
    });

    $("#cart").on("click", function () {
        var self = $(this);
        var bid = self.attr("bid");
        $("#sidebar2").addClass("active");
        $(".overlay").fadeIn();
        $(".collapse.in").toggleClass("in");
        $("a[aria-expanded=true]").attr("aria-expanded", "false");
    });
    $(".shopCart .content #cart").on("click", function () {
        var self = $(this);
        var bid = self.attr("bid");
        $("#sidebar2").addClass("active");
        $(".overlay").fadeIn();
        $(".collapse.in").toggleClass("in");
        $("a[aria-expanded=true]").attr("aria-expanded", "false");
    });
    $("#sct2").on("click", function () {
        $("#sidebar_left").addClass("active");
        $(".overlay").fadeIn();
        $(".collapse.in").toggleClass("in");
        $("a[aria-expanded=true]").attr("aria-expanded", "false");
    });

    $("#dismiss, .overlay").on("click", function () {
        $("#sidebar").removeClass("active");
        $(".overlay").fadeOut();
    });

    $("#dismiss2, .overlay").on("click", function () {
        $("#sidebar2").removeClass("active");
        $(".overlay").fadeOut();
        /**
                    $.get("updateBtnCart.php", function(data) {
                        
                        $("#totaal2").html(data);
                        $(".shopCart .content #totaal1").html(data);
                    });
                    **/
    });
    $("#dismiss_left, .overlay").on("click", function () {
        $("#sidebar_left").removeClass("active");
        $(".overlay").fadeOut();
    });

    /**
                $('#get_product #detail').on('click', function () {
                    
                     var self = $(this);
                      var pid = self.attr('pid');
                       $.post("detail.php",{pid: pid},function(data){
                           
                           $('#detail_modal').html(data);
                           $('#detail_modal').modal('show');
                           
                       }); 
 
                 });
                 **/

    //End
});

/**

$(document).on("scroll", function () {
    if ($(document).scrollTop() > 120) {
        $("nav").addClass("small");
    } else {
        $("nav").removeClass("small");
    }
});
**/

/**
$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') ) {
        $(this).collapse('hide');
    }
});

**/
