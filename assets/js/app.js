(function ($) {
    // Owl Carousel
    $(document).ready(function () {
        var $btns = $(".career-cat-btns li");
        var $btns2 = $(".career-tax-btns li");

        $btns.click(function (e) {
            $(".career-tax-btns li").removeClass("active");
            $(".career-cat-btns li").removeClass("active");
            e.target.classList.add("active");

            let selector = $(e.target).attr("data-filter");
            $(".career-items .grid").isotope({
                filter: selector,
            });

            return false;
        });

        $btns2.click(function (e) {
            $(".career-tax-btns li").removeClass("active");
            $(".career-cat-btns li").removeClass("active");

            e.target.classList.add("active");

            let selector = $(e.target).attr("data-filter");
            $(".career-items .grid").isotope({
                filter: selector,
            });

            return false;
        });

        $(".products .owl-carousel").owlCarousel({
            autoplay: true,
            dots: true,
            loop: false,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                900: {
                    items: 3,
                },
            },
        });

    });

})(jQuery);