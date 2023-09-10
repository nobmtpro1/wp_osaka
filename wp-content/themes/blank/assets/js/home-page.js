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

$(document).on(
  "click",
  ".page-home section.product-category .nav-right",
  function () {
    var leftPos = $(this)
      .parents("section.product-category")
      .find(".w-loop-1-row")
      .scrollLeft();
    console.log(leftPos);
    $(this)
      .parents("section.product-category")
      .find(".w-loop-1-row")
      .animate(
        {
          scrollLeft: leftPos + 500,
        },
        300
      );
  }
);

$(document).on(
  "click",
  ".page-home section.product-category .nav-left",
  function () {
    var leftPos = $(this)
      .parents("section.product-category")
      .find(".w-loop-1-row")
      .scrollLeft();
    console.log(leftPos);
    $(this)
      .parents("section.product-category")
      .find(".w-loop-1-row")
      .animate(
        {
          scrollLeft: leftPos - 500,
        },
        300
      );
  }
);

$(".page-home section.product-category .tabs li").each(function (i) {
  $(this).on("click", function () {
    $(this).parent().find("li").removeClass("active");
    $(this)
      .parents("section.product-category")
      .find(".tab-contents > li")
      .removeClass("active");
    $(this).addClass("active");

    $(this)
      .parents("section.product-category")
      .find(".tab-contents > li")
      ?.each(function (e) {
        if (i == e) {
          $(this).addClass("active");
        }
      });
  });
});

var swiper = new Swiper(".blogs-slider", {
  slidesPerView: 3,
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
