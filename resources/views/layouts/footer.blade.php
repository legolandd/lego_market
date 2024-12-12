<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md mb-3">
                    <ul>
                        <li><a href="{{route('about')}}">О нас</a> </li>
                        <li><a href="{{route('contacts')}}">Контакты</a></li>
                        <li><a href="{{route('sales')}}">Акции</a></li>
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
        <div class="text-center">
                <p><img src="{{asset('lego_images/phone.svg')}}" alt="Phone" class="mr-2" /></a> 8(999)999-99-99</p>
            </div>
        </div>   
    </div>
    
    
</footer>