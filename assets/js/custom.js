/**
 * Theme: Flatrok
 * Version: 1.0.0
 * Author: Chris Brame <polonel@gmail.com>
 *
 * File Description:
 * Custom javascript file used through the Flatrok theme.
 * Some areas of this custom script file should NOT be
 * modified.
 */

/**
 * Global variables
 */

var viewPortWidth,
    viewPortHeight,
    navOffsetTop;

// Main jquery entry point
$(document).ready(function () {
    viewPortWidth = $(window).width();
    viewPortHeight = $(window).height();
    navOffsetTop = $('.nav-wrapper').offset().top;

    //Load up functions
    navigationSetup();
    profileSetup();
    portfolioSetup();
    gMapSetup();
    footerSetup();
    animationSetup();
    conatctFormSetup();

    navigateStickyResponsive();

    // Check for navigation sticky
    $(window).scroll(function () {
        navigateStickyResponsive();
    });

    $(window).resize(function () {
        viewPortWidth = $(window).width();
        viewPortHeight = $(window).height();
        //Bind to window resize for fixed nav-bar resizing
        navigateStickyResponsive();
    });
});


/**
 * Methods -----------------------------------------------
 *
 */

function navigationSetup() {
    //Navigation Circle Scroll-up effect
    $('.nav-item > a').hover(function () {
        if ($(this).parent('.nav-item').hasClass('.small-scale'))
            return false;
        var ovalHeight = $(this).children('.oval').height();
        var fontSize = parseInt($(this).find('span').css('line-height').replace('px', ''));
        var finalHeight = ((ovalHeight - fontSize) / 2) - 6;
        $(this).children('.oval').children('i').stop().animate({'top': '-100px'}, 350);
        $(this).children('.oval').children('span').stop().animate({'top': finalHeight + 'px'}, 350);
    }, function () {
        $(this).children('.oval').children('span').stop().animate({'top': '100px'}, 350);
        $(this).children('.oval').children('i').stop().animate({'top': 15 + 'px'}, 350);
    });

    //Create the link text for sticky mode
    $('.nav-bar li').each(function () {
        $(this).find('.nav-link-small').remove();

        var aLink = $(this).find('a').clone();
        aLink.empty();
        aLink.append($(this).find('.oval > span').clone());
        aLink.addClass('nav-link-small');
        aLink.children('span').css({'position': 'relative', 'top': 0, 'margin-top': '-8px', 'margin-left': '-15px', 'display': ' none'});
        aLink.css({'display': 'none'}).children('span').css({'display': 'none'});

        $(this).append(aLink);
    });

    //Set links to smoothScroll
    $('a').smoothScroll();

    //Make the entire List-Item clickable when in sticky mode.
    $('.nav-bar li').click(function () {
        var href = $(this).find('a[href*=#]').attr('href');
        if ($(this).hasClass('small-scale')) {
            $.smoothScroll({
                scrollTarget: href,
                speed: 1200
            });
        }
    }).hover(function () {
            $(this).stop();
            if ($(this).hasClass('small-scale')) {
                $(this).animate({'height': 60 }, 200);
            }

        }, function () {
            if ($(this).hasClass('small-scale')) {
                $(this).animate({'height': 45 }, 200);
            }
        });
}

function navigateStickyResponsive() {
    var scrollTop = $(window).scrollTop();
    var navbar = $('.nav-bar');
    var width = $('.page-body').outerWidth() / 2;

    if (viewPortWidth <= 320 || viewPortWidth <= 360) {
        navbar.addClass('small-scale lock-top');
        navbar.find('li.nav-item').addClass('small-scale');
        navbar.css({'left': '50%', 'margin-left': '-' + width + 'px'});
        return false;
    }

    navbar.removeClass('lock-top');
    if (scrollTop > navOffsetTop) {
        $('.page-head').css({'min-height': '400px', 'margin-bottom': 0});
        navbar.addClass('small-scale');
        navbar.find('li').each(function () {

            $(this).addClass('small-scale');
            $(this).children('a').css({'display': 'none'});
            $(this).find('.nav-link-small').css({'display': 'block'}).children('span').css({'display': 'block'});

            $('.nav-target').css({'margin-top': '-' + (navbar.height() + 20) + 'px', 'padding-top': (navbar.height() + 20) + 'px'});
        });

        navbar.css({'left': '50%', 'margin-left': '-' + width + 'px'});
        navbar.addClass('lock-top');


    } else {
        var pageHead = $('.page-head');
        if (viewPortWidth <= 480) {
            pageHead.css({'min-height': '400px', 'margin-bottom': '50px'});
        } else {
            pageHead.css({'min-height': '450px', 'margin-bottom': '50px'});
        }

        navbar.removeClass('small-scale');
        $('.nav-bar .small-scale').removeClass('small-scale');
        navbar.removeClass('lock-top');
        navbar.find('li').each(function () {
            $(this).css({'cssText': ''});
        });

        $('.nav-bar a').fadeIn(200);
        $('.nav-link-small').css({'display': 'none'}).children('span').css({'display': 'none'});

        $('.nav-target').css({'margin-top': '-' + (navbar.height() + 65) + 'px', 'padding-top': (navbar.height() + 65) + 'px'});

        navbar.css({position: 'static', 'margin-top': '50px', 'margin-left': 0});
    }
}

function conatctFormSetup() {
    $("#contact-form").submit(function() {
        $.ajax({
            type: 'POST',
            url: 'php/postaction.php',
            data: $(this).serialize(),
            success: function(msg) {
                if (msg == 'SUCCESS') {
                    var response = '<div class="alert alert-success">Thank you! Your message was sent.</div>';
                    document.getElementById("contact-form").reset();
                }
                else {
                    var response = '<div class="alert alert-danger">' + msg + '</div>';
                }

                $("#contact-form > div.alert").remove();
                $("#contact-form").prepend(response);
            },

            error: function(msg) {
                var response = '<div class="alert alert-danger">' + msg + '</div>';
                $("#contact-form > div.alert").remove();
                $("#contact-form").prepend(response);
            }
        })

        return false;
    });

    ie8Placeholder();
}

function profileSetup() {
    // Create Bubble Progress bars based on data-fill-level attribute
    $(".progress-bubbles").each(function () {
        var fillLevel = parseInt($(this).data('fill-level'));

        for (var i = 0; i < fillLevel; i++) {
            var bubbleProgress = $(document.createElement('li'));
            bubbleProgress.addClass('filled');
            $(this).append(bubbleProgress);
        }

        var emptyCount = 10 - fillLevel;
        for (var j = 0; j < emptyCount; j++) {
            var bubbleProgress = $(document.createElement('li'));
            bubbleProgress.addClass('empty');
            $(this).append(bubbleProgress);
        }
    }); //<<End Bubble Setup>>
}

function portfolioSetup() {
    //Create the overlay for portfolio images
    $('.portfolio-item a').hover(function () {
        $(this).css({'cursor': 'pointer'});
        var theDiv = $('<div class="portfolio-item-hover"></div>');
        var hoverBox = $('<div class="portfolio-hover-box"><i class="fa fa-search"></i></div>');


        var imgWidth = $(this).parent('li').width();
        var imgHeight = $(this).parent('li').height();
        theDiv.css({
            'top': 0,
            'left': 0,
            'position': 'absolute',
            background: '#000000',
            opacity: 0,
            zIndex: 1000,
            'width': imgWidth,
            'height': imgHeight
        });

        hoverBox.css({
            'width': '55px',
            'height': '55px',
            'padding': '8px 16px',
            //'background': '#634AE2',
            'border-radius': '3px',
            '-moz-border-radius': '3px',
            '-webkit-border-radius': '3px',
            'font-size': '28px',
            'color': '#FFFFFF',
            zIndex: 1001,
            position: 'absolute',
            'top': (imgHeight - 55) / 2,
            'left': (imgWidth - 55) / 2
        });

        $(this).append(theDiv);
        $(this).append(hoverBox);
        theDiv.animate({opacity: 0.6}, 500);

    }, function () {
        $(this).children('.portfolio-item-hover').fadeOut(400, function () {
            $(this).remove();
        });
        $(this).children('.portfolio-hover-box').fadeOut(400, function () {
            $(this).remove();
        });
    });

    //PORTFOLIO FANCYBOX
    $('.popbox').fancybox({
        openEffect: 'fade',
        closeEffect: 'fade'
    }); // <<Portfolio Fancybox>>

    //HOVER FOR PORTFOLIO
    $('.portfolio-menu li').hover(function () {
        $(this).addClass('hover');
    },function () {
        $(this).removeClass('hover');
    }).click(function () {
            $('.portfolio-menu .active').removeClass('active');
            $(this).addClass('active');

            handlePortfolioSelect($(this).find('a'));
        });

    $('.portfolio-menu a').click(function () {
        $('.portfolio-menu .active').removeClass('active');
        $(this).parent('li').addClass('active');

        handlePortfolioSelect($(this));
        return false;
    });//<<Hover for Portfolio>>

}

function handlePortfolioSelect(value) {
    var dataItem = value.data('filter');
    var pContainer = $('#portfolio-container');
    pContainer.isotope({
        filter: dataItem,
        animationOptions: {
            duration: 600,
            easing: 'swing',
            queue: false
        }
    })
}

function gMapSetup() {
    var address = $('.contact-address > p').text();

    $('#gMap').gMap({
        address: address,
        zoom: 16,
        markers: [
            { 'address': address}
        ]
    });
}

function animationSetup() {
    //Hide for animations
    $('.timeline-item').css({opacity: 0});

    $('.experience-item .progress-bar').waypoint(function () {
        if ($(this).hasClass('animated'))
            return;

        var value = $(this).data('value');
        $(this).animate({'width': value + '%'}, 400);
        $(this).addClass('animated');
    }, {
        offset: '98%'
    });

    $('.tag-area').waypoint(function () {
        $(this).children('li').each(function (id) {
            var stall = 100 * parseInt(id);
            $(this).delay(stall).animate({opacity: 1});
        });
    }, {offset: '100%'});

    $('.skill-item > ul').waypoint(function () {
        $(this).children('li.filled').each(function (id) {
            var stall = 75 * parseInt(id);
            $(this).delay(stall).addClass('filled-bg', 1);
        });
    }, {offset: '100%'});

    $('.timeline-item').waypoint(function() {
        $(this).animate({opacity: 1});
    }, {offset: '100%'});
}

function footerSetup() {
    var socialClone = $('.social-links').clone();
    socialClone.removeClass('hidden-xs container').addClass('social-footer');
    $('.footer > p').append(socialClone);
}

function ie8Placeholder() {
    $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur().parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
}

$(window).load(function() {
    //Initially load active portfolio filters.
    handlePortfolioSelect($('.portfolio-menu .active a'));
});
