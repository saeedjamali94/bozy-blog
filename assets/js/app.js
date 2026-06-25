
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
      navText: ['<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>', '<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>']
    });
  }


  /**
   * Blog categories featured posts carousel
   */
  if ($('.featuredCarousel').length) {
    $('.featuredCarousel').owlCarousel({
      loop: false,
      margin: 20,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      items: 2,
      navText: ['<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>', '<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>']
    });
  }



  /**
   * Homepage get latest posts from category tabs
   */
  $('.blog-categories .tab').click(function (){
    let cat_id = $(this).attr("data-id") ? $(this).attr("data-id") : 0;
    if( cat_id ){
      let $featured = $('.blog-categories .featuredCarousel');
      let $postList = $('.blog-categories .post-list');
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
          $featured.addClass('loading');
          $postList.addClass('loading');
        },

        success: function (response) {

          if (response.success) {
            var posts = response.data.data;

            // Render featured posts carousel (first 2)
            var $featuredCarousel = $('.blog-categories .featuredCarousel');
            $featuredCarousel.trigger('destroy.owl.carousel');
            $featuredCarousel.html('');
            var featuredCount = Math.min(4, posts.length);
            for (var f = 0; f < featuredCount; f++) {
              var featured = posts[f];
              var cat_html = '';
              featured.category.forEach(function ($cat) {
                cat_html += '<span class="category_item">' + $cat + '</span>';
              });
              $featuredCarousel.append(
                '<div class="item">' +
                  '<a class="post-card" href="' + featured.link + '">' +
                    '<figure>' +
                      '<img src="' + featured.img + '" class="attachment-medium size-medium wp-post-image" alt="' + featured.post_title + '" decoding="async">' +
                    '</figure>' +
                    '<div class="post-card__box">' +
                      '<div class="d-flex align-items-center flex-wrap gap-2">' +
                        cat_html +
                      '</div>' +
                      '<div class="bold fs-16 title mb-4">' + featured.post_title + '</div>' +
                      '<div>' +
                        '<p class="d-flex align-items-center">' +
                          '<img class="me-2" src="' + bozy_options.theme_url + '/assets/images/calendar.svg" alt="">' +
                          featured.date +
                        '</p>' +
                      '</div>' +
                    '</div>' +
                  '</a>' +
                '</div>'
              );
            }
            // Reinitialize featured carousel
            $featuredCarousel.owlCarousel({
              loop: false,
              margin: 20,
              autoplay: true,
              autoplayTimeout: 4000,
              autoplayHoverPause: true,
              nav: true,
              dots: false,
              items: 2,
              navText: ['<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>', '<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>']
            });

            // Render remaining posts as horizontal rows
            $postList.html('');
            for (var i = 4; i < posts.length; i++) {
              var item = posts[i];
              $postList.append(
                '<a class="post-row" href="' + item.link + '">' +
                  '<figure class="post-row__image">' +
                    '<img src="' + (item.thumb || item.img) + '" alt="' + item.post_title + '">' +
                  '</figure>' +
                  '<div class="post-row__content">' +
                    '<h3 class="post-row__title bold fs-16">' + item.post_title + '</h3>' +
                    '<div class="post-row__meta">' +
                      '<span class="post-row__date">' +
                        '<svg class="icon me-1" width="16" height="16"><use xlink:href="' + bozy_options.sprite_url + '#calendar"></use></svg>' +
                        item.date +
                      '</span>' +
                      '<span class="post-row__reading-time">' +
                        '<svg class="icon me-1" width="16" height="16"><use xlink:href="' + bozy_options.sprite_url + '#clock"></use></svg>' +
                        item.reading_time + ' min read' +
                      '</span>' +
                    '</div>' +
                  '</div>' +
                '</a>'
              );
            }
          } else {
            console.log('Request failed');
          }

        },

        error: function (xhr, status, error) {
          $featured.removeClass('loading');
          $postList.removeClass('loading');
        },

        complete: function () {
          $featured.removeClass('loading');
          $postList.removeClass('loading');
        }
      });
    }
  });


  /**
   * Latest Videos carousel
   */
  if ($('.latestVideosCarousel').length) {
    $('.latestVideosCarousel').owlCarousel({
      loop: false,
      margin: 10,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      items: 2.3,
      navText: ['<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>', '<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>']
    });
  }


  /**
   * Trendy Posts carousel
   */
  if ($('.trendyPostsCarousel').length) {
    $('.trendyPostsCarousel').owlCarousel({
      loop: false,
      margin: 10,
      autoplay: true,
      autoplayTimeout: 3500,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1024: {
          items: 3
        },
        1200: {
          items: 4
        }
      },
      navText: ['<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>', '<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>']
    });
  }


  /**
   * Recommended Articles carousel (single blog page)
   */
  if ($('.recommendedCarousel').length) {
    $('.recommendedCarousel').owlCarousel({
      loop: false,
      margin: 10,
      autoplay: true,
      autoplayTimeout: 3500,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1024: {
          items: 3
        },
        1200: {
          items: 4
        }
      },
      navText: ['<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>', '<svg class="icon"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>']
    });
  }


  /**
   * Copy link button
   */
  $('body').delegate('.copy-link-btn', 'click', function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    var $btn = $(this);
    var $text = $btn.find('.copy-link-text');
    if (navigator.clipboard) {
      navigator.clipboard.writeText(url).then(function () {
        $text.text('Copied!');
        setTimeout(function () { $text.text('Copy Link'); }, 2000);
      });
    } else {
      // Fallback
      var temp = $('<input>');
      $('body').append(temp);
      temp.val(url).select();
      document.execCommand('copy');
      temp.remove();
      $text.text('Copied!');
      setTimeout(function () { $text.text('Copy Link'); }, 2000);
    }
  });


  /**
   * Archive page load more
   */
  $('#loadMoreBtn').click(function () {
    var $btn = $(this);
    var page = parseInt($btn.data('page')) || 1;
    var perPage = parseInt($btn.data('per-page')) || 16;
    var catId = parseInt($btn.data('category')) || 0;
    var tagId = parseInt($btn.data('tag')) || 0;
    var search = $btn.data('search') || '';
    var max = parseInt($btn.data('max')) || 999;
    var nextPage = page + 1;

    $btn.addClass('loading').prop('disabled', true).text('Loading...');

    $.ajax({
      url: bozy_options.ajax_url,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'bzy_load_more',
        nonce: bozy_options.nonce,
        page: nextPage,
        per_page: perPage,
        category_id: catId,
        tag_id: tagId,
        search: search
      },
      success: function (response) {
        if (response.success) {
          var posts = response.data.posts;
          if (posts.length > 0) {
            posts.forEach(function (item) {
              var catHtml = '';
              item.category.forEach(function (c) {
                catHtml += '<span class="category_item">' + c + '</span>';
              });

              var card = '<div class="col archive-grid__item">' +
                '<a class="post-card-simple" href="' + item.link + '">' +
                  '<figure class="post-card-simple__image">' +
                    '<img src="' + (item.thumb || item.img) + '" alt="' + item.post_title + '">' +
                  '</figure>' +
                  '<div class="post-card-simple__body">' +
                    '<h3 class="post-card-simple__title bold fs-16">' + item.post_title + '</h3>' +
                    '<div class="post-card-simple__meta">' +
                      '<span class="post-card-simple__date">' +
                        '<svg class="icon me-1" width="14" height="14"><use xlink:href="' + bozy_options.sprite_url + '#calendar"></use></svg>' +
                        item.date +
                      '</span>' +
                      '<span class="post-card-simple__divider"></span>' +
                      '<span class="post-card-simple__reading-time">' +
                        '<svg class="icon me-1" width="14" height="14"><use xlink:href="' + bozy_options.sprite_url + '#clock"></use></svg>' +
                        item.reading_time + ' min read' +
                      '</span>' +
                    '</div>' +
                    '<span class="post-card-simple__btn">' +
                      'Read More' +
                      '<svg class="icon ms-1" width="14" height="14"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>' +
                    '</span>' +
                  '</div>' +
                '</a>' +
              '</div>';

              $('#archiveGrid').append(card);
            });

            $btn.data('page', nextPage);

            if (!response.data.has_more || nextPage >= max) {
              $('#loadMoreWrap').fadeOut();
            }
          }
        }
      },
      error: function () {
        // silent
      },
      complete: function () {
        $btn.removeClass('loading').prop('disabled', false).text('Load More');
      }
    });
  });


  /**
   * Header search toggle
   */
  var $searchDropdown = $('#searchDropdown');
  var $searchInput = $('#searchDropdownInput');
  var $searchResults = $('#searchResults');
  var $searchLoading = $('#searchLoading');
  var searchTimer = null;

  // Open search
  $('.search-toggle').click(function () {
    $searchDropdown.addClass('open');
    setTimeout(function () { $searchInput.focus(); }, 350);
  });

  // Close search
  $('.search-dropdown__close').click(function () {
    $searchDropdown.removeClass('open');
    $searchInput.val('');
    $searchResults.html('');
  });

  // Close on Escape
  $(document).keydown(function (e) {
    if (e.key === 'Escape' && $searchDropdown.hasClass('open')) {
      $searchDropdown.removeClass('open');
      $searchInput.val('');
      $searchResults.html('');
    }
  });

  // AJAX search with debounce
  $searchInput.on('input', function () {
    var query = $(this).val().trim();
    clearTimeout(searchTimer);

    if (query.length < 2) {
      $searchResults.html('');
      $searchLoading.removeClass('visible');
      return;
    }

    $searchLoading.addClass('visible');
    $searchResults.html('');

    searchTimer = setTimeout(function () {
      $.ajax({
        url: bozy_options.ajax_url,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'bzy_search_posts',
          nonce: bozy_options.nonce,
          search: query
        },
        success: function (response) {
          $searchLoading.removeClass('visible');
          if (response.success) {
            var posts = response.data.posts;
            if (posts.length > 0) {
              var html = '';
              posts.forEach(function (item) {
                html += '<a class="post-card-simple-horizontal" href="' + item.link + '">' +
                  '<figure class="post-card-simple-horizontal__image">' +
                    '<img src="' + item.thumb + '" alt="' + item.post_title + '">' +
                  '</figure>' +
                  '<div class="post-card-simple-horizontal__body">' +
                    '<h3 class="post-card-simple-horizontal__title bold fs-16">' + item.post_title + '</h3>' +
                    '<div class="post-card-simple-horizontal__meta">' +
                      '<span class="post-card-simple-horizontal__date">' +
                        '<svg class="icon me-1" width="14" height="14"><use xlink:href="' + bozy_options.sprite_url + '#calendar"></use></svg>' +
                        item.date +
                      '</span>' +
                      '<span class="post-card-simple-horizontal__divider"></span>' +
                      '<span class="post-card-simple-horizontal__reading-time">' +
                        '<svg class="icon me-1" width="14" height="14"><use xlink:href="' + bozy_options.sprite_url + '#clock"></use></svg>' +
                        item.reading_time + ' min read' +
                      '</span>' +
                    '</div>' +
                    '<span class="post-card-simple-horizontal__btn">' +
                      'Read More' +
                      '<svg class="icon ms-1" width="14" height="14"><use xlink:href="' + bozy_options.sprite_url + '#arrow"></use></svg>' +
                    '</span>' +
                  '</div>' +
                '</a>';
              });
              $searchResults.html(html);
            } else {
              $searchResults.html('<div class="search-dropdown__empty">No results found for "' + query + '"</div>');
            }
          }
        },
        error: function () {
          $searchLoading.removeClass('visible');
        }
      });
    }, 350);
  });


  /**
   * Newsletter form submission
   */
  $('body').delegate('#newsletterForm', 'submit', function (e) {
    e.preventDefault();
    var $form = $(this);
    var $msg = $form.find('.newsletter-form__message');
    var email = $form.find('input[name="email"]').val();

    $.ajax({
      url: bozy_options.ajax_url,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'bzy_newsletter_subscribe',
        nonce: bozy_options.nonce,
        email: email
      },
      beforeSend: function () {
        $form.find('button').prop('disabled', true).text('Subscribing...');
      },
      success: function (response) {
        $msg.removeClass('success error');
        if (response.success) {
          $msg.addClass('success').text(response.data.message);
          $form.find('input[name="email"]').val('');
        } else {
          $msg.addClass('error').text(response.data.message);
        }
      },
      error: function () {
        $msg.removeClass('success').addClass('error').text('Something went wrong. Please try again.');
      },
      complete: function () {
        $form.find('button').prop('disabled', false).text('Subscribe');
      }
    });
  });

});
