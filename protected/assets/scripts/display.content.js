$(document).ready(function() {
    var oldDate = new Date().getDate();

    setInterval(function() {
        var date = new Date().getDate();
        if(date != oldDate) {
            location.reload();
        }
    }, 3600000);
});

function loadContent($e) {
    $.ajax({
        url: '/display/content/type/'+$e.data('type'),
        dataType: 'json',
        cache: false,
        success: function(data) {
            if($e.data('type') == 'time' || $e.data('type') == 'weather') {
                $e.html(data.content);
            } else {
                $e.fadeOut(function() {
                    $e.html(data.content).fadeIn();
                    if($e.data('type') == 'text') {
                        $e.css({top:0});
                        if($e.height() > $e.parent().height()) {
                            setTimeout(function() {
                                $e.animate({
                                    top: - $e.height() + $e.parent().height()
                                }, data.duration*1000-4);
                            }, data.duration*1000 - (data.duration*1000-2));
                        }
                    }
                })
            }
            setTimeout(function(){loadContent($e)}, data.duration*1000);
        },
        error: function() {
            // retry in 5 seconds
            setTimeout(function(){loadContent($e)}, 5000);
        }
    });
}

function startClock(time, date) {
    $.ajax({
        url: '/display/content/type/time',
        dataType: 'text',
        cache: false,
        success: function($time) {
            var offset = new Date().getTime() - $time;
            var tick = setInterval(function() {
                var d = new Date();
                d.setTime(d.getTime() - offset);

                time.html(d.toLocaleTimeString());
                date.html(d.toLocaleDateString());
            }, 200);
            setTimeout(function() {
                clearInterval(tick);
                startClock(time, date);
            },3600000);
        }
    });
}