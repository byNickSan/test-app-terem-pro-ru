var ddres = undefined;
$( document ).ready(function() {
    var jsonres = $('#jsonres');
    var dd = {
        1: $('.dropdown-toggle[data-id=1]'),
        2: $('.dropdown-toggle[data-id=2]'),
        3: $('.dropdown-toggle[data-id=3]'),
        4: $('.dropdown-toggle[data-id=4]'),
        5: $('.dropdown-toggle[data-id=5]'),
    };
    $('.dropdown-toggle').dropdown('update').on('show.bs.dropdown', function () {
        let o = $(this);
        let id = o.data('id');
        for (var i = 1; i < 6; i++) {
            if(i !== id){
                if(dd[i].is('.show')) {
                    console.log('dd#' + i + ' hidden');
                    dd[i].dropdown('hide');
                }
            }
        }
        // do something…
    });
    $(window).click(function(e) {
        if(typeof ddres == "undefined"){
            ddres = {
                1: null,
                2: null,
                3: null,
                4: null,
                5: null,
            };
        }
        let t = e.target;
        if (!t.classList.contains("dropdown-toggle")) {
            for (var i = 1; i < 6; i++) {
                if(dd[i].is('.show')) {
                    console.log('wdd#' + i + ' hidden');
                    dd[i].dropdown('hide');
                }
            }
        }
        if (t.classList.contains("dropdown-item")) {
            let o = $(e.target);
            let btn = o.closest('.btn-group').children('button');
            let id = btn.data('id');
            let value = parseInt(o.text());
            if(Number.isInteger(id)){
                if(ddres[id] === null){
                    console.log(ddres[id]);
                    btn.removeClass('btn-secondary').addClass('btn-primary');
                }
                ddres[id] = value;
            }else{
                console.warn('not int',id)
                console.log('value ',value);
            }
            jsonres.val(JSON.stringify(ddres))
        }
    });
    var sendDat = $('#senddata');
    sendDat.on('click',function(e){
        sendDat.addClass('disabled').removeClass('btn-success').addClass('btn-secondary');
        e.preventDefault();
        $.ajax({
            type: "GET",
            async : true,
            dataType: "json",
            url: 'json.php',
            data: {
                json: JSON.stringify(ddres)
            },
            cache: false,
            success: function(g) {
                console.log('ok',g);
                alert('Ок');
                sendDat.removeClass('disabled').removeClass('btn-secondary').addClass('btn-success');
            },
            error: function(e) {
                console.log('fail',e);
                alert('Ошибка');
                sendDat.removeClass('disabled').removeClass('btn-secondary').addClass('btn-danger');
            }
        });
    })
});