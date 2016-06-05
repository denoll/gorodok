/**
 * Created by Администратор on 29.10.2015.
 */


//Удалить из списка рассылки
function catRes_del(cat_id){
    var id_li = "#cat-"+cat_id;
    $.ajax({
        type: "post",
        url: "cat-del",
        data: "cat_id=" + cat_id,
        cache: true,
        dataType: "html",
        success: function (data) {
            $(id_li).hide();
        }
    });
}

//Изменить статус резюме
function changeStatus(res_id){
    var id_btn = "#status-btn-"+res_id;
    var vip_btn = "#vip-btn-"+res_id;
    var up_btn = "#up-btn-"+res_id;
    $.ajax({
        type: "post",
        url: "change-status",
        data: "res_id=" + res_id,
        cache: true,
        dataType: "html",
        success: function (data) {
            if(data == 'all'){
                $(id_btn).html('Видно всем');
                $(id_btn).removeClass("btn-u-red");
                $(id_btn).addClass("btn-u-green");
                $(vip_btn).show();
                $(up_btn).show();
            }
            if(data == 'me'){
                $(id_btn).html('Видно только мне');
                $(id_btn).removeClass("btn-u-green");
                $(id_btn).addClass("btn-u-red");
                $(vip_btn).hide();
                $(up_btn).hide();
            }
            //$(btn_add).prop('disabled', false);
            //$(btn_del).prop('disabled', true);
        }
    });
}

//Поднять резюме на верх
function changeUp(res_id){
    var up_btn = "#up-btn-"+res_id;
    var span_updated = "#span_updated_at_"+res_id;
    $.ajax({
        type: "post",
        url: "change-up",
        data: "res_id=" + res_id,
        cache: true,
        dataType: "json",
        success: function (data) {
            //Для форматирования даты
            Date.prototype.format = function (mask, utc) {
                return dateFormat(this, mask, utc);
            };
           var updated = new Date();
           if(data.m_type == 'success'){
                $('#account').html(data.account);
                $(span_updated).html(updated.format("dd.mm.yyyy"));
                alert(data.message);
            }else if(data.m_type == 'danger') {
                alert(data.message);
            }
        }
    });
}

//Сделать резюме VIP
function changeVip(res_id){
    var vip_btn = "#vip-btn-"+res_id;
    var span_vip = "#span_vip_date_"+res_id;
    $.ajax({
        type: "post",
        url: "change-vip",
        data: "res_id=" + res_id,
        cache: true,
        dataType: "json",
        success: function (data) {
            //Для форматирования даты
            Date.prototype.format = function (mask, utc) {
                return dateFormat(this, mask, utc);
            };
            var updated = new Date();
            if(data.m_type == 'success'){
                $('#account').html(data.account);
                $(span_vip).html(updated.format("dd.mm.yyyy"));
                alert(data.message);
            }else if(data.m_type == 'danger') {
                alert(data.message);
            }
        }
    });
}