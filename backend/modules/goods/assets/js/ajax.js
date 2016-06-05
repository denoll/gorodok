/*
* Ajax запросы для модуля Users
* */

function changeStatus(id){
    var status = "#status_"+id;
    $.ajax({
        type: "post",
        url: "/goods/goods/change-status",
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