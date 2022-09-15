$(window).on("load", function () {
  /*----------- Preloader ------------*/
  $(".preloader").fadeOut("slow");

  /*----------- Sidebar Responsive ------------*/
  var setsidebartype = function () {
    /*----------- Toggle Button ------------*/
    const menuBtn = document.querySelector(".menu-btn");
    const sidebarnav = document.querySelector(".sidebar-nav");
    const navbarBrandImg = document.getElementById("navbar-brand-img");
    const navbarBrand = document.getElementById("navbar-brand");
    var base_url = window.location.origin;
    let menuOpen = false;

    if (menuBtn) {
      var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;
      if (width > 768) {
        $(".sidebarnav-list .sidebar-item-title").removeClass("half");
        $(".sidebar-item .sidebar-link").removeClass("half");
        $(".sidebar-nav li .nav-treeview").removeClass("half");
        $(".sidebar-nav .sidebar-bottom").removeClass("half");

        sidebarnav.classList.remove("hide");
        sidebarnav.classList.remove("half");
        sidebarnav.classList.remove("full");
        navbarBrand.classList.remove("half-navbar-brand");
        document.getElementById("navbar-brand-img").src =
          base_url + "/assets/img/schuler-logo.png";
        navbarBrandImg.classList.remove("half-logo");
      } else if (width <= 768 && width > 420) {
        $(".sidebarnav-list .sidebar-item-title").removeClass("half");
        $(".sidebar-item .sidebar-link").removeClass("half");
        $(".sidebar-nav li .nav-treeview").removeClass("half");
        $(".sidebar-nav .sidebar-bottom").removeClass("half");

        menuBtn.classList.remove("open");
        sidebarnav.classList.add("half");
        sidebarnav.classList.remove("hide");
        sidebarnav.classList.remove("full");

        menuBtn.addEventListener("click", () => {
          if (!menuOpen) {
            menuBtn.classList.add("open");
            menuOpen = true;
            sidebarnav.classList.remove("half");
            sidebarnav.classList.add("full");

            $(".sidebarnav-list .sidebar-item-title").addClass("half");
            $(".sidebar-item .sidebar-link").addClass("half");
            $(".sidebar-nav li .nav-treeview").addClass("half");
            $(".sidebar-nav .sidebar-bottom").addClass("half");
          } else {
            menuBtn.classList.remove("open");
            menuOpen = false;
            sidebarnav.classList.remove("full");
            sidebarnav.classList.remove("hide");
            sidebarnav.classList.add("half");

            $(".sidebarnav-list .sidebar-item-title").removeClass("half");
            $(".sidebar-item .sidebar-link").removeClass("half");
            $(".sidebar-nav li .nav-treeview").removeClass("half");
            $(".sidebar-nav .sidebar-bottom").removeClass("half");
          }
        });

        document.getElementById("navbar-brand-img").src =
          base_url + "/assets/img/schuler-logo-half.png";
        navbarBrand.classList.add("half-navbar-brand");
        navbarBrandImg.classList.add("half-logo");
      } else if (width <= 420) {
        $(".sidebarnav-list .sidebar-item-title").removeClass("half");
        $(".sidebar-item .sidebar-link").removeClass("half");
        $(".sidebar-nav li .nav-treeview").removeClass("half");
        $(".sidebar-nav .sidebar-bottom").removeClass("half");

        menuBtn.classList.remove("open");
        sidebarnav.classList.add("hide");
        sidebarnav.classList.remove("half");
        sidebarnav.classList.remove("full");

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
            sidebarnav.classList.remove("half");
            sidebarnav.classList.add("hide");
          }
        });

        document.getElementById("navbar-brand-img").src =
          base_url + "/assets/img/schuler-logo-half.png";
        navbarBrand.classList.add("half-navbar-brand");
        navbarBrandImg.classList.add("half-logo");
      }
    }
  };

  $(window).ready(setsidebartype);
  $(window).on("resize", setsidebartype);
});
