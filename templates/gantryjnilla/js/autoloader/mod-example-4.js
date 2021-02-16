(function($) {
    $(document).ready(function() {


        $('.slicky-2').slick({
          arrows: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          centerMode: true,	
          centerPadding: 0,
          focusOnSelect: true,
          pauseOnFocus: true,
          //autoplay: true,
          autoplaySpeed: 6000,
          responsive: [
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true
      }
    }    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
	
        })
      
      
      
    });

})(jQuery);


