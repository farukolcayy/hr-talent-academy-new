$(document).foundation()

var topBarLeft = document.getElementById("topBarLeft"),
    topBarRight = document.getElementById("topBarRight"),
    total = document.getElementById("total");

var welcome = document.getElementById("welcome");
var message = document.getElementById("message");
var results = document.getElementById("results");
var timeIsEnd = false;
var startButton = document.getElementById("startButton"),
    quizContainer = document.getElementById("quizContainer"),
    quizNotify = document.getElementById("quizNotify"),
    quizLength = 0,
    choices = [],
    index = 0,
    formContainer = document.getElementById("formContainer"),
    form = document.form1,
    warning = document.getElementById("warning");

var allQuestions = [];
var storedAnswers = [];
// var storedScores = [];
var startQuizTime = "";

var quizButtons = document.getElementById("quizButtons"),
    prevButton = document.getElementById("prevButton"),
    next = document.getElementById("next"),
    nextButton = document.getElementById("nextButton"),
    questionLabelArea = document.getElementById("questionLabelArea"),
    scoreButton = document.getElementById("scoreButton");

// var scoreDisplay = document.getElementById("scoreDisplay"),
//     myScores = document.getElementById("myScores");
var checkEmail = "";
var progressBar = document.getElementById("progressBar");
var progressMeter = document.getElementById("progressMeter");
var progressMeterText = document.getElementById("progressMeterText");
//quizButtons.classList.add("hide");
//scoreDisplay.setAttribute("style", "display:visible");

startButton.addEventListener("click", startQuiz);
// myScores.addEventListener("click", showUserScores);
prevButton.addEventListener("click", previousQuestion);
nextButton.addEventListener("click", nextQuestion);
scoreButton.addEventListener("click", showScore);

var isFinishExam = false;
var isEmptyQuestion = false;
//shows welcome message and startbutton
quizContainer.classList.remove("hide");
// three parts of quizContainer:
quizNotify.classList.remove("hide");
formContainer.classList.add("hide");
quizButtons.classList.add("hide");
progressBar.classList.add("hide");
progressBar.setAttribute("aria-valuemax", quizLength);

message.insertAdjacentHTML("beforeend", `Bu sınav Genel Yetenek,İnsan Kaynakları ve İngilizce<br>olmak üzere toplam <span style="color:red;">30</span> sorudan oluşmaktadır.<br><br>Genel Yetenek Toplam Soru: <span style="color:red;">10</span><br>İnsan Kaynakları Toplam Soru: <span style="color:red;">10</span><br>İngilizce Toplam Soru: <span style="color:red;">10</span><br><br><span style="color:#FFC107"><br><div style="text-align:left;">📍 Sınav süresince kağıt kalem kullanmanız önerilir<br>📍 Sınav süreniz <span style="color:red;">35</span> dakikadır<br>📍 Sınava girdikten sonra çıkış yapma durumunda sınava tekrar devam edemeyeceksiniz</span></div>`);
startButton.setAttribute("style", "display:visible");

$("#questionLabelArea input[type=text]").click(function () {
    $("#questionLabel" + (index + 1)).css("border", "1px solid gray");
    index = $(this).attr('id').substring(13) - 1;
    $("#questionLabel" + (index + 1)).css("border", "2px solid red");
    progressMeterText.innerHTML = quizLength + ' soru içerisinden ' + (index + 1) + '. sorudasınız ';

    if (index >= 0 && index <= 9) {
        $("#quizTypeText").hide().html("Genel Yetenek Testi").fadeIn('slow');
    }
    if (index >= 10 && index <= 19) {
        $("#quizTypeText").hide().html("İnsan Kaynakları Testi").fadeIn('slow');
    }
    if (index >= 20 && index <= 29) {
        $("#quizTypeText").hide().html("İngilizce Testi").fadeIn('slow');
    }

    showQuestion();

});

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        path = "/online-sinav";
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=' + path + ";";
    }
}

function startQuiz() {

    fillAnswersStored();

    $('#ftco-loader').addClass('show');
    setTimeout(function () {
        $('#ftco-loader').removeClass('show');
    }, 1000);

    startQuizTime = new Date();
    checkEmail = readCookie("applyEmailHR");
    deleteAllCookies();

    $.ajax({
        type: 'POST',
        url: 'changeStateUser.php',
        data: { email: checkEmail } // getting filed value in serialize form
    })
        .done(function (data) { // if getting done then call.

        })
        .fail(function (xhr, textStatus, errorThrown) { // if fail then getting message
            console.log(xhr.responseText);
            console.log(textStatus);
            console.log(errorThrown);
        });

    $("#quizTypeText").hide().html("Genel Yetenek Testi").fadeIn('slow');
    $("#timeRemainingText").hide().html("Kalan sınav süresi:").fadeIn('slow');
    $("#questionLabelArea").css('visibility', 'visible');

    index = 0;
    quizNotify.classList.add("hide");
    quizButtons.classList.remove("hide");
    progressBar.classList.remove("hide");

    quizLength = allQuestions.length;
    showProgress(index);
    showQuestion();

    // $('#hms_timer').countdowntimer({
    //     displayFormat: "MS",
    //     borderColor: "#f82249",
    //     fontColor: "#FFFFFF",
    //     backgroundColor: "#212121",
    //     labelsFormat: true,
    //     minutes: 02,
    //     seconds: 00,
    //     timeZone: +3,
    //     size: "sm",
    //     timeUp: timeIsUp
    // });

    $(".digits").countdown({
        image: "img/digits.png",
        stepTime: 60,
        format: "mm:ss",
        startTime: "35:00",
        timerEnd: function () { timeIsUp(); }
    });

}

function timeIsUp() {
    timeIsEnd = true;
    alert("Süre Bitti");
    showScore();
}

function showQuestion() {
    showQuizButtons();
    if (index === quizLength) {
        return;
    }
    // display of question at given index:
    formContainer.classList.remove("hide")
    form.innerHTML = "";
    var quizItem = allQuestions[index];
    var q = document.createElement("h3");
    // var text = document.createTextNode(quizItem[2]);
    var storedAnswer = storedAnswers[index];

    if (quizItem[4] !== null && quizItem[4] !== "") {
        q.insertAdjacentHTML("beforeend", `<img src="data:image;base64,${quizItem[4]}"><br>${quizItem[2]}`);
    } else {
        q.insertAdjacentHTML("beforeend", `${quizItem[2]}`);
    }
    form.appendChild(q);

    // display of choices, belonging to the questions at given index:
    console.log(allQuestions[index][3]);
    var arr = JSON.parse("[" + allQuestions[index][3] + "]");
    choices = arr[0];
    if (quizItem[3] === null || quizItem[3] === "") {
        var _choicesImage = [`<img src="data:image;base64,${quizItem[5]}">`, `<img src="data:image;base64,${quizItem[6]}">`, `<img src="data:image;base64,${quizItem[7]}">`, `<img src="data:image;base64,${quizItem[8]}">`, `<img src="data:image;base64,${quizItem[9]}">`];
        choices = _choicesImage;
    }
    for (var i = 0; i < choices.length; i++) {
        var div = document.createElement("div");
        div.classList.add("radio");

        var input = document.createElement("input");
        input.setAttribute("id", i);
        input.setAttribute("type", "radio");
        input.setAttribute("name", "radio");
        input.setAttribute("data-id", quizItem[0]);

        // if (i === parseInt(quizItem[10])) {
        //     input.setAttribute("value", "1");
        // } else {
        //     input.setAttribute("value", "0");
        // }
        //if question has been answered already
        if (storedAnswer) {
            var id = storedAnswer.id;
            if (i == id) {
                // if question is already answered, id has a value
                input.setAttribute("checked", "checked");
            }
        }

        //if radiobutton is clicked, the chosen answer is stored in array storedAnswers
        input.addEventListener("click", storeAnswer);

        var label = document.createElement("label");
        label.setAttribute("class", "radio-label");
        label.setAttribute("for", i);
        // var choice = document.createTextNode(choices[i]);
        label.insertAdjacentHTML("beforeend", `${choices[i]}`);

        div.appendChild(input);
        div.appendChild(label);

        form.appendChild(div);
        if (quizItem[3] === null || quizItem[3] === "") {
            $('.radio').css('float', 'left');
        }
    }


}

function showProgress(index) {
    ///update progress bar
    if (index >= quizLength) {
        return;
    }
    var increment = Math.ceil((index) / (quizLength) * 100);
    // var increment = index;
    progressMeter.style.width = (increment) + '%';
    progressMeterText.innerHTML = quizLength + ' soru içerisinden ' + (index + 1) + '. sorudasınız ';
    if (index === 0) {
        progressMeter.style.width = (25) + '%';
        progressMeter.style.background = "#ffffff";
        //progressMeterText.style.color = "000000";
    } else {
        progressMeter.style.background = "#FFC107";
    }

}

function storeAnswer(e) {
    var element = e.target;

    var answer = {
        id: element.id,
        value: element.value,
        questionId: allQuestions[index][0]
    };
    storedAnswers[index] = answer;
}

function showQuizButtons() {
    if (index === 0) {
        //there is no previous question when first question is shown
        prevButton.classList.add("hide");
    }
    if (index > 0) {
        prevButton.classList.remove("hide");
    }
    if (index === quizLength) {
        //only if last question is shown user can see the score
        // scoreButton.classList.remove("hide");
        nextButton.classList.add("hide");
        //prevButton still visible so user can go back and change answers
        var h2 = document.createElement("h2");
        h2.insertAdjacentHTML("beforeend", `Hepsi bu!<br> Sınavı bitirmek için Bitir butonuna tıklamanız gerekiyor.`);
        form.appendChild(h2);
        progressMeterText.innerHTML = "Tüm soruları tamamladınız.";
        // index--;
        // showProgress(index);
    } else {
        nextButton.classList.remove("hide");
        // scoreButton.classList.add("hide");
    }
}

function previousQuestion() {
    //shows previous question, with chosen answer checked
    index--;
    $("#questionLabel" + (index + 1)).css("border", "2px solid red");
    $("#questionLabel" + (index + 2)).css("border", "1px solid gray");

    if (storedAnswers[index].id == "null") {
        $("#questionLabel" + (index + 1)).css("background-color", "gray");
        $("#questionLabel" + (index + 1)).css("color", "white");
    } else {
        $("#questionLabel" + (index + 1)).css("background-color", "#FFC107");
        $("#questionLabel" + (index + 1)).css("color", "black");
    }

    warning.innerHTML = "";
    form.innerHTML = "";
    $("#form1").fadeOut(0, function () {
        var show = showQuestion();
        $(this).attr('innerHTML', 'show').fadeIn(300);
    });

    showProgress(index);

    if (index === 9) {
        $("#quizTypeText").hide().html("Genel Yetenek Testi").fadeIn('slow');
    }
    if (index === 19) {
        $("#quizTypeText").hide().html("İnsan Kaynakları Testi").fadeIn('slow');
    }
    if (index === 29) {
        $("#quizTypeText").hide().html("İngilizce Testi").fadeIn('slow');
    }

}

function nextQuestion() {
    //shows next question only if current question has been answered
    if (storedAnswers[index].id == "null") {
        $("#questionLabel" + (index + 1)).css("background-color", "gray");
        $("#questionLabel" + (index + 1)).css("color", "white");
    } else {
        $("#questionLabel" + (index + 1)).css("background-color", "#FFC107");
        $("#questionLabel" + (index + 1)).css("color", "black");
    }

    index++;
    $("#questionLabel" + (index + 1)).css("border", "2px solid red");
    $("#questionLabel" + (index)).css("border", "1px solid gray");
    warning.innerHTML = "";
    form.innerHTML = "";
    $("#form1").fadeOut(0, function () {
        var show = showQuestion();
        $(this).attr('innerHTML', 'show').fadeIn(300);
    });
    showProgress(index);

    if (index === 10) {
        $("#quizTypeText").hide().html("İnsan Kaynakları Testi").fadeIn('slow');
    }
    if (index === 20) {
        $("#quizTypeText").hide().html("İngilizce Testi").fadeIn('slow');
    }
}

function showScore() {

    if (isFinishExam == false && timeIsEnd == false) {
        for (let i = 0; i < storedAnswers.length; i++) {
            if (storedAnswers[i].id == "null") {
                isEmptyQuestion = true;
                getDialog("Boş bıraktığınız sorular mevcut. Sınavı bitirmek istiyor musunuz?");
                break;
            }
        }
        if (isEmptyQuestion == false) {
            getDialog("Sınavınız sonlandıralacaktır. Onaylıyor musunuz?");
        }
    } else {

        form.innerHTML = "";
        prevButton.classList.add("hide");
        nextButton.classList.add("hide");
        scoreButton.classList.add("hide");
        progressBar.classList.add("hide");
        progressMeterText.classList.add("hide");
        quizNotify.classList.remove("hide");
        startButton.classList.add("hide");
        questionLabelArea.classList.add("hide");

        var totalScore = 0;

        var output = "";
        var questionResult = "NA";

        for (var i = 0; i < storedAnswers.length; i++) {
            var score = parseInt(storedAnswers[i].id);
            if (score === parseInt(allQuestions[i][10])) {
                questionResult = '<i class="fi-check green"></i>';
                totalScore += 1;
            } else {
                questionResult = '<i class="fi-x red"></i>';
            }
            output = output + '<p>Soru ' + (i + 1) + ': ' + questionResult + '</p> ';
        }

        message.innerHTML = "";
        if (timeIsEnd === false) {
            message.insertAdjacentHTML("beforeend", `<span style="color:#37b500;">Sınavı başarıyla tamamladınız!<br>Sonuçlarınız sisteme kaydedildi.</span>`);
            $("#success-icon").fadeIn('slow');
        } else {
            message.insertAdjacentHTML("beforeend", `<span style="color:#37b500;">Süreniz bitti!<br>Sonuçlarınız sisteme kaydedildi.</span>`);
            $("#success-icon").fadeIn('slow');
        }

        $("#quizTypeText").hide();
        $("#timeRemainingText").hide();

        // $('#hms_timer').countdowntimer("destroy");
        $('.digits').hide();

        var endQuizTime = new Date();

        var diff = endQuizTime - startQuizTime;
        var diffSeconds = Math.floor(diff / 1000);

        var resultAnswers = JSON.stringify(storedAnswers);
        $.ajax({
            type: 'POST',
            url: 'saveResult.php',
            data: { email: checkEmail, answers: resultAnswers, scoreTotal: totalScore, scoreTime: diffSeconds } // getting filed value in serialize form
        })
            .done(function (data) { // if getting done then call.

            })
            .fail(function (xhr, textStatus, errorThrown) { // if fail then getting message
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            });

        // storedScores.push(totalScore);
        // updateScore(totalScore);
        // setTimeout(function () {
        //     window.location.href = 'https://hrtalent.academy/';
        // }, 3000);


    }

}

function fillAnswersStored() {
    var _answer = {
        id: "null",
        value: "off",
        questionId: "null"
    };
    for (let i = 0; i < 30; i++) {
        storedAnswers[i] = _answer;
    }
}

function getDialog(text) {
    $.confirm({
        title: 'Uyarı!',
        content: text,
        columnClass: 'col-md-4 col-md-offset-4',
        buttons: {
            tamam: function () {
                isFinishExam = true;
                isEmptyQuestion = false;
                showScore();
            },
            iptal: function () {
                isEmptyQuestion = false;
                return;
            }
        }
    });

}