const list_element = document.getElementById("question__part"),
  pagination_element = document.getElementById("pagination"),
  prev_button = document.getElementById("item_prev"),
  next_button = document.getElementById("item_next"),
  finish_button = document.getElementById("item_selesai"),
  session_notif_button = document.getElementById("item_session_notif"),
  checkpoin_button = document.getElementById("item_selesai_cekpoint"),
  notif_button = document.getElementById("notif_btn"),
  question_num_btn = document.getElementById("question__number_side");

var defaulPoint = 150;
var allTrue = 1000;

function convertToTitleCase(str) {
  let newStr = str.replace(/_/g, " "); // Replace all underscores with spaces
  return newStr.replace(/\w\S*/g, (txt) => {
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}

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
  // descText.setAttribute("style", "display: inherit;");

  label.appendChild(descLabel);
  label.appendChild(descText);

  var newline = document.createElement("br");

  var container = document.getElementById(question_id);
  container.appendChild(radiobox);
  container.appendChild(label);
  container.appendChild(newline);
}

function SaveAnsware() {
  document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
    if (itemOption.checked) {
      var UserQuizStorage = localStorage.getItem(sessionID);
      UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

      var csrfName = document
        .getElementById("txt_csrfname")
        .getAttribute("name");
      var csrfHash = document.getElementById("txt_csrfname").value;

      var new_data = itemOption.value;
      var id_soal = document
        .getElementById("question__part")
        .getAttribute("id-soal");

      const data = {};
      data["quiz_id"] = UserQuizStorage["quiz_id"];
      data[csrfName] = csrfHash;
      data["answare"] = itemOption.value;
      data["id_soal"] = id_soal;

      var xhttp = new XMLHttpRequest();
      xhttp.open(
        "POST",
        window.location.origin + "/home/save_user_answare",
        true
      );
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          var response = JSON.parse(xhttp.responseText);
          document.getElementById("txt_csrfname").value = response["value"];
          document.getElementById("txt_csrfname").name = response["name"];

          if (response.status == "Success") {
            UserQuizStorage[id_soal] = new_data;

            localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
          }
        }
      };
      xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhttp.setRequestHeader("Content-Type", "application/json");
      xhttp.send(JSON.stringify(data));
    }
  });
}

function DisplayList(items, rows_per_page, page, csrfName, csrfHash) {
  page--;
  let start = rows_per_page * page;
  let end = start + rows_per_page;
  let paginatedItems = items.slice(start, end);
  var UserQuizStorage = localStorage.getItem(sessionID);
  UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

  UserQuizStorage[csrfName] = csrfHash;
  localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));

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

    UserQuizStorage["quiz_sub_subject"] = subjectListID[getId];
    localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));

    document.getElementById("question__number").innerHTML = page + 1;
    document.getElementById("question__subject").innerHTML =
      subjectListName[getId].toUpperCase();

    if (utbk_session < utbk_session_limit) {
      if (subjectListName[getId + 1] == null) {
        let labelIndex = typeSoal
          .map((e) => e.id_main_type_soal)
          .indexOf(item.quiz_subject);

        var subjectListNameNext;
        if (labelIndex + 1 <= typeSoal.length) {
          let nextSubject = typeSoal[labelIndex + 1];
          subjectListNameNext = nextSubject.list_type_soal.split(",");
        }

        document.getElementById("next_session").innerHTML =
          subjectListNameNext[0];
      } else {
        document.getElementById("next_session").innerHTML =
          subjectListName[getId + 1];
      }
    }

    let simulation_subtitle = qSubject.slug.replace("_", " ");

    document.getElementById("question__part").innerHTML = dataSoal.soal;

    if (window.MathJax) {
      let math1 = document.querySelector("math");
      if (math1 != null) {
        let node_soal = document.querySelector("#question__part");
        MathJax.typesetPromise([node_soal]).then(() => {});
      }
    }

    document
      .getElementById("question__part")
      .setAttribute("id-soal", dataSoal.id_soal);
    document.getElementById("simulation__title").innerHTML = navbarTitle;
    document.getElementById("simulation__subtitle").innerHTML =
      convertToTitleCase(simulation_subtitle);
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

        if (window.MathJax) {
          let math = document.querySelector("math");
          if (math != null) {
            let node = document.querySelector(
              'span[id="' + itemOption.value + '"]'
            );
            MathJax.typesetPromise([node]).then(() => {});
          }
        }

        itemOption.checked = false;
        if (itemOption.value == UserQuizStorage[dataSoal.id_soal]) {
          itemOption.checked = true;
        }
      });
  }
}

function UserResult() {
  var UserQuizStorage = localStorage.getItem(sessionID);
  UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

  // let point = allTrue / 20;

  let part_1 = typeSoal.filter((obj) => {
    return obj.slug == allQuizData[0].quiz_type;
  });

  let part_2 = typeSoal.filter((obj) => {
    return obj.slug != allQuizData[0].quiz_type;
  });

  let allPart = [part_1, part_2];

  let resultData = {};
  let allPartMode = 0;
  for (let x = 0; x < allPart.length; x++) {
    // let benar = 0;
    let numberCategory = 0;
    let countResult = 0;

    if (allPart[x].length > 0) {
      for (let i = 0; i < allPart[x].length; i++) {
        let getType = allTypeSoal.find(
          ({ id_main_type_soal }) =>
            id_main_type_soal === allPart[x][i].id_main_type_soal
        );

        let splitAllType = getType["list_type_soal_id"].split(",");
        numberCategory = numberCategory + splitAllType.length;

        let soalByCategory = allQuizData.filter((obj) => {
          return obj.quiz_subject == allPart[x][i].id_main_type_soal;
        });

        for (let j = 0; j < soalByCategory.length; j++) {
          let dataSoal = dataItems.find(
            ({ id_soal }) => id_soal === soalByCategory[j].quiz_question
          );

          let getQuestNumb = allQuizQuestNumber.find(
            ({ quiz_sub_subject }) =>
              quiz_sub_subject === soalByCategory[j].quiz_sub_subject
          );

          if (dataSoal.jawaban == md5(UserQuizStorage[dataSoal.id_soal])) {
            // benar++;
            countResult += allTrue / getQuestNumb.quest_number;
          }
        }
      }
      allPartMode++;
      resultData[x] = [countResult / numberCategory];
    }
  }

  if (allPartMode > 1) {
    result =
      (resultData[0] * 40) / 100 + (resultData[1] * 60) / 100 + defaulPoint;
  } else {
    result = (resultData[1] * 100) / 100 + defaulPoint;
  }

  return result;
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

function ButtonPagination(items, url, urlRedirect, urlRanking) {
  SidebarStatus(current_page);
  document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
    itemOption.addEventListener("click", () => {
      SaveAnsware();
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
    NavBtnControl(current_page, items);
    SidebarStatus(current_page);
  });

  prev_button.addEventListener("click", () => {
    current_page = current_page - 1;
    DisplayList(items, rows, current_page);
    NavBtnControl(current_page, items);
    SidebarStatus(current_page);
  });

  notif_button.addEventListener("click", () => {
    var UserQuizStorage = localStorage.getItem(sessionID);
    UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

    if (
      UserQuizStorage["session_timeout"] == 0 ||
      UserQuizStorage["session_timeout"] == null ||
      UserQuizStorage["session_timeout"] < 0
    ) {
      UserQuizStorage["session_timeout"] = 10;
      localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
    }

    let session_timeout = UserQuizStorage["session_timeout"];
    document.getElementById("timer_session_count").innerHTML = session_timeout
      .toString()
      .padStart(2, "0");

    if (utbk_session < utbk_session_limit) {
      var UserQuizStorage = localStorage.getItem(sessionID);
      UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};
      UserQuizStorage["status_timer"] = "stop";
      localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));

      setInterval(function () {
        document.getElementById("timer_session_count").innerHTML =
          session_timeout.toString().padStart(2, "0");
        session_timeout--;
        var UserQuizStorage = localStorage.getItem(sessionID);
        UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};
        UserQuizStorage["session_timeout"] = session_timeout;
        localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
        if (session_timeout == 0) {
          delete UserQuizStorage.time;
          localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
          checkpoin_button.click();
        }
      }, 1000);
    } else {
      var UserQuizStorage = localStorage.getItem(sessionID);
      UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};
      let result = UserResult();
      var xhttp = new XMLHttpRequest();
      xhttp.open("POST", url, true);
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          var response = JSON.parse(xhttp.responseText);
          document.getElementById("txt_csrfname").value = response["value"];
          document.getElementById("txt_csrfname").name = response["name"];

          if (response.status == "Success") {
            var csrfName = document
              .getElementById("txt_csrfname")
              .getAttribute("name");
            var csrfHash = document.getElementById("txt_csrfname").value;

            var data = {};
            data["result"] = result;
            data["quiz_id"] = UserQuizStorage["quiz_id"];
            data[csrfName] = csrfHash;

            var xhttpNew = new XMLHttpRequest();
            xhttpNew.open("POST", urlRanking, true);
            xhttpNew.onreadystatechange = () => {
              if (xhttpNew.readyState == 4 && xhttpNew.status == 200) {
                var response = JSON.parse(xhttpNew.responseText);
                document.getElementById("txt_csrfname").value =
                  response["value"];
                document.getElementById("txt_csrfname").name = response["name"];

                if (response.status == "Success") {
                  setTimeout(() => {
                    window.location.replace(
                      urlRedirect + "?query=" + response.quiz_id
                    );
                  }, 3000);
                }
              }
            };
            xhttpNew.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhttpNew.setRequestHeader("Content-Type", "application/json");
            xhttpNew.send(JSON.stringify(data));
          }
        }
      };
      xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhttp.setRequestHeader("Content-Type", "application/json");
      xhttp.send(JSON.stringify(UserQuizStorage));
    }
  });

  document.querySelectorAll(".question__number").forEach((element) => {
    element.addEventListener("click", () => {
      current_page = parseInt(element.getAttribute("id-question"));
      DisplayList(items, rows, current_page);
      NavBtnControl(current_page, items);
      SidebarStatus(current_page);
    });
  });
}

function NavBtnControl(current_page, items) {
  if (current_page == 1) {
    prev_button.setAttribute("disabled", "");
  } else {
    prev_button.removeAttribute("disabled", "");
  }

  if (current_page == items.length) {
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
      UserQuizStorage["quiz_id"] = query;
      localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));

      if (UserQuizStorage["status_timer"] == "stop") {
        this.stop();
        UserQuizStorage["time"] = 0;
        localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
      }

      if (this.remainingSeconds === 0) {
        this.stop();
        localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
        notif_button.click();
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

// Save Answare Old Script
// var UserQuizStorage = localStorage.getItem(sessionID);
// UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

// document.querySelectorAll("input.form-check-input").forEach((itemOption) => {
//   if (itemOption.checked) {
//     var new_data = itemOption.value;
//     var id_soal = document
//       .getElementById("question__part")
//       .getAttribute("id-soal");

//     UserQuizStorage[id_soal] = new_data;

//     localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
//   }
// });
