(function ($) {
    "use strict";

/*--
    Menu Sticky
-----------------------------------*/
var windows = $(window);
var sticky = $('.header-sticky');

windows.on('scroll', function() {
    var scroll = windows.scrollTop();
    if (scroll < 300) {
        sticky.removeClass('is-sticky');
    }else{
        sticky.addClass('is-sticky');
    }
});

/*--
    Mobile Menu
------------------------*/
var mainMenuNav = $('.main-menu nav');
mainMenuNav.meanmenu({
    meanScreenWidth: '991',
    meanMenuContainer: '.mobile-menu',
    meanMenuClose: '<span class="menu-close"></span>',
    meanMenuOpen: '<span class="menu-bar"></span>',
    meanRevealPosition: 'right',
    meanMenuCloseSize: '0',
});

/*--
    Hero Slider
--------------------------------------------*/
var heroSlider = $('.hero-slider');
heroSlider.slick({
    arrows: true,
    autoplay: false,
    autoplaySpeed: 5000,
    dots: false,
    pauseOnFocus: false,
    pauseOnHover: false,
    fade: true,
    infinite: true,
    slidesToShow: 1,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
    responsive: [
        {
          breakpoint: 767,
          settings: {
            arrows: false,
          }
        },
        {
          breakpoint: 991,
          settings: {
            arrows: false,
          }
        }
    ]
});


/*--
    Testimonial Slider
--------------------------------------------*/
var testimonialSlider = $('.testimonial-slider')
testimonialSlider.slick({
    arrows: false,
    autoplay: true,
    autoplaySpeed: 5000,
    dots: true,
    pauseOnFocus: false,
    pauseOnHover: false,
    infinite: true,
    slidesToShow: 1,
    slidesToScoll: 1,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
});

/*--
    Timeline Process
--------------------------------------------*/
var timeLine = $('.timeline');
var timeLineProces = $('.timeline-proces');
timeLine.hover(function() {
        var timelinePosition = $(this).position().top;
        var timelineHeight = $(this).height();
        var totalHeight = timelinePosition + timelineHeight + 50;

        $(this).addClass('hover').prevAll().addClass('hover');
        timeLineProces.css( 'height', totalHeight +'px' );
    },
        function() {
        $(this).removeClass('hover').prevAll().removeClass('hover');
        timeLineProces.css( 'height', '0px' );
    });

/*--
	Isotop with ImagesLoaded
-----------------------------------*/
var isotopFilter = $('.isotop-filter');
var isotopGrid = $('.isotop-grid');
var isotopGridItem = '.isotop-item';

isotopFilter.find('button:first-child').addClass('active');

/*-- Images Loaded --*/
isotopGrid.imagesLoaded(function () {

    isotopGrid.isotope({
        itemSelector: isotopGridItem,
        layoutMode: 'masonry',
    });

    /*-- Isotop Filter Menu --*/
    isotopFilter.on('click', 'button', function () {

        var filterValue = $(this).attr('data-filter');

        isotopFilter.find('button').removeClass('active');
        $(this).addClass('active');
        isotopGrid.isotope({filter: filterValue});

    });

});

/*--
	Video Popup
-----------------------------------*/
var videoPopup = $('.video-popup');
videoPopup.magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false
});

/*--
	Image Popup
-----------------------------------*/
var imagePopup = $('.image-popup');
imagePopup.magnificPopup({
    type: 'image',
    mainClass: 'mfp-fade',
});

/*--
	Image Popup
-----------------------------------*/
var galleryPopup = $('.gallery-popup');
galleryPopup.magnificPopup({
    type: 'image',
    mainClass: 'mfp-fade',
    gallery: {
        enabled: true,
    },
});

/*--
	MailChimp
-----------------------------------*/
$('#mc-form').ajaxChimp({
	language: 'en',
	callback: mailChimpResponse,
	// ADD YOUR MAILCHIMP URL BELOW HERE!
	url: 'http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef'

});
function mailChimpResponse(resp) {

	if (resp.result === 'success') {
		$('.mailchimp-success').html('' + resp.msg).fadeIn(900);
		$('.mailchimp-error').fadeOut(400);

	} else if(resp.result === 'error') {
		$('.mailchimp-error').html('' + resp.msg).fadeIn(900);
	}
}

/*--
	Instagram Feed
-----------------------------------*/
if($('#instagram-feed').length) {
    var feed = new Instafeed({
        get: 'user',
        userId: 6665768655,
        accessToken: '6665768655.1677ed0.313e6c96807c45d8900b4f680650dee5',
        target: 'instagram-feed',
        resolution: 'thumbnail',
        limit: 8,
        template: '<li><a href="{{link}}" target="_new"><img src="{{image}}" /> <span class="like"><i class="fa fa-heart-o"></i>{{likes}}</span></a></li>',
    });
    feed.run();
}

/*--
    Scroll Up
-----------------------------------*/
$.scrollUp({
    easingType: 'linear',
    scrollSpeed: 900,
    animation: 'fade',
    scrollText: '<i class="fa fa-angle-up"></i>',
});

/* Lightgallery Activations */
// Video Area video popup
$('.video-area-inner').lightGallery({
	selector: '.video-popup-trigger'
});

/* CounterUp Active */
	$('.counter-active').counterUp({
		delay: 10,
		time: 1000
	});

/* VMap Active JS */
if($('#world-vmap').length){
	function escapeXml(string) {
        return string.replace(/[<>]/g, function (c) {
            switch (c) {
                case '<': return '\u003c';
                case '>': return '\u003e';
            }
        });
    }
    jQuery(document).ready(function () {
        var pins = {
            jp: escapeXml('<div class="vmap-pin-text"><p>GOO.N JAPAN</p></div><span class="vmap-pin"></span>'),
            cn: escapeXml('<div class="vmap-pin-text"><p>GOO.N CHINA</p></div><span class="vmap-pin"></span>'),
            th: escapeXml('<div class="vmap-pin-text"><p>GOO.N THAILANG</p></div><span class="vmap-pin"></span>'),
            kr: escapeXml('<div class="vmap-pin-text"><p>GOO.N KOREA</p></div><span class="vmap-pin"></span>'),
            id: escapeXml('<div class="vmap-pin-text"><p>GOO.N INDONESIA</p></div><span class="vmap-pin"></span>'),
            tw: escapeXml('<div class="vmap-pin-text"><p>GOO.N TAIWAN</p></div><span class="vmap-pin"></span>'),
            vn: escapeXml('<div class="vmap-pin-text"><p>GOO.N VIETNAM</p></div><span class="vmap-pin"></span>'),
            my: escapeXml('<div class="vmap-pin-text"><p>GOO.N MALAYSIA</p></div><span class="vmap-pin"></span>'),
            la: escapeXml('<div class="vmap-pin-text"><p>GOO.N LAOS</p></div><span class="vmap-pin"></span>'),
            mm: escapeXml('<div class="vmap-pin-text"><p>GOO.N MYANMAR</p></div><span class="vmap-pin"></span>'),
            kh: escapeXml('<div class="vmap-pin-text"><p>GOO.N CAMBODIA</p></div><span class="vmap-pin"></span>'),
            ph: escapeXml('<div class="vmap-pin-text"><p>GOO.N PHILIPPINES</p></div><span class="vmap-pin"></span>'),
            tr: escapeXml('<div class="vmap-pin-text"><p>GOO.N TURKEY</p></div><span class="vmap-pin"></span>'),
            ru: escapeXml('<div class="vmap-pin-text"><p>GOO.N RUSSIA</p></div><span class="vmap-pin"></span>'),

        };


        jQuery('#world-vmap').vectorMap({
            backgroundColor: 'transparent',
            borderColor: '#6f89a2',
            map: 'world_en',
            pins: pins,
            color: '#6f89a2',
            enableZoom: false,
            pinMode: 'content',
            selectedColor: '#6f89a2',
            hoverColor: '#2b81c2',
            showTooltip: true,
            selectedRegions: ['JP', 'CN','TH', 'KR', 'ID','TW','VN','MY','LA','MM','KH','PH','TR','RU'],
            onRegionClick: function(element, code, region)
            {
                console.log(code);
                var message = '<h4>'
                    + region
                    + ' Office</h4> <p></p> '
                    var $this = $(this).find('div[for='+ code +']').find('.vmap-pin-text');
                    if ($this.hasClass('open')) {
                        $this.removeClass('open').find('h4').remove();
                    } else {
                        $this.addClass('open').prepend(message);
                    }
            }
        });
    });
};

})(jQuery);
