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

$(document).on("scroll", function () {
  console.log();
  if (!elementInViewport(document.querySelector(".component-header"))) {
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
