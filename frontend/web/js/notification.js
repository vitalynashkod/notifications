Notification = {
    init: function (userId) {
        var conn = new WebSocket('ws://localhost:8080');
        conn.onmessage = function (e) {

           var data = $.parseJSON(e.data);

            $.toast({
                heading: data.title,
                text: data.text,
                icon: data.type,
                loader: true,
                loaderBg: '#9EC600'
            })
        };
        conn.onopen = function (e) {
            conn.send(userId);
        };
    }
};