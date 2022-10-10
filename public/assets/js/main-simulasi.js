$(window).on("load", function () {
  /*----------- Preloader ------------*/
  $(".loader-bg").fadeOut("slow");

  /*----------- Sidebar Responsive ------------*/
  var setsidebartype = function () {
    /*----------- Toggle Button ------------*/
    const navbarBrandImg = document.getElementById("navbar-brand-img");
    const navbarBrand = document.getElementById("navbar-brand");
    var base_url = window.location.origin;

    var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;
    if (width > 768) {
      navbarBrand.classList.remove("half-navbar-brand");
      document.getElementById("navbar-brand-img").src =
        base_url + "/assets/img/schuler-logo.png";
      navbarBrandImg.classList.remove("half-logo");
    } else if (width <= 768 && width > 420) {
      document.getElementById("navbar-brand-img").src =
        base_url + "/assets/img/schuler-logo-half.png";
      navbarBrand.classList.add("half-navbar-brand");
      navbarBrandImg.classList.add("half-logo");
    } else if (width <= 420) {
      document.getElementById("navbar-brand-img").src =
        base_url + "/assets/img/schuler-logo-half.png";
      navbarBrand.classList.add("half-navbar-brand");
      navbarBrandImg.classList.add("half-logo");
    }
  };

  $(window).ready(setsidebartype);
  $(window).on("resize", setsidebartype);
});
