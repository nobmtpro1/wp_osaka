var swiper = new Swiper(".bannerSlider", {
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
});

$(".page-home section.new-products .tab-titles li").each(function (i) {
  $(this).on("click", function () {
    $(".page-home section.new-products .tab-titles li").removeClass("active");
    $(".page-home section.new-products .tab-contents li").removeClass("active");
    $(this).addClass("active");

    $(".page-home section.new-products .tab-contents > li")?.each(function (e) {
      console.log(e, i);
      if (i == e) {
        $(this).addClass("active");
      }
    });
  });
});
