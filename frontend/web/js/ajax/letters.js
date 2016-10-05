/**
 * Created by Администратор on 23.12.2015.
 */

function rating_up(letter_id) {
    //$(".rating_btn_up").click(function () {
        //var letter_id = $(this).attr("data-val");
        $.ajax({
            type: "post",
            url: "/letters/letters/rating-up",
            data: "letter_id=" + letter_id,
            cache: true,
            dataType: "json",
            success: function (data) {
                if(data.message == 'reg'){
                    $("#message_"+letter_id).html('Для голосования зарегистрируйтесь или войдите на сайт.');
                }else{
                    if(data.message == 'no'){
                        $("#vote_yes_"+letter_id).html(data.vote_yes);
                        $("#vote_no_"+letter_id).html(data.vote_no);
                        $("#rating_val_"+letter_id).html(data.rating);
                        $("#message_"+letter_id).html('');
                    }else{
                        $("#message_"+letter_id).html('Вы уже голосовали');
                    }
                }
                //$("#id_rating_txt_"+letter_id).html(data);
            }
        });
    //});
}

function rating_down(letter_id) {
    //$(".rating_btn_down").click(function () {
        //var letter_id = $(this).attr("data-val");
        $.ajax({
            type: "post",
            url: "/letters/letters/rating-down",
            data: "letter_id=" + letter_id,
            cache: true,
            dataType: "json",
            success: function (data) {
                if(data.message == 'reg'){
                    $("#message_"+letter_id).html('Для голосования зарегистрируйтесь или войдите на сайт.');
                }else{
                    if(data.message == 'no'){
                        $("#vote_yes_"+letter_id).html(data.vote_yes);
                        $("#vote_no_"+letter_id).html(data.vote_no);
                        $("#rating_val_"+letter_id).html(data.rating);
                        $("#message_"+letter_id).html('');
                    }else{
                        $("#message_"+letter_id).html('Вы уже голосовали');
                    }
                }
            }
        });
    //});
}
