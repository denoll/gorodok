/**
 * Created by Администратор on 03.08.2015.
 */

var mq = window.matchMedia('(min-width: 978px)');
var sq = window.matchMedia('(min-width: 978px)');
if (mq.matches) {
    $('ul.navbar-nav > li').addClass('hovernav');
} else {
    $('ul.navbar-nav > li').removeClass('hovernav');
};
/*
 The addClass/removeClass also needs to be triggered
 on page resize <=> 768px
 */
if (matchMedia) {
    var mq = window.matchMedia('(min-width: 978px)');
    mq.addListener(WidthChange);
    WidthChange(mq);
}
function WidthChange(mq) {
    if (mq.matches) {
        $('ul.navbar-nav > li').addClass('hovernav');
        // Restore "clickable parent links" in navbar
        $('.hovernav a').click(function () {
            window.location = this.href;
        });
    } else {
        $('ul.navbar-nav > li').removeClass('hovernav');
        $('.main_menu_li a').dblclick(function () {
            window.location = this.href;
        });
    }
};


$('.hovernav a').click(function () {
    window.location = this.href;
});

$('.main_menu_li a').dblclick(function () {
    window.location = this.href;
});