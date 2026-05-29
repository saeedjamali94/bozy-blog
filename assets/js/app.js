
var $ = jQuery;
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}


$(document).ready(function (){

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



  /**
   * Homepage get latest posts from category tabs
   */
  $('.blog-categories .tab').click(function (){
    let cat_id = $(this).attr("data-id") ? $(this).attr("data-id") : 0;
    if( cat_id ){
      let block = $('.homeArticleNews');
      $.ajax({
        url: bozy_options.ajax_url,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'bzy_get_category_posts',
          nonce: bozy_options.nonce,
          category_id: cat_id
        },

        beforeSend: function () {
          block.addClass('loading');
        },

        success: function (response) {

          if (response.success) {
            const $carousel = $('.homeArticleNews');

            // Destroy old carousel if already initialized
            $carousel.trigger('destroy.owl.carousel');

            // Clear old items
            $carousel.html('');

            // Add new items
            response.data.data.forEach(function (item) {

              let cat_html = ``;
              item.category.forEach(function ( $cat ){
                cat_html += `<span class="category_item">${$cat}</span>`;
              });

              $carousel.append(`
               <a class="post-card" href="${item.link}">
                  <figure>
                      <img src="${item.img}" class="attachment-medium size-medium wp-post-image" alt="${item.post_title}" decoding="async">
                  </figure>
                  <div class="post-card__box">
                      <div class="d-flex align-items-center flex-wrap gap-2">
                         ${cat_html}
                      </div>
                      <div class="bold fs-16 title mb-4">${item.post_title}</div>
                      <div>
                          <p class="d-flex align-items-center">
                              <img class="me-2" src="${bozy_options.theme_url}/assets/images/calendar.svg" alt="">
                              ${item.date}          
                          </p>
                      </div>
                  </div>
              </a>
            `);

          });

            // Re-init carousel
            $carousel.owlCarousel({
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
          } else {
            console.log('Request failed');
          }

        },

        error: function (xhr, status, error) {
          block.removeClass('loading');
        },

        complete: function () {
          block.removeClass('loading');
        }
      });
    }
  });

});


