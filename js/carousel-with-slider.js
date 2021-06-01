$(() => {
    // add carousel with slider method from jquery
    $(".carousel.carousel-slider").carousel({
        fullWidth: true,
        indicators: true
    }, setTimeout(autoSlide, 4500));
    function autoSlide(){
        $('.carousel').carousel('next');
        setTimeout(autoSlide,4500);
    }
})