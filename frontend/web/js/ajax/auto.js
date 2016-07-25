/**
 * Created by Администратор on 25.11.2015.
 */

//Изменить статус объявления об авто
function changeStatus(ads_id){
    var id_btn = "#status-btn-"+ads_id;
    var vip_btn = "#vip-btn-"+ads_id;
    var top_btn = "#up-btn-"+ads_id;
    $.ajax({
        type: "post",
        url: "auto/item/change-status",
        data: "ads_id=" + ads_id,
        cache: true,
        dataType: "html",
        success: function (data) {
            if(data == 'all'){
                $(id_btn).html('Сейчас объявление видно всем');
                $(id_btn).removeClass("btn-u-red");
                $(id_btn).addClass("btn-u-green");
                $(vip_btn).show();
                $(top_btn).show();
            }
            if(data == 'me'){
                $(id_btn).html('Сейчас объявление видно только мне');
                $(id_btn).removeClass("btn-u-green");
                $(id_btn).addClass("btn-u-red");
                $(vip_btn).hide();
                $(top_btn).hide();
            }
        }
    });
}

//Поднять бъявление на верх
function changeUp(ads_id){
    var up_btn = "#up-btn-"+ads_id;
    var span_updated = "#span_updated_at_"+ads_id;
    $.ajax({
        type: "post",
        url: "auto/item/change-up",
        data: "ads_id=" + ads_id,
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

//Сделать бъявление VIP
function changeVip(ads_id){
    var vip_btn = "#vip-btn-"+ads_id;
    var span_vip = "#span_vip_date_"+ads_id;
    $.ajax({
        type: "post",
        url: "auto/item/change-vip",
        data: "ads_id=" + ads_id,
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