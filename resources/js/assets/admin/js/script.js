$(function () {

  // fixed header part js
  $(window).scroll(function () {
    let scrolling = $(this).scrollTop();
    if (scrolling > 0) {
      $('.top-header').addClass('fixed');
    } else {
      $('.top-header').removeClass('fixed');
    }
  });

  // dropdown profile js
  let Accordion = function (el, multiple) {
    this.el = el || {};
    this.multiple = multiple || false;

    // Variables privadas
    let links = this.el.find('.link');
    // Evento
    links.on('click', {
      el: this.el,
      multiple: this.multiple
    }, this.dropdown)
  }

  Accordion.prototype.dropdown = function (e) {
    let $el = e.data.el;
    $this = $(this),
      $next = $this.next();

    $next.slideToggle();
    $this.parent().toggleClass('open');

    if (!e.data.multiple) {
      $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
    };
  }

  let accordion = new Accordion($('#accordion'), false);


  // collapsed sidebar js
  $('.control-bar i').click(function () {
    $('body').toggleClass('collapsed-menu');
  })

  $('.mobile-control-bar i').click(function () {
    $('.navigation-body').addClass('show-mobile-sidebar');
    body.style.overflow = "hidden";
  })

  $('.mobile-control-bar i').click(function () {
    $('.toggle-overlay').addClass('show-toggle-overlay');
    body.style.overflow = "hidden";
  })

  $('.close-mobile-menu i').click(function () {
    $('.navigation-body').removeClass('show-mobile-sidebar');
    body.style.overflow = "auto";
  })

  $('.close-mobile-menu i').click(function () {
    $('.toggle-overlay').removeClass('show-toggle-overlay');
    body.style.overflow = "auto";
  })

  $('.toggle-overlay').click(function () {
    $('.toggle-overlay').removeClass('show-toggle-overlay');
    body.style.overflow = "auto";
  })

  $('.toggle-overlay').click(function () {
    $('.navigation-body').removeClass('show-mobile-sidebar');
    body.style.overflow = "auto";
  })

  // Request full screen js
  const arrows = document.querySelector('.fa-arrows-alt')
  const body = document.querySelector('body')

  const toggleFullscreen = () => {
    if (document.fullscreenElement)
      document.exitFullscreen()
    else
      body.requestFullscreen()
  }

  // arrows.addEventListener('click', toggleFullscreen ?? 'a')
  const onChange = () => {
    body.className = document.fullscreenElement ? 'fullscreen' : ''
  }
  document.addEventListener('fullscreenchange', onChange)


    $(".click-developed-arrow").on("click", function () {
        $(".click-developed").toggleClass("show-hide-click-developed");
    })
  // couter up js
  // $('.counter').counterUp({
  //   delay: 30,
  //   time: 2000
  // });




  // two menu hide show js
  // let top_navbar = document.querySelector(".top-navbar");
  // let navigation_body = document.querySelector(".navigation-body");
  // let left_title = document.querySelector(".left-title");
  // let main_content_body = document.querySelector(".main-content-body");

  // left_title.addEventListener("click", () => {
  //   top_navbar.classList.toggle("active-navbar");
  //   navigation_body.classList.toggle("active-navigation-body");
  //   main_content_body.classList.toggle("margin-none")
  // })


});
