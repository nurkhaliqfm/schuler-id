const list_element = document.getElementById("question__part"),
  pagination_element = document.getElementById("pagination"),
  prev_button = document.getElementById("item_prev"),
  next_button = document.getElementById("item_next"),
  finish_button = document.getElementById("item_selesai"),
  notif_button = document.getElementById("notif_btn"),
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

function SaveAnsware(query) {
  var UserQuizStorage = localStorage.getItem(sessionID);
  UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

  document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
    if (itemOption.checked) {
      var quiz_id = query;
      var new_data = itemOption.value;
      var id_soal = document
        .getElementById("question__part")
        .getAttribute("id-soal");

      UserQuizStorage["quiz_id"] = quiz_id;
      UserQuizStorage[id_soal] = new_data;

      localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
    }
  });
}

function DisplayList(items, rows_per_page, page) {
  page--;
  let start = rows_per_page * page;
  let end = start + rows_per_page;
  let paginatedItems = items.slice(start, end);
  var UserQuizStorage = localStorage.getItem(sessionID);
  UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

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

    document.getElementById("question__number").innerHTML = page + 1;
    document.getElementById("question__subject").innerHTML =
      subjectListName[getId];
    document.getElementById("question__part").innerHTML = dataSoal.soal;
    document
      .getElementById("question__part")
      .setAttribute("id-soal", dataSoal.id_soal);
    document.getElementById("simulation__title").innerHTML = navbarTitle;
    document.getElementById("simulation__subtitle").innerHTML =
      qSubject.main_type_soal;
    if (document.querySelector('p[data-f-id="pbf"]'))
      document
        .querySelector('p[data-f-id="pbf"]')
        .setAttribute("style", "display:none");

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
        itemOption.checked = false;
        if (itemOption.value == UserQuizStorage[dataSoal.id_soal]) {
          itemOption.checked = true;
        }
      });
  }
}

function PaginationListNumber(items, row_per_page) {
  let page_count = Math.ceil(items.length / row_per_page);
  for (let i = 1; i < page_count + 1; i++) {
    let btn = BtnNumberPagination(i);
    question_num_btn.appendChild(btn);
  }
}

function BtnNumberPagination(page) {
  let btn__side = document.createElement("div");
  btn__side.className = "question__number";
  btn__side.setAttribute("id-question", page);
  btn__side.innerHTML = page;

  if (current_page == page) {
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

function ButtonPagination(items, query, url) {
  SidebarStatus(current_page);
  document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
    itemOption.addEventListener("click", () => {
      SaveAnsware(query);
      let selectedQuestion = document.querySelector(
        '.question__number[id-question="' + current_page + '"]'
      );
      selectedQuestion.classList.remove("warning");
      selectedQuestion.classList.add("active");
    });
  });

  next_button.addEventListener("click", () => {
    current_page = current_page + 1;
    DisplayList(items, rows, current_page);
    NavBtnControl(current_page);
    SidebarStatus(current_page);
  });

  prev_button.addEventListener("click", () => {
    current_page = current_page - 1;
    DisplayList(items, rows, current_page);
    NavBtnControl(current_page);
  });

  notif_button.addEventListener("click", () => {
    setTimeout(() => {
      window.location.replace(url);
    }, 3000);
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
    next_button.setAttribute("style", "display:none");
    finish_button.setAttribute("style", "display:");
  } else {
    next_button.setAttribute("style", "display:");
    finish_button.setAttribute("style", "display:none");
    next_button.removeAttribute("disabled", "");
  }
}

class Timer {
  constructor(root, timer) {
    root.innerHTML = Timer.getHTML();

    this.el = {
      minutes: root.querySelector(".timer__countdown__minute"),
      seconds: root.querySelector(".timer__countdown__second"),
    };

    var UserQuizStorage = localStorage.getItem(sessionID);
    UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

    if (UserQuizStorage["time"] == null) {
      this.setTimer = timer;
    } else {
      this.setTimer = UserQuizStorage["time"];
    }

    this.interval = null;
    this.remainingSeconds = this.setTimer;
    this.updateInterfaceTime();

    if (this.interval === null) {
      this.start();
    } else {
      this.stop();
    }
  }

  updateInterfaceTime() {
    const minutes = Math.floor(this.remainingSeconds / 60);
    const seconds = this.remainingSeconds % 60;

    this.el.minutes.textContent = minutes.toString().padStart(2, "0");
    this.el.seconds.textContent = seconds.toString().padStart(2, "0");
  }

  start() {
    if (this.remainingSeconds === 0) return;

    this.interval = setInterval(() => {
      this.remainingSeconds--;
      this.updateInterfaceTime();

      var UserQuizStorage = localStorage.getItem(sessionID);
      UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};
      UserQuizStorage["time"] = this.remainingSeconds;
      localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));

      if (this.remainingSeconds === 0) {
        this.stop();
        delete UserQuizStorage.time;
        localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
      }
    }, 1000);
  }

  stop() {
    clearInterval(this.interval);
    this.interval = null;
  }

  static getHTML() {
    return `
            <i class="fa-solid fa-clock"></i>
            <span class="timer__countdown__minute">22</span>
            <span>:</span>
            <span class="timer__countdown__second">30</span>
        `;
  }
}
