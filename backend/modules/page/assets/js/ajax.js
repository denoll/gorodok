/*
* Ajax запросы для модуля Users
* */

function changeStatus(id){
    var status = "#status_"+id;
    $.ajax({
        type: "post",
        url: "/page/page/change-status",
        data: "id=" + id,
        cache: true,
        dataType: "text",
        success: function (data) {
            if(data == '1'){
                $(status + ' i').removeClass("fa-minus");
                $(status + ' i').addClass("fa-check");
                $(status).removeClass('btn-danger');
                $(status).addClass('btn-success');
            }else{
                $(status + ' i').removeClass("fa-check");
                $(status + ' i').addClass("fa-minus");
                $(status).removeClass('btn-success');
                $(status).addClass('btn-danger');
            }
        }
    });
}
function changeOnMain(id){
    var onMain = "#on_main_"+id;
    $.ajax({
        type: "post",
        url: "/page/page/change-on-main",
        data: "id=" + id,
        cache: true,
        dataType: "text",
        success: function (data) {
            if(data == '1'){
                $(onMain + ' i').removeClass("fa-minus");
                $(onMain + ' i').addClass("fa-check");
                $(onMain).removeClass('btn-danger');
                $(onMain).addClass('btn-success');
            }else{
                $(onMain + ' i').removeClass("fa-check");
                $(onMain + ' i').addClass("fa-minus");
                $(onMain).removeClass('btn-success');
                $(onMain).addClass('btn-danger');
            }
        }
    });
}