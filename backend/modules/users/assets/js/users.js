/*
* Ajax запросы для модуля Users
* */

function changeStatus(userId){
    var status = "#status_"+userId;
    $.ajax({
        type: "post",
        url: "/users/user/change-status",
        data: "user_id=" + userId,
        cache: true,
        dataType: "text",
        success: function (data) {
            if(data == '10'){
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