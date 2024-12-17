<footer class="main-footer">
    <div class="container">
        <div class="row footer-flex">
            <div class="col-md mb-3">
                <ul>
                    <li>
                        <a href="{{route('about')}}">О нас</a>
                    </li>
                    <li>
                        <a href="{{route('contacts')}}">Контакты</a>
                    </li>
                    <li>
                        <a href="{{route('sales')}}">Акции</a>
                    </li>
                </ul>
            </div>

            <!-- Социальные сети -->
            <div class="col-md mb-3 flex-block">
                <h5>Мы в соц.сетях</h5>
                <div class="social">
                    <a href="#">
                        <img src="{{asset('lego_images/vk.svg')}}" alt="Vk" />
                    </a>
                    <a href="#">
                        <img src="{{asset('lego_images/classmates.svg')}}" alt="classmates" />
                    </a>
                </div>
            </div>

            <!-- Способы оплаты -->
            <div class="col-md mb-3 flex-block">
                <h5>Способы оплаты</h5>
                <div class="social">
                    <a href="#">
                        <img src="{{asset('lego_images/visa.svg')}}" alt="Visa" />
                    </a>
                    <a href="#">
                        <img src="{{asset('lego_images/mir.svg')}}" alt="Mir" />
                    </a>
                </div>
            </div>
            <div class="text-center">
                <a href="tel:89009999999">
                    <img src="{{asset('lego_images/phone.svg')}}" alt="Phone" class="mr-2" />
                    <span>8(999)999-99-99</span>
                </a>
            </div>
        </div>
    </div>


</footer>
