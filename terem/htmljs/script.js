$( document ).ready(function(){
    var bt1 = $("#btn-terem1");
    var bt1_status = true;
    var b1AnimaAccess = true;
    var h1 = $("#h1-terem");

    var bt2 = $("#btn-terem2");
    var swapBlockLeft = $('.terem>.bgblock2');
    var swapBlockCentr = $('.terem>.bgblock3');
    var swapped = false;

    bt1.on('click',function (e) {
        e.preventDefault();
        if(b1AnimaAccess) {
            b1AnimaAccess = false;
            bt1.addClass('disabled');
            if (bt1_status == true) {
                bt1_status = false;
                h1.fadeOut("slow", function () {
                    bt1.removeClass('disabled');
                    b1AnimaAccess = true;
                });
            } else {
                h1.fadeIn("slow", function () {
                    bt1_status = true;
                    bt1.removeClass('disabled');
                    b1AnimaAccess = true;
                });
            }
        }
    });

    bt2.on('click',function(e){
        e.preventDefault();
        var $el, $row;
        $el = $(this);
        $row = $el.parents('.row');

        if(!swapped) {
            swapBlockCentr.insertBefore(swapBlockLeft);
            swapped = true;
        }else{
            swapBlockLeft.insertBefore(swapBlockCentr);
            swapped = false;
        }
    });

    var tMod = $('#trmodal');
    tMod.modal('show').find('.btn-secondary').on('click',function(e){
        e.preventDefault();
        tMod.modal('hide');
    });
})