@foreach($legoSets as $legoSet)
    <div class="catalog-item">
        <a href="{{ route('lego_sets.show', $legoSet->id) }}" class="lego_set_more">
            <img src="{{ asset('storage/' . $legoSet->images->first()->image_url) }}" class="card-img-top" alt="{{ $legoSet->name }}">
        </a>
        <h5>{{ $legoSet->name }}</h5>
        <p>{{ $legoSet->price }} ₽</p>
        @if ($legoSet->stock > 0)
            <form action="{{ route('cart.add', $legoSet) }}" method="POST">
                @csrf
                <button type="submit" class="add-to-cart">Заказать</button>
            </form>
        @else
            <button class="add-to-cart disabled" disabled>Нет в наличии</button>
        @endif
    </div>
@endforeach
