(function($){
    $(document).ready(function (){
        getIp($('#form_ip'));
    });

    $(document).on('click', '#form_get_ip', function () {
        getIp($('#form_ip'));
        return false;
    });

    $(document).on('click', '#form_get_location', function () {
        getLocation($('#form_ip').val(), $('#form_location'));
        return false;
    });

})(jQuery);

function getIp(element) {
    $.ajax({
        type: 'POST',
        url: '/ajax/ip',
        data: {},
        beforeSend: function () {
            element.val('Loading...');
        },
        success: function (data) {
            element.val(data.ip);
        },
        error: function () {
            element.val('Error');
        }
    });
}

function getLocation(ip, element) {
    $.ajax({
        type: 'POST',
        url: '/ajax/location',
        data: {
            ip: ip
        },
        beforeSend: function () {
            element.val('Loading...');
        },
        success: function (data) {
            element.val(data.country + ' ' + data.city);
        },
        error: function () {
            element.val('Error');
        }
    });
}