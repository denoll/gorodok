/**
 * Created by Администратор on 04.10.2015.
 */


function init() {
    var geolocation = ymaps.geolocation,
        myMap = new ymaps.Map('map', {
            center: [55, 34],
            zoom: 12,
        }, {
            searchControlProvider: 'yandex#search'
        });

    // Сравним положение, вычисленное по ip пользователя и
    // положение, вычисленное средствами браузера.
    geolocation.get({
        provider: 'yandex',
        mapStateAutoApply: true
    }).then(function (result) {
        // Красным цветом пометим положение, вычисленное через ip.
        result.geoObjects.options.set('preset', 'islands#redCircleIcon');
        result.geoObjects.get(0).properties.set({
            balloonContentBody: 'Мое местоположение'
        });
        myMap.geoObjects.add(result.geoObjects);
    });
    var geoData;
    geolocation.get({
        provider: 'browser',
        mapStateAutoApply: true
    }).then(function (result) {
        // Синим цветом пометим положение, полученное через браузер.
        // Если браузер не поддерживает эту функциональность, метка не будет добавлена на карту.
        result.geoObjects.options.set('preset', 'islands#blueCircleIcon');
        myMap.geoObjects.add(result.geoObjects);
        geoData = result.geoObjects.get(0).properties.get('boundedBy');
        var geo = result.geoObjects.get(0).properties.get('metaDataProperty.GeocoderMetaData.AddressDetails');
        geoInfo(geo);

    });

    // Обработка события, возникающего при щелчке
    // левой кнопкой мыши в любой точке карты.
    // При возникновении такого события откроем балун.
    myMap.events.add('click', function (e) {
        if (!myMap.balloon.isOpen()) {
            var coords = e.get('coords');
            getGeoInfo(coords[0].toPrecision(6), coords[1].toPrecision(6));
            myMap.balloon.open(coords, {
                contentHeader:'Событие!',
                contentBody:'<p>Кто-то щелкнул по карте.</p>' +
                '<p>Координаты щелчка: ' + [
                    coords[0].toPrecision(6),
                    coords[1].toPrecision(6),


                ].join(', ') + '</p>',
                contentFooter:'<sup>Щелкните еще раз</sup>'
            });
        }
        else {
            myMap.balloon.close();
        }
    });


}

function geoInfo(geo){
    var geoInfo = "#geo_info";
    $.ajax({
        type: "post",
        url: "/users/user/geo",
        data: "geo=" + geo,
        cache: true,
        dataType: "html",
        success: function (data) {
            $(geoInfo).data.text;
        }
    });
}


function getGeoInfo(lat, lon){
    var geoInfo = "#geo_info";
    $.ajax({
        type: "post",
        url: "/users/user/geo-info",
        data: "lat=" + lat + "&lon=" + lon,
        cache: true,
        dataType: "html",
        success: function (data) {
            $(geoInfo).data.text;
        }
    });
}

function containsPoint (bounds, point) {
    return point[0] >= bounds[0][0] && point[0] <= bounds[1][0] &&
    point[1] >= bounds[0][1] && point[1] <= bounds[1][1];
}