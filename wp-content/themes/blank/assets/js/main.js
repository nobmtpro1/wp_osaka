function elementInViewport(el) {
  var top = el.offsetTop;
  var left = el.offsetLeft;
  var width = el.offsetWidth;
  var height = el.offsetHeight;

  while (el.offsetParent) {
    el = el.offsetParent;
    top += el.offsetTop;
    left += el.offsetLeft;
  }

  return (
    top < window.pageYOffset + window.innerHeight &&
    left < window.pageXOffset + window.innerWidth &&
    top + height > window.pageYOffset &&
    left + width > window.pageXOffset
  );
}

function isInViewport(elem) {
  let x = elem.getBoundingClientRect().left;
  let y = elem.getBoundingClientRect().top;
  let ww = Math.max(
    document.documentElement.clientWidth,
    window.innerWidth || 0
  );
  let hw = Math.max(
    document.documentElement.clientHeight,
    window.innerHeight || 0
  );
  let w = elem.clientWidth;
  let h = elem.clientHeight;
  return y < hw && y + h > 0 && x < ww && x + w > 0;
}

$(document).on("scroll", function () {
  if (
    !isInViewport(document.querySelector(".component-header")) &&
    !isInViewport(document.querySelector(".component-header .menu"))
  ) {
    $(".component-header .top").addClass("hide");
    $(".component-header .bot").addClass("hide");
    $(".component-header .mid").addClass("stick");
  }
  if ($(window).scrollTop() < 200) {
    $(".component-header .top").removeClass("hide");
    $(".component-header .bot").removeClass("hide");
    $(".component-header .mid").removeClass("stick");
  }
});

$(document).ready(function () {
  $(".component-header .menu a").append(`<span class"arrow"></span>`);
});

$(document).on("click", ".component-header .menu a span", function (e) {
  e.preventDefault();
  $(this).parent().parent().find(".sub-menu").toggleClass("active");
  $(this).toggleClass("active");
});

$(document).on("click", ".component-header .menu-button", function (e) {
  $(".component-header .bot").toggleClass("active-mobile");
});

$(document).on("click", ".component-header .bot .menu-button", function (e) {
  $(".component-header .bot .menu").toggleClass("hide");
  $(".component-header .bot .menu").toggleClass("hide-desktop");
});

$(document).on("click", ".component-header .mobile-backdrop", function (e) {
  $(".component-header .bot").toggleClass("active-mobile");
});

$(document).on("click", ".component-modal .content > .close", function () {
  $(this).parents(".component-modal").removeClass("active");
});

$(document).on("click", ".g-shop-filter > button", function () {
  $(".g-shop-filter-modal").toggleClass("active");
});

$(document).on("click", "#check-order", function (e) {
  e?.preventDefault();
  const lastOrderUrl = localStorage.getItem("last_order_url");
  if (lastOrderUrl) {
    window.location.href = lastOrderUrl;
  } else {
    $.toast({
      text: "Bạn chưa có đơn đặt hàng nào gần đây",
      showHideTransition: "plain",
      icon: "error",
      position: "top-right",
    });
  }
});
