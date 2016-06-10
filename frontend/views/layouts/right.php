<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 06.08.2015
 * Time: 12:26
 */
use yii\helpers\Url;
use frontend\widgets\CategJob;
use frontend\widgets\CategNews;
use frontend\widgets\CategPage;
use frontend\widgets\CategPres;
use frontend\widgets\TagsWidget;
//use frontend\widgets\NewsSidebarWidget;
use frontend\widgets\ProfileLeftSidebar;

$show = false;

$path = Url::current();

if(!stristr($path, 'site')){

    echo \frontend\widgets\NewsSidebarWidget::widget();
    echo \frontend\widgets\AfishaSidebarWidget::widget();
    echo \frontend\widgets\LettersSidebarWidget::widget();

    if(stristr($path, '/profile/')||stristr($path, '/jobs/')||stristr($path, '/account/')){
        //echo $path;
        if(stristr($path, 'account/')){

        }
        if(stristr($path, 'profile/index')){

        }
        if(stristr($path, 'profile/company')){

        }
        if(stristr($path, 'jobs/job-profile/index')||stristr($path, 'jobs/index')||stristr($path, 'jobs/edu')||stristr($path, 'jobs/exp')){

        }
        if(stristr($path, 'jobs/resume/create') || stristr($path, 'jobs/resume/update') || stristr($path, 'jobs/resume/my-resume')){

        }
        if(stristr($path, 'jobs/vacancy/create') || stristr($path, 'jobs/vacancy/update') || stristr($path, 'jobs/vacancy/my-vacancy')){

        }
        if(stristr($path, 'jobs/resume/index')||stristr($path, 'jobs/resume/view')){

        }
        if(stristr($path, 'jobs/vacancy/index')||stristr($path, 'jobs/vacancy/view')){

        }
        //echo NewsSidebarWidget::init();
    }
    if(stristr($path, '/med/doctors')){
        if(stristr($path, '/med/doctors/index')||stristr($path, '/med/doctors/view')){

        }
        if(stristr($path, '/med/doctors/update')||stristr($path, '/med/doctors/create')||stristr($path, '/med/doctors/my-serv')){

        }
    }
    if(stristr($path, '/tags/')){

    }

    if(stristr($path, '/goods')){
        if(stristr($path, '/goods/update')||stristr($path, '/goods/create')||stristr($path, '/goods/my-ads')){

        }
        if(stristr($path, '/goods')||stristr($path, '/goods')){

        }

    }
    if(stristr($path, '/service')||stristr($path, '/set-service')){
        if(stristr($path, '/service/update')||stristr($path, '/service/create')||stristr($path, '/service/my-ads')){
            echo ProfileLeftSidebar::showSidebar(9);
        }
        if(stristr($path, '/service')){

        }
        if(stristr($path, '/set-service')){

        }
    }

    if(stristr($path, '/realty')){
        if(stristr($path, '/realty/sale/update')||stristr($path, '/realty/sale/create')||stristr($path, '/realty/sale/my-ads')){

        }
        if(stristr($path, '/realty/rent/update')||stristr($path, '/realty/rent/create')||stristr($path, '/realty/rent/my-ads')){

        }
        if(stristr($path, '/realty/sale')){

        }
        if(stristr($path, '/realty/rent')){

        }
    }

    if(stristr($path, '/news')){

    }

    $show = true;

}