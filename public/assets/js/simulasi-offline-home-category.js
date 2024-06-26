const tabButton = document.querySelectorAll("div.tab_button_style");
var base_url = window.location.origin;

function CreateItemOption(typeItems, categoryItems, filter) {
  let filterGroup = filter.find(
    ({ slug }) => slug === document.getElementById(typeItems[0].slug).id
  );
  let filterArray = filterGroup["category_item"].split(",");
  for (let i = 0; i < Object.keys(categoryItems).length; i++) {
    if (filterArray.includes(categoryItems[i].quiz_subject)) {
      var container = document.getElementById("container_body");
      var boxItem = document.createElement("div");
      var boxHeader = document.createElement("div");
      var boxBody = document.createElement("div");
      var boxBodyTitle = document.createElement("div");
      var boxBodySubtitle = document.createElement("div");
      var boxBodyDesc = document.createElement("div");
      var boxFooter = document.createElement("div");
      var boxFooterBtn = document.createElement("a");
      var boxFooterBtn2 = document.createElement("a");
      var boxFooterBtn3 = document.createElement("a");

      boxItem.className = "box_item__container";
      boxItem.setAttribute("data-box", categoryItems[i].quiz_type);
      boxHeader.className = "box_item__header";
      boxHeader.innerHTML = categoryItems[i].quiz_name.toUpperCase();
      boxBody.className = "box_item__body";
      boxBodyTitle.className = "box_body__title";
      boxBodyTitle.innerHTML =
        "Jumlah Soal = " + categoryItems[i].total_soal + " Nomor";
      boxBodySubtitle.className = "box_body__subtitle";
      boxBodySubtitle.innerHTML = "Waktu: " + categoryItems[i].timer + " Menit";
      boxBodyDesc.className = "box_body__desc";
      boxBodyDesc.innerHTML = categoryItems[i].desc;
      boxFooter.className = "box_item__footer simulasi_box_footer";
      boxFooterBtn.className = "box_item__Btn list_quiz_button-normal selected";
      boxFooterBtn.setAttribute("data-button", categoryItems[i].quiz_id);
      boxFooterBtn.innerHTML = "Kerjakan";
      boxFooterBtn2.className = "box_item__Btn";
      boxFooterBtn2.innerHTML = "Rangking Nasional";
      boxFooterBtn2.setAttribute("href", base_url + "/home/event_rangking");
      boxFooterBtn3.className = "box_item__Btn";
      boxFooterBtn3.innerHTML = "Rangking Univ";
      boxFooterBtn3.setAttribute(
        "href",
        base_url + "/home/event_rangking_universitas"
      );

      boxBody.appendChild(boxBodyTitle);
      boxBody.appendChild(boxBodySubtitle);
      boxBody.appendChild(boxBodyDesc);
      boxFooter.appendChild(boxFooterBtn);
      //   boxFooter.appendChild(boxFooterBtn2);
      //   boxFooter.appendChild(boxFooterBtn3);
      boxItem.appendChild(boxHeader);
      boxItem.appendChild(boxBody);
      boxItem.appendChild(boxFooter);
      container.appendChild(boxItem);
    }
  }
}

function FilterCategoryOptions(categoryItems, items) {
  for (let i = 0; i < Object.keys(categoryItems).length; i++) {
    if (categoryItems[i].quiz_type == items.slug) {
      document
        .querySelectorAll(
          '.box_item__container[data-box="' + categoryItems[i].quiz_type + '"]'
        )
        .forEach((item) => {
          item.setAttribute("style", "");
        });
    } else {
      document
        .querySelectorAll(
          '.box_item__container[data-box="' + categoryItems[i].quiz_type + '"]'
        )
        .forEach((item) => {
          item.setAttribute("style", "display:none");
        });
    }
  }
}

function DefaultTabButton(typeItems, categoryItems) {
  document.getElementById(typeItems[0].slug).classList.add("active");
  document.querySelectorAll("a.list_quiz_button-normal").forEach((item) => {
    item.setAttribute(
      "href",
      base_url +
        "/home/offline_simulasi_guide" +
        "?id=" +
        typeItems[0].category_id +
        "&query=" +
        item.getAttribute("data-button") +
        "&m=" +
        mitra
    );
  });

  FilterCategoryOptions(categoryItems, typeItems[0]);
}
