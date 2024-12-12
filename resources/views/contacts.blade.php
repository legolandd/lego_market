@extends('layouts.app')

@section('title', 'Контакты')

<link rel="stylesheet" href="{{asset('css/about.css')}}">

@section('content')
    <div class="container">
        <h2 class="title-content">Наши контакты</h2>
        <p class="all-text">Добро пожаловать на страницу контактов нашего сайта! Мы всегда рады вашим вопросам, предложениям и отзывам. Если у вас возникли какие-либо вопросы или вам нужна помощь, не стесняйтесь обращаться к нам. Мы находимся здесь, чтобы помочь вам!</p>

        <p class="highlight">Вы можете связаться с нами следующими способами:</p>
        <ul class="list-sales">
            <li>Электронная почта — legoblox@mail.ru</li>
            <li>Телефон — +7 (960) 123-4567</li>
            <li>Адрес — 423827, г. Набережные Челны, Республика Татарстан, Проспект Яшлек, 14</li>
            <li>Социальные сети — ВКонтакте, Одноклассники</li>
        </ul>

        <p class="highlight">Наши рабочие часы:</p>
        <ul class="list-sales">
            <li>Пн. - Пт.: 9:00 - 20:00</li>
            <li>Сб. - Вс.: 10:00 - 19:00</li>
        </ul>

        <p class="highlight">Спасибо, что Вы с нами!</p>
        <p class="all-text">Мы всегда стремимся ответить на все запросы как можно быстрее и качественнее. Ваше мнение для нас очень важно, и мы готовы принимать любые предложения по улучшению наших услуг.</p>

        <div id="map" style="width: 100%; height: 400px;"></div>

        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                ymaps.ready(init);

                function init() {
                    var myMap = new ymaps.Map("map", {
                        center: [55.761801, 52.453267],
                        zoom: 15,
                        controls: ['zoomControl']
                    });

                    var myPlacemark = new ymaps.Placemark([55.761801, 52.453267], {
                        balloonContent: 'Мы здесь!'
                    });

                    myMap.geoObjects.add(myPlacemark);
                }
            });
        </script>
    </div>
@endsection