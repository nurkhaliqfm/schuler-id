const tabButton = document.querySelectorAll("div.tab_button_style");

function htmlScript(
  order_id,
  paket_name,
  transaction_time,
  status_invoice,
  va_number,
  bank,
  price
) {
  return (
    `
      <div class="box_item__header invoice_box_header">
          <div class="header__desc">
              <div class="box_body__title">
                  <span class="name">Kode</span>
                  <span>:</span>
                  <span class="desc">` +
    order_id +
    `</span>
              </div>
              <div class="box_body__title">
                  <span class="name">Paket</span>
                  <span>:</span>
                  <span class="desc">` +
    paket_name +
    `</span>
              </div>
              <div class="box_body__title">
                  <span class="name">Tanggal</span>
                  <span>:</span>
                  <span class="desc">` +
    transaction_time +
    `</span>
              </div>
          </div>
          <div class="header__status">
              <span class="alert__box alert-invoice ` +
    status_invoice[1] +
    `">` +
    status_invoice[0] +
    `</span>
          </div>
      </div>
      <div class="box_item__body invoice-body">
          <div class="body__rek">
              <div class="rek_title">
                  Nor. Rek (` +
    bank.toUpperCase() +
    `)
                  <button id="copy_rek" class="tab_button tab_button_style"><i class="fa-solid fa-copy"></i></button>
              </div>
              <div value="` +
    va_number +
    `" class="rek_data"><span>` +
    va_number +
    `</span></div>
          </div>
          <div class="body__nominal">
              <div class="nominal_title">
                  Total Pembayaran
                  <button id="copy_nominal" class="tab_button tab_button_style"><i class="fa-solid fa-copy"></i></button>
              </div>
              <div value="` +
    price +
    `" class="nominal_value"><span>` +
    convertToRupiah(price) +
    `</span></div>
              <div class="nominal_desc">*Pembayaran harus sesuai dengan nominal diatas</div>
          </div>
      </div>
      <div class="box_item__footer invoice_footer">
          <div class="button__container">
              <a id="delete_btn" data_button="` +
    order_id +
    `" class="tab_button tab_button_style deleted-Btn">Batalkan Pembayaran</a>
              <a id="cek_btn" data_button="` +
    order_id +
    `" class="tab_button tab_button_style success-Btn">Konfirmasi Pembayaran</a>
          </div>
      </div>
  `
  );
}

function convertToRupiah(angka) {
  var rupiah = "";
  var angkarev = angka.toString().split("").reverse().join("");
  for (var i = 0; i < angkarev.length; i++)
    if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
  return (
    "Rp. " +
    rupiah
      .split("", rupiah.length - 1)
      .reverse()
      .join("")
  );
}

function CreateItemInvoice(root, data) {
  root.innerHTML = "";
  for (let i = 0; i < Object.keys(data).length; i++) {
    var boxInvoice = document.createElement("div");
    boxInvoice.className = "box_item__container container_invoice small-box";
    boxInvoice.innerHTML = htmlScript(
      data[i].order_id,
      data[i].paket_name,
      data[i].transaction_time,
      listStatus[data[i].transaction_status],
      data[i].va_number,
      data[i].bank,
      data[i].price
    );
    root.appendChild(boxInvoice);
  }
}

function DefaultTabButton(root, data) {
  let tabButton = document.querySelectorAll("#tab_button");
  let dataInvoice = data.filter((obj) => {
    return obj.transaction_status == tabButton[0].getAttribute("data-button");
  });

  document.getElementById(tabButton[0].id).classList.add("active");
  CreateItemInvoice(root, dataInvoice);
}

function TabButtonControl(root, data) {
  let tabButton = document.querySelectorAll("#tab_button");
  tabButton.forEach((el) => {
    el.addEventListener("click", () => {
      tabButton.forEach((element) => {
        element.classList.remove("active");
      });

      let dataInvoice = data.filter((obj) => {
        return obj.transaction_status == el.getAttribute("data-button");
      });

      document
        .querySelector(
          '#tab_button[data-button="' + el.getAttribute("data-button") + '"]'
        )
        .classList.add("active");
      CreateItemInvoice(root, dataInvoice);
      ButtonControl(base_url);

      if (
        el.getAttribute("data-button") == "cancel" ||
        el.getAttribute("data-button") == "settlement"
      ) {
        document
          .querySelectorAll(".box_item__footer.invoice_footer")
          .forEach((el) => {
            el.setAttribute("style", "display: none;");
          });

        document.querySelectorAll("#copy_rek").forEach((el) => {
          el.setAttribute("style", "display: none;");
        });

        document.querySelectorAll("#copy_nominal").forEach((el) => {
          el.setAttribute("style", "display: none;");
        });

        document.querySelectorAll(".nominal_desc").forEach((el) => {
          el.setAttribute("style", "display: none;");
        });
      }
    });
  });
}

function ButtonControl(url) {
  document.querySelectorAll("#delete_btn").forEach((el) => {
    el.addEventListener("click", () => {
      let order_id = el.getAttribute("data_button");

      const data = {};
      data["user_order"] = "cancel";
      data[csrfName] = csrfHash;
      data["order_id"] = order_id;

      var xhttp = new XMLHttpRequest();
      xhttp.open("POST", url, true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          var response = JSON.parse(xhttp.responseText);
          document.getElementById("txt_csrfname").value = response["value"];
          document.getElementById("txt_csrfname").name = response["name"];
          location.reload();
        }
      };
      xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhttp.setRequestHeader("Content-Type", "application/json");
      xhttp.send(JSON.stringify(data));
    });
  });

  document.querySelectorAll("#cek_btn").forEach((el) => {
    el.addEventListener("click", () => {
      let order_id = el.getAttribute("data_button");

      const data = {};
      data["user_order"] = "cek_transaction";
      data[csrfName] = csrfHash;
      data["order_id"] = order_id;

      var xhttp = new XMLHttpRequest();
      xhttp.open("POST", url, true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          var response = JSON.parse(xhttp.responseText);
          document.getElementById("txt_csrfname").value = response["value"];
          document.getElementById("txt_csrfname").name = response["name"];
          location.reload();
        }
      };
      xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhttp.setRequestHeader("Content-Type", "application/json");
      xhttp.send(JSON.stringify(data));
    });
  });
}
