const tabButton = document.querySelectorAll("div.tab_button_style");

function CreateItemOption(categoryItems, filter) {
  let filterArray = filter.split(",");
  for (let i = 0; i < Object.keys(categoryItems).length; i++) {
    if (filterArray.includes(categoryItems[i].quiz_subject)) {
      var container = document.getElementById("container_body");
      var boxItem = document.createElement("div");
      var boxHeader = document.createElement("div");
      var boxBody = document.createElement("div");
      var boxBodyTitle = document.createElement("div");
      var boxBodySubtitle = document.createElement("div");
      var boxFooter = document.createElement("div");
      var boxFooterBtn = document.createElement("a");

      boxItem.className = "box_item__container";
      boxItem.setAttribute("data-box", categoryItems[i].quiz_subject);
      boxHeader.className = "box_item__header";
      boxHeader.innerHTML = categoryItems[i].quiz_name.toUpperCase();
      boxBody.className = "box_item__body";
      boxBodyTitle.className = "box_body__title";
      boxBodyTitle.innerHTML =
        "Jumlah Soal: " + categoryItems[i].total_soal + " Nomor";
      boxBodySubtitle.className = "box_body__subtitle";
      boxBodySubtitle.innerHTML = "Waktu: " + categoryItems[i].timer + " Menit";
      boxFooter.className = "box_item__footer quiz_footer";
      boxFooterBtn.className = "box_item__Btn list_quiz_button selected";
      boxFooterBtn.setAttribute("data-button", categoryItems[i].quiz_id);
      boxFooterBtn.innerHTML = "Kerjakan";

      boxBody.appendChild(boxBodyTitle);
      boxBody.appendChild(boxBodySubtitle);
      boxFooter.appendChild(boxFooterBtn);
      boxItem.appendChild(boxHeader);
      boxItem.appendChild(boxBody);
      boxItem.appendChild(boxFooter);
      container.appendChild(boxItem);
    }
  }
}

function FilterCategoryOptions(categoryItems, items) {
  for (let i = 0; i < Object.keys(categoryItems).length; i++) {
    if (categoryItems[i].quiz_subject == items.id) {
      document
        .querySelectorAll(
          '.box_item__container[data-box="' +
            categoryItems[i].quiz_subject +
            '"]'
        )
        .forEach((item) => {
          item.setAttribute("style", "");
        });
    } else {
      document
        .querySelectorAll(
          '.box_item__container[data-box="' +
            categoryItems[i].quiz_subject +
            '"]'
        )
        .forEach((item) => {
          item.setAttribute("style", "display:none");
        });
    }
  }
}

function DefaultTabButton(typeItems, categoryItems, base_url) {
  document.getElementById(typeItems[0].id).classList.add("active");
  document.querySelectorAll("a.list_quiz_button").forEach((item) => {
    item.setAttribute(
      "href",
      base_url +
        "/?id=" +
        typeItems[0].id +
        "&query=" +
        item.getAttribute("data-button")
    );
  });

  FilterCategoryOptions(categoryItems, typeItems[0]);
}

function TabButtonControl(typeItems, categoryItems, base_url) {
  for (let i = 0; i < Object.keys(typeItems).length; i++) {
    let item = typeItems[i];
    let btnId = item.id;
    document.getElementById(btnId).addEventListener("click", (el) => {
      tabButton.forEach((itemBtnTab) => {
        itemBtnTab.classList.remove("active");
      });

      document.getElementById(el.target.id).classList.add("active");
      document.querySelectorAll("a.list_quiz_button").forEach((item) => {
        item.setAttribute(
          "href",
          base_url +
            "/?id=" +
            el.target.id +
            "&query=" +
            item.getAttribute("data-button")
        );
      });

      FilterCategoryOptions(categoryItems, item);
    });
  }
}
