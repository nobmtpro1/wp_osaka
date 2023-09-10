$(document).on("click", ".w-loop-preview-button", function (e) {
  e.preventDefault();
  $(this)
    .parents(".w-loop-product")
    ?.find(".w-loop-preview-modal")
    ?.toggleClass("active");
});

$(".w-loop-preview-modal").each(function (i) {
  console.log(
    $(`.w-product-gallery-${$(this).data("productid")}`)?.length,
    $(`.w-product-gallery-2-${$(this).data("productid")}`)?.length
  );
  if (
    $(`.w-product-gallery-${$(this).data("productid")}`)?.length &&
    $(`.w-product-gallery-2-${$(this).data("productid")}`)?.length
  ) {
    let swiper1 = new Swiper(
      `.w-product-gallery-${$(this).data("productid")}`,
      {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
      }
    );
    let swiper2 = new Swiper(
      `.w-product-gallery-2-${$(this).data("productid")}`,
      {
        loop: true,
        spaceBetween: 10,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        thumbs: {
          swiper: swiper1,
        },
      }
    );
  }
});
