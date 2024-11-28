<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <!-- Колонки с фильтрами -->
            <div class="col-md mb-3">
                <h5>Бренд</h5>
                <ul class="list-unstyled">
                    <li>LEGO</li>
                    <li>LOZ</li>
                    <li>Funko</li>
                </ul>
            </div>

            <div class="col-md mb-3">
                <h5>Серия</h5>
                    <ul>
                        <li>City</li>
                        <li>Classic</li>
                        <li>Disney Princess™</li>
                        <li>Harry Potter</li>
                        <li>Star Wars™</li>
                        <li>Super Mario</li>
                        <li>Wicked</li>
                    </ul>
            </div>

            <div class="col-md mb-3">
                <h5>Цена</h5>
                    <ul>
                        <li>До 1500</li>
                        <li>1500 - 3000</li>
                        <li>3000-7000</li>
                        <li>7000-10000</li>
                        <li>10000-20000</li>
                        <li>20000+</li>
                    </ul>
            </div>

            <div class="col-md mb-3">
                <h5>Пол</h5>
                    <ul>
                        <li>Мужской</li>
                        <li>Женский</li>
                    </ul>
            </div>

            <div class="col-md mb-3">
                    <ul>
                        <li><a href="{{route('about')}}">О нас</a> </li>
                        <li><a href="/">Контакты</a></li>
                        <li><a href="/">Акции</a></li>
                    </ul>
            </div>

            <!-- Социальные сети -->
            <div class="col-md mb-3">
                <h5>Мы в соц.сетях</h5>
                <a href="#"><img src="{{asset('lego_images/vk.svg')}}" alt="Vk" class="mr-2" /></a>
                <a href="#"><img src="{{asset('lego_images/classmates.svg')}}" alt="classmates" class="mr-2" /></a>
          </div>

            <!-- Способы оплаты -->
            <div class="col-md mb-3">
                <h5>Способы оплаты</h5>
                <a href="#"><img src="{{asset('lego_images/visa.svg')}}" alt="Visa" class="mr-2" /></a>
                <a href="#"><img src="{{asset('lego_images/mir.svg')}}" alt="Mir" class="mr-2" /></a>
            </div>
        </div>
        
            <div class="text-center mt-3">
                <p><img src="{{asset('lego_images/phone.svg')}}" alt="Phone" class="mr-2" /></a> 8(999)999-99-99</p>
            </div>
            
    </div>
</footer>