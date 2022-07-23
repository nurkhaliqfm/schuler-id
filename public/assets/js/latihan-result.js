const list_element = document.getElementById("question__part"),
  pagination_element = document.getElementById("pagination"),
  prev_button = document.getElementById("item_prev"),
  next_button = document.getElementById("item_next"),
  question_num_btn = document.getElementById("question__number_side");

function CreateOption(question_id, id, value, label_option) {
  var radiobox = document.createElement("input");
  radiobox.type = "radio";
  radiobox.id = id;
  radiobox.value = value;
  radiobox.name = "flexRadioDefault";
  radiobox.className = "form-check-input";

  var label = document.createElement("label");
  label.htmlFor = id;
  label.className = "form-check-label";

  var descLabel = document.createTextNode(label_option + ". ");
  var descText = document.createElement("span");
  descText.id = value;

  label.appendChild(descLabel);
  label.appendChild(descText);

  var newline = document.createElement("br");

  var container = document.getElementById(question_id);
  container.appendChild(radiobox);
  container.appendChild(label);
  container.appendChild(newline);
}

function SaveAnsware() {
  var UserQuizStorage = localStorage.getItem(sessionID);
  UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

  document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
    if (itemOption.checked) {
      var new_data = itemOption.value;
      var id_soal = document
        .getElementById("question__part")
        .getAttribute("id-soal");

      UserQuizStorage[id_soal] = new_data;

      localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
    }
  });
}

function DisplayList(items, rows_per_page, page, userAnsware) {
  page--;
  let start = rows_per_page * page;
  let end = start + rows_per_page;
  let paginatedItems = items.slice(start, end);

  for (let i = 0; i < paginatedItems.length; i++) {
    let item = paginatedItems[i];
    let dataSoal = dataItems.find(
      ({ id_soal }) => id_soal === item.quiz_question
    );
    let qSubject = typeSoal.find(
      ({ id_main_type_soal }) => id_main_type_soal === item.quiz_subject
    );
    let subjectListID = qSubject.list_type_soal_id.split(",");
    let subjectListName = qSubject.list_type_soal.split(",");
    let getId = subjectListID.findIndex(
      (index) => index === item.quiz_sub_subject
    );

    let yourAnsware = userAnsware[dataSoal.id_soal].split("_");
    let realAnsware = dataSoal.ans_id.split("_");
    if (yourAnsware[0] == 0) {
      yourAnsware[1] = "-";
    }

    document.getElementById("question__number").innerHTML = page + 1;
    document.getElementById("question__subject").innerHTML =
      subjectListName[getId];

    document.getElementById("box_desc").classList.remove("active");
    document.getElementById("box_desc").classList.remove("warning");
    document.getElementById("box_desc").classList.remove("normal");

    if (userAnsware[dataSoal.id_soal] == "0") {
      document.getElementById("box_desc").classList.add("normal");
      document.getElementById("box_desc").innerHTML = "KOSONG";
    } else if (dataSoal.jawaban == md5(userAnsware[dataSoal.id_soal])) {
      document.getElementById("box_desc").classList.add("active");
      document.getElementById("box_desc").innerHTML = "BENAR";
    } else {
      document.getElementById("box_desc").classList.add("warning");
      document.getElementById("box_desc").innerHTML = "SALAH";
    }

    document.getElementById("question__part").innerHTML = dataSoal.soal;
    document.getElementById("explain__part").innerHTML = dataSoal.pembahasan;
    document.getElementById("your_answare").innerHTML =
      yourAnsware[1].toUpperCase();
    document.getElementById("real_answare").innerHTML =
      realAnsware[1].toUpperCase();
    document
      .getElementById("question__part")
      .setAttribute("id-soal", dataSoal.id_soal);
    document.getElementById("result_subtitle").innerHTML = navbarTitle;
    if (document.querySelectorAll('p[data-f-id="pbf"]'))
      document.querySelectorAll('p[data-f-id="pbf"]').forEach((item) => {
        item.setAttribute("style", "display:none");
      });

    if (document.querySelectorAll("input.form-check-input").length == 0) {
      document
        .querySelectorAll(".question__answer__part .form-check")
        .forEach((item) => {
          let labelOption = item.getAttribute("option-name");
          CreateOption(
            item.id,
            "option" + labelOption,
            "option_" + labelOption.toLowerCase(),
            labelOption
          );
        });
    }

    document
      .querySelectorAll("input.form-check-input")
      .forEach((itemOption) => {
        document.querySelector(
          'span[id="' + itemOption.value + '"]'
        ).innerHTML = dataSoal[itemOption.value];
        itemOption.disabled = true;
        itemOption.checked = false;
        if (itemOption.value == userAnsware[dataSoal.id_soal]) {
          itemOption.checked = true;
        }
      });
  }
}

function PaginationListNumber(items, row_per_page, userAnsware) {
  let page_count = Math.ceil(items.length / row_per_page);
  for (let i = 1; i < page_count + 1; i++) {
    let btn = BtnNumberPagination(i, userAnsware, items);
    question_num_btn.appendChild(btn);
  }
}

function BtnNumberPagination(page, userAnsware, items) {
  let btn__side = document.createElement("div");
  btn__side.className = "question__number";
  btn__side.setAttribute("id-question", page);
  btn__side.innerHTML = page;

  let index = page - 1;
  let dataSoal = dataItems.find(
    ({ id_soal }) => id_soal === items[index].quiz_question
  );

  if (userAnsware[dataSoal.id_soal] == "0") {
    btn__side.classList.add("normal");
  } else if (dataSoal.jawaban == md5(userAnsware[dataSoal.id_soal])) {
    btn__side.classList.add("active");
  } else {
    btn__side.classList.add("warning");
  }

  return btn__side;
}

function SidebarStatus(current_page) {
  let selectedQuestion = document.querySelector(
    '.question__number[id-question="' + current_page + '"]'
  );
  selectedQuestion.classList.add("warning");

  document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
    if (itemOption.checked) {
      selectedQuestion.classList.remove("warning");
      selectedQuestion.classList.add("active");
    }
  });
}

function ButtonPagination(items) {
  next_button.addEventListener("click", () => {
    current_page = current_page + 1;
    DisplayList(items, rows, current_page, userAnsware);
    NavBtnControl(current_page);
  });

  prev_button.addEventListener("click", () => {
    current_page = current_page - 1;
    DisplayList(items, rows, current_page, userAnsware);
    NavBtnControl(current_page);
  });
}

function NavBtnControl(current_page) {
  if (current_page == 1) {
    prev_button.setAttribute("disabled", "");
  } else {
    prev_button.removeAttribute("disabled", "");
  }

  if (current_page == dataQuiz.length) {
    next_button.setAttribute("disabled", "");
  } else {
    next_button.removeAttribute("disabled", "");
  }
}
