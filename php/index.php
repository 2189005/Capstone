<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="fullcalendar/fullcalendar.min.css" />
<script src="fullcalendar/lib/jquery.min.js"></script>
<script src="fullcalendar/lib/moment.min.js"></script>
<script src="fullcalendar/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/ko.js"></script> 

<script>
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "fetch-event.php",
        displayEventTime: false,
        locale: 'ko',
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('일정 추가:');

            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: 'add-event.php',
                    data: 'title=' + title + '&start=' + start + '&end=' + end,
                    type: "POST",
                    success: function (data) {
                        displayMessage("추가되었습니다.");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },

        editable: true,
        eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: 'edit-event.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (response) {
                            displayMessage("Updated Successfully");
                        }
                    });
                },
        eventClick: function (event) {
            var deleteMsg = confirm("일정을 삭제 하시겠습니까?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "delete-event.php",
                    data: "&id=" + event.id,
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        }

    });
});

function displayMessage(message) {
    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>

<style>
body {
    background-image: url('image\bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    /* 추가적인 스타일링 속성을 적용할 수 있습니다 */
}

body {
    margin-top: 50px;
    text-align: center;
    font-size: 14px;
    font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
    
}

#calendar {
    width: 700px;
    margin: 0 auto;
    background-color: #FFFFFF;
}

.response {
    height: 60px;
}

.success {
    background: #00FFAD;
    padding: 10px 60px;
    border: #00D18B 1px solid;
    display: inline-block;
    font-size: 16px;
}
</style>
</head>
<body>
    <h2>캡스톤 달력</h2>

    <div class="response"></div>
    <div id='calendar'></div>
</body>


</html>