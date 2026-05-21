
var $ = jQuery;
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}


$(document).ready(function (){

  /**
   * Homepage WhyUs section carousel for mobile
   */
  if ($('.homeArticleNews').length) {
    $('.homeArticleNews').owlCarousel({
      loop: false,
      margin: 10,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      items: 2,
      navText: [`<svg class="icon"><use xlink:href="${bozy_options.sprite_url}#arrow"></use></svg>`, `<svg class="icon"><use xlink:href="${bozy_options.sprite_url}#arrow"></use></svg>`]
    });
  }


  // mobile menu action
  $(".menuBtn , .menuClose").click(function (){
    $(".mobileNav").toggleClass("open");
  });

  //tabs action
  $('body').delegate(".tabs .tab" , "click" , function (){
    let _this = $(this);
    $(_this).parents(".tabs").children(".tab").removeClass("active");
    _this.addClass("active");
  });

  // footer nav toggle open/close
  $(".footerNavToggle").click(function (){
    let id = $(this).attr("data-nav");
    $(".nav[data-nav="+id+"]").toggleClass("open");
  });

});


