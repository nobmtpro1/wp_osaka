var hamburger = document.querySelector(".hamburger");
var menu = document.querySelector(".header .menu-menu-chinh-container");

hamburger?.addEventListener("click", function () {
  if (menu?.classList?.contains("active")) {
    menu?.classList?.remove("active");
  } else {
    menu?.classList?.add("active");
  }
});
