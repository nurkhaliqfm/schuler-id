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
});
