var iframe = document.querySelector('#lesson-video');
var lessonTime = document.querySelector('.lesson-current-time');
var lessonId = document.querySelector('.lesson-id');

if(iframe != null && lessonId != null){
    var player = new Vimeo.Player(iframe);
    // Set current video time.
    window.onload = () => {
        player.setCurrentTime(parseFloat(lessonTime.value));
    };

    // On play action.
    player.on('play', function() {
        player.getCurrentTime().then(function (duration) {
            lessonTime.value = duration;
            update_lesson_time(lessonId.value, duration);
            setTimeout(() => {
                player.setCurrentTime(parseFloat(duration));
            }, 500);
        }).catch(function (error) {});
    });

    // On pause action.
    player.on('pause', function() {
        player.getCurrentTime().then(function (duration) {
            lessonTime.value = duration;
            update_lesson_time(lessonId.value, duration);
        }).catch(function (error) {});
    });

    // On ended action.
    player.on('ended', function() {
        player.getCurrentTime().then(function (duration) {
            lessonTime.value = duration;
            update_lesson_time(lessonId.value, duration);
        }).catch(function (error) {});

        complete_lesson_actions();
    });

    // On time update with play video.
    var timeUpdate = setInterval(() => {
        player.getCurrentTime().then(function (duration) {
            lessonTime.value = duration;
            update_lesson_time(lessonId.value, duration);
        }).catch(function (error) {});

        player.getDuration().then(function(duration) {
            var persent = (duration / 100) * 80;
            if( parseFloat(lessonTime.value) >= persent ){
                complete_lesson_action_not_end();
            }
        }).catch(function(error) {});
    }, 5000);
}

// Action forn update lesson time.
function update_lesson_time( pid = 0, time = 0 ){
    var params, ajaxRequest;
    params = 'action=hook_lesson_time_update&pid='+pid+'&time='+time;
    
    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open('POST', '/wp-admin/admin-ajax.php', true);
    ajaxRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
    ajaxRequest.onload = function () {
      if (this.status >= 200 && this.status < 400) {
        console.log('Update time success.');
      } else {
        alert('error ' + this.status);
      }
    };
    ajaxRequest.send(params);
}

// Action complete lesson.
function complete_lesson_actions(){
    var lessonID = document.querySelector('.ls-lesson-id');
    var courseID = document.querySelector('.ls-course-id');
    var nonce = document.querySelector('.ls-nonce-complete');
    if( lessonID != null && courseID != null ){
        var params = 'action=complete_lesson_action&lesson_id='+lessonID.value+'&course_id='+courseID.value;
        if( nonce != null ){
            params += '&nonce='+nonce.value;
        }
        var ajaxXhttp = new XMLHttpRequest();

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
                    if (resp.status == 'next') {
                        if( resp.next_lesson_url != false ){
                            window.location.href = resp.next_lesson_url;
                        }
                    } 
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert("Error processing response");
                }
            } else {
                console.error('HTTP Error:', this.status, this.response);
                alert('error ' + this.status);
            }
        };
        ajaxXhttp.send(params);
    }
}

// Action complate lesson not end video.
function complete_lesson_action_not_end() {
    var lessonID = document.querySelector('.ls-lesson-id');
    var courseID = document.querySelector('.ls-course-id');
    var nonce = document.querySelector('.ls-nonce-complete-not-end');
    if( lessonID != null && courseID != null ){
        var params = 'action=complete_lesson_action_not_end&lesson_id='+lessonID.value+'&course_id='+courseID.value;
        if( nonce != null ){
            params += '&nonce='+nonce.value;
        }
        var ajaxXhttp = new XMLHttpRequest();

        ajaxXhttp.open("POST", "/wp-admin/admin-ajax.php", true);
        ajaxXhttp.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded;"
        );
        ajaxXhttp.onload = function () {
            if (this.status >= 200 && this.status < 400) {
                document.querySelector('.les-'+lessonID.value+' a').innerHTML = this.response;
            } else {
                alert('error ' + this.status);
            }
        };
        ajaxXhttp.send(params);
    }
}

// Check Cookie 
var bodyClass = document.querySelector('.single-course');
if( bodyClass != null ){
    var popupElm = document.querySelector('.popup-for-login');
    var closePopup = document.querySelector('.popup-for-login .lerning');
    var loginPopup = document.querySelector('.popup-for-login .login');

    if( popupElm != null ){
        window.onload = () => {
            const alertLogin = getCookie('course-popup');
            if( alertLogin == '' ){
                popupElm.style.display = 'block';
            }    
        };
    }

    if( closePopup != null && loginPopup != null ){
        closePopup.addEventListener('click', function(){
            setCookie('course-popup','alert', 1);
            popupElm.style.display = 'none';
        });

        loginPopup.addEventListener('click', function(){
            setCookie('course-popup','alert', 1);
            popupElm.style.display = 'none';
        });
    }
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}