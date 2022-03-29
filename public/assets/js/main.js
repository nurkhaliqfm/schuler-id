$(window).on("load", function () {
  /*----------- Preloader ------------*/
  $(".preloader").fadeOut("slow");

  /*----------- Toggle Button ------------*/
  const menuBtn = document.querySelector(".menu-btn");
  const sidebarnav = document.querySelector(".sidebar-nav");
  let menuOpen = false;
  menuBtn.addEventListener("click", () => {
    if (!menuOpen) {
      menuBtn.classList.add("open");
      menuOpen = true;
      sidebarnav.classList.remove("hide");
      sidebarnav.classList.add("full");
    } else {
      menuBtn.classList.remove("open");
      menuOpen = false;
      sidebarnav.classList.remove("full");
      sidebarnav.classList.add("hide");
    }
  });

  /*----------- Sidebar Responsive ------------*/
  var setsidebartype = function () {
    var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;
    if (width < 992) {
      menuBtn.classList.remove("open");
      menuOpen = false;
      sidebarnav.classList.add("hide");
    } else {
      sidebarnav.classList.remove("hide");
      sidebarnav.classList.remove("full");
    }
  };
  $(window).ready(setsidebartype);
  $(window).on("resize", setsidebartype);
});
