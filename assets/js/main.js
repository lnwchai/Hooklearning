document.addEventListener("DOMContentLoaded", function () {
    var surveyModal = document.getElementById('survey-modal');
    if (surveyModal) surveyModal.classList.add('show');
});

document.addEventListener("click", function (event) {
    if (event.target.matches(".btn-complete-lesson")) {
        completeLesson(event.target);
    }
    if (event.target.matches(".btn-answer-question")) {
        submitAnswers(event.target);
    }
    if (event.target.closest(".button-download")) {
        var captureEl = document.querySelector(".cert-iamge");
        if (captureEl) {
            event.preventDefault();
            doCapture();
        }
        return;
    }
    if (event.target.matches(".btn-close-modal")) {
        closeModal(event.target);
    }
    if (event.target.closest(".s-modal-survey-bg")) {
        closeSurveyModal();
    }

    if(event.target.matches(".nav-toggle")) {
        var avatar = document.querySelector('.s-account-login__avatar img');
        if(event.target.classList.contains('active')){
            avatar.style.display = 'none';
        }else{
            avatar.style.display = 'block';
        }
    }

    if (event.target.closest('.edit-name')) {
        document.querySelector('.form-edit-name').style.display = 'block';
    }
    if (event.target.closest('.edit-users .clsoe')) {
        document.querySelector('.form-edit-name').style.display = 'none';
    }
});

document.addEventListener('submit', function(e){
    if (e.target.closest('.edit-users')) {
        e.preventDefault();

        var data = e.target.elements;
        var params = 'action='+data.action.value+'&fname='+data.firstname.value+'&lname='+data.lastname.value;
        var ajaxXhttp = new XMLHttpRequest();

        ajaxXhttp.open("POST", "/wp-admin/admin-ajax.php", true);
        ajaxXhttp.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded;"
        );
        ajaxXhttp.onload = function () {
            if (this.status >= 200 && this.status < 400) {
                alert('แก้ไขชื่อ-นามสกุลเสร็จสิ้น');
                location.reload();
            } else {
                alert('error ' + this.status);
            }
        };
        ajaxXhttp.send(params);
    }
});

function completeLesson(btn) {
    let lesson_id = btn.dataset.lesson;
    let course_id = btn.dataset.course;
    let nonce = btn.dataset.nonce;
    let params = `action=complete_lesson_action&nonce=${nonce}&lesson_id=${lesson_id}&course_id=${course_id}`;
    ajaxXhttp = new XMLHttpRequest();
    ajaxXhttp.open("POST", "/wp-admin/admin-ajax.php", true);
    ajaxXhttp.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded;"
    );
    ajaxXhttp.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            // Success!
            try {
                var resp = JSON.parse(this.response);
                if (resp.status == 'completed') {
                    alert("Lesson completed");
                }
                else if (resp.status == 'next') {
                    // Redirect to next lesson
                    window.location.href = resp.next_lesson_url;
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                alert("Error processing response");
            }
        } else {
            // We reached our target server, but it returned an error
            console.error('HTTP Error:', this.status, this.response);
            alert("Error: " + this.status);
        }
    };
    ajaxXhttp.send(params);
}

function submitAnswers(btn) {
    let lesson_id = btn.dataset.lesson;
    let nonce = btn.dataset.nonce;
    let questions = document.querySelectorAll('.question');

    if (validateAnswer(questions)) {
        alert('กรุณาตอบคำถามให้ครบทุกข้อ');
        return;
    }

    let answers = getQuestionAnswer(questions);
    answers = JSON.stringify(answers);

    disabledAnswer(questions);

    let params = `action=question_answer&nonce=${nonce}&lesson_id=${lesson_id}&data=${answers}`;
    ajaxXhttp = new XMLHttpRequest();
    ajaxXhttp.open("POST", "/wp-admin/admin-ajax.php", true);
    ajaxXhttp.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded;"
    );
    ajaxXhttp.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            var resp = this.response;
            resp = JSON.parse(resp);
            showModal();
        } else {
            alert("error");
        }
    };
    ajaxXhttp.send(params);
}

function validateAnswer(questions) {
    let invalid = false;
    questions.forEach((item) => {
        let type = item.dataset.type;
        var answer;
        if (type == 'text') {
            if (item.querySelector('textarea') && item.querySelector('textarea').value != '') {
                answer = item.querySelector('textarea');
            }
        }
        else if (type == 'choice') {
            answer = item.querySelector('input[type=radio]:checked');
        }
        if (answer) {
            item.classList.remove('invalid');
        }
        else {
            item.classList.add('invalid');
            invalid = true;
        }
    });
    return invalid;
}

function disabledAnswer(questions) {
    questions.forEach((item) => {
        let type = item.dataset.type;
        var answer;
        if (type == 'text') {
            answer = item.querySelector('textarea');
            answer.disabled = true;
        }
        else if (type == 'choice') {
            answer = item.querySelectorAll('input[type=radio]').forEach((radio) => {
                radio.disabled = true;
            });
        }
    });
}

function getQuestionAnswer(questions) {
    const question_answers = [];
    questions.forEach((item) => {
        let type = item.dataset.type;
        console.log(type);
        let question = item.querySelector('.question-title');
        var answer;
        if (type == 'text') {
            answer = item.querySelector('textarea');
        }
        else if (type == 'choice') {
            answer = item.querySelector('input[type=radio]:checked');
        }
        let question_answer = {
            question: question ? question.innerText : '',
            answer: answer ? answer.value : ''
        };
        question_answers.push(question_answer);
    });
    return question_answers;
}

function showModal() {
    if (document.querySelector('.s-modal-alert')) {
        document.querySelector('.s-modal-alert').classList.add('show');
    }
    if (document.querySelector('.s-modal-bg')) {
        document.querySelector('.s-modal-bg').classList.add('show');
    }
}

function closeModal(target) {
    var surveyWrap = target && target.closest ? target.closest('.s-modal-survey-wrap') : null;
    if (surveyWrap) {
        closeSurveyModal();
        return;
    }
    if (document.querySelector('.s-modal-alert')) {
        document.querySelector('.s-modal-alert').classList.remove('show');
    }
    if (document.querySelector('.s-modal-bg')) {
        document.querySelector('.s-modal-bg').classList.remove('show');
    }
}

function showSurveyModal() {
    var wrap = document.getElementById('survey-modal');
    if (wrap) wrap.classList.add('show');
}

function closeSurveyModal() {
    var wrap = document.getElementById('survey-modal');
    if (wrap) wrap.classList.remove('show');
}

function doCapture() {
    var el = document.querySelector('.cert-iamge');
    if (!el) return;
    var sc;
    if( window.innerWidth <= 480 ){
        sc = 5;
    }else if( window.innerWidth > 480 && window.innerWidth <= 992 ){
        sc = 3;
    }else{
        sc = 2;
    }
    html2canvas(el,
    { scale: sc }).then(function (canvas) {
        fetch(hookRest.apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': hookRest.nonce,
            },
            body: JSON.stringify({
                image: canvas.toDataURL("image/jpeg", 1.0),
            }),
        })
        .then(function (res) {
            if (res.ok) {
                return res.json();
            }
            throw new Error('Request failed: ' + res.status);
        })
        .then(function (url) {
            downloadImage(url);
        })
        .catch(function (err) {
            console.error(err);
        });
    });
}

function downloadImage(url) {
    fetch(url, {
      mode : 'no-cors',
    })
      .then(response => response.blob())
      .then(blob => {
      let blobUrl = window.URL.createObjectURL(blob);
      let a = document.createElement('a');
      a.download = url.replace(/^.*[\\\/]/, '');
      a.href = blobUrl;
      document.body.appendChild(a);
      a.click();
      a.remove();
    })
  }





