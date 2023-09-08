var hamburger = document.querySelector(".canvas__open");
var menu = document.querySelector(".offcanvas-menu-wrapper");
var headerTop = document.querySelector(".header__top");
var header = document.querySelector(".header > .container");

hamburger?.addEventListener("click", function () {
  setTimeout(() => {
    if (menu?.classList?.contains("active2")) {
      menu?.classList?.remove("active2");
      menu?.classList?.remove("active");
    } else {
      menu?.classList?.add("active2");
    }
  }, 100);
});

function checkVisible(elm) {
  var rect = elm.getBoundingClientRect();
  var viewHeight = Math.max(
    document.documentElement.clientHeight,
    window.innerHeight
  );
  return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
}

document.addEventListener("scroll", function name() {
  if (checkVisible(headerTop)) {
    console.log(true);
    header?.classList?.remove("sticky");
  } else {
    console.log(false);
    header?.classList?.add("sticky");
  }
});
