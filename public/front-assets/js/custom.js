// ================== HAMBURGER =================== //
function hamburger(a) {
  a.classList.toggle("change");
  $('body').toggleClass('nav-active');
}

$('.city-items').slick({
    slidesToShow: 4,
    slidesToScroll: 2,
    rows: 1,
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    infinite: false,
    autoplay: false,
    autoplaySpeed: 5000,
    arrows: true,
    responsive: [              
      {
        breakpoint: 1399,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      }
    ]
  });
$('.plot-thumb-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 2,
    rows: 1,
    dots: true,
    centerMode: false,
    focusOnSelect: true,
    infinite: false,
    autoplay: false,
    autoplaySpeed: 5000,
    arrows: false,
     
  });
//  $(window).scroll(function(){
//       if ($(this).scrollTop() > 120) {
//           $('header').addClass('fixed');
//       } else {
//           $('header').removeClass('fixed');
//       }
// });
// footer stay bottom
  $(document).ready(function () {
    headerHeight();
  });
  $(window).resize(function () {
    headerHeight();
  });

  function headerHeight() {
    var windowHeight = $("html").innerHeight();
    var headerH = $("header").innerHeight();
    var footerH = $(".main-footer").innerHeight();
    var footerandheaderH = headerH + footerH;
    var innercontH = windowHeight - footerH;
    $(".sec-log-regi").css({ "min-height": innercontH });
    $(".sec-log-regi").css({ "padding-top": headerH });
 
  }

