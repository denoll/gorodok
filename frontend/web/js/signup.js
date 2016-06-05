/**
 * Created by Администратор on 10.11.2015.
 */

function isCompany(is_company){
    $.ajax({
        type: "get",
        url: "is-company",
        data: "bool=" + is_company,
        cache: true,
        dataType: "json",
        success: function (data) {

        }
    });
    if(is_company == 1){
        $("#how_signup").text("Регистрация компании");
        $(".field-signupform-username label").text("Имя контактного лица");
        $("#fio").text("Укажите данные о компании");
        $("#lbl-text").text("как частное лицо");
        $("#s_name").show();
        $(".field-signupform-company_name label").text("Название компании");
        $("#auth_block").hide();
    }else{
        $("#how_signup").text("Регистрация частного лица");
        $(".field-signupform-username label").text("Ваше имя");
        $("#fio").text("Уточните пожалуйста свои данные");
        $("#lbl-text").text("как компания");
        $("#s_name").hide();
        $("#auth_block").show();
    }
}