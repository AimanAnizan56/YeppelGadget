$(() => {
    // add carousel method from jquery
    $(".carousel").carousel({
        fullWidth: false
    }, setTimeout(autoSlide, 4500));
    function autoSlide(){
        $('.carousel').carousel('next');
        setTimeout(autoSlide,4500);
    }
})