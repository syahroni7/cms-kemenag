<script src="{{ asset('jquery/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('niceadmin/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('niceadmin/js/main.js') }}"></script>

<script src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/messages_id.min.js') }}"></script>

<!-- script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></!-->

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"
    integrity="sha384-6SeGLRU4YdxJtUdzbf6ZrJXB7zQo5MDZH2qvjYgRnM8xNsIHDA0AStDnkhHOmIfY"
    crossorigin="anonymous"></script>



<script>
    $(document).ready(function() {
        fetchNotif();
        fetchSummary();
    });

    if (window.self == window.top) {
        window.dataLayer = window.dataLayer || [];
    }

    // if (!(typeof io === "undefined")) {
    const socket = io('wss://socket.ptspkemenaglebak.my.id/', {
        forceNew: true,
        transports: ["polling"]
    });
    // }

    // if (!(typeof socket === "undefined")) {
    socket.on('connection');

    socket.on('sendSummaryToClient', (data) => {
        console.log(data);
        $.each(data, function(i, item) {
            var status = item.status_pelayanan;
            $('.total-' + status).html(item.total);
        });
    });



    // }

    fetchNotif();


    function fetchNotif() {
        $.ajax({
            url: "/notifications/fetch",
            type: 'GET',
            success: function(res) {
                console.log(res);
                $('.notifications').empty();
                $(res.html).appendTo('.notifications')

                $('.total-notifikasi').html(res.total_notifikasi)
            }
        });
    }

    function fetchSummary() {
        $.ajax({
            url: "/summary/fetch",
            type: 'GET',
            success: function(data) {
                console.log('data summary/fetch');
                console.log(data);
                var totalSemua = 0;
                $.each(data.summary, function(i, item) {
                    var status = item.status_pelayanan;
                    var param = '.total-' + status;
                    $('.total-' + status).html(item.total);

                    totalSemua += parseInt(item.total);

                });

                $('.total-Semua').html(totalSemua);

                $('.total-disposisi').html(data.disposisi);

            }
        });
    }

    if (!(typeof table === "undefined")) {

        table.on('error.dt', function(e, settings, techNote, message) {
            window.location.href = "/login";
            console.log('woilah');
        });
        console.log('woilah');
    }
</script>

<script>
    (function() {
        var s = document.createElement("script");
        s.setAttribute("data-account", "P5e16SfPdW");
        s.setAttribute("src", "https://cdn.userway.org/widget.js");
        document.body.appendChild(s);
    })();
</script><noscript>Enable JavaScript to ensure <a href="https://userway.org">website accessibility</a></noscript>