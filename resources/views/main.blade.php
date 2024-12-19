@extends('layouts.app')

@section('title', 'Главная')

@section('content')

    <div class="main-slider-container">
        <button class="slider-btn prev" id="prevBtn">
            <img src="{{asset('lego_images/main-slider-arrow-prev.svg')}}" alt="slider-arrow">
        </button>
        <div class="slider-wrapper">
            <div class="slider-item">
                <img src="{{asset('lego_images/main-slider1.png')}}" alt="Слайд 1">
            </div>
            <div class="slider-item">
                <img src="{{asset('lego_images/main-slider2.png')}}" alt="Слайд 2">
            </div>
            <div class="slider-item">
                <img src="{{asset('lego_images/main-slider3.png')}}" alt="Слайд 3">
            </div>
        </div>
        <button class="slider-btn next" id="nextBtn">
            <img src="{{asset('lego_images/main-slider-arrow-next.svg')}}" alt="slider-arrow">
        </button>
    </div>

    <h1 class="title">Распрадажа</h1>
    <div class="lego-slider-container">
        <button class="slider-btn prev">
            <img src="{{ asset('lego_images/main-slider-arrow-prev-black.svg') }}" alt="prev">
        </button>
        <div class="slider-wrapper">
            @foreach($sales as $sale)
                <div class="catalog-item slider-item">
                    <x-legoSets :legoSet="$sale"/>
                </div>
            @endforeach
        </div>
        <button class="slider-btn next">
            <img src="{{ asset('lego_images/main-slider-arrow-next-black.svg') }}" alt="next">
        </button>
    </div>

    <h1 class="title">Новинки</h1>
    <div class="lego-slider-container">
        <button class="slider-btn prev">
            <img src="{{ asset('lego_images/main-slider-arrow-prev-black.svg') }}" alt="prev">
        </button>
        <div class="slider-wrapper">
            @foreach($news as $new)
                <div class="catalog-item slider-item">
                    <x-legoSets :legoSet="$new"/>
                </div>
            @endforeach
        </div>
        <button class="slider-btn next">
            <img src="{{ asset('lego_images/main-slider-arrow-next-black.svg') }}" alt="next">
        </button>
    </div>

    <div class="sort">
        <h1 class="title">Каталог конструкторов лего</h1>
        <div class="sort-dropdown">
            <select id="sort-options" onchange="applySort()" class="sort-select">
                <option value="oldest" selected>Сначала старые</option>
                <option value="newest">Сначала новые</option>
                <option value="cheap">Сначала дешевые</option>
                <option value="expensive">Сначала дорогие</option>
                <option value="alphabet">По алфавиту</option>
            </select>
        </div>
    </div>
    <script>
        function applySort() {
            const filtersForm = document.getElementById('filters-form');
            const formData = new FormData(filtersForm);
            const sortOption = document.getElementById('sort-options').value;

            formData.set('sort', sortOption); // Добавляем параметр сортировки
            formData.set('page', 1); // Сбрасываем страницу на первую

            const queryParams = new URLSearchParams();
            formData.forEach((value, key) => queryParams.append(key, value));

            const url = `/?${queryParams.toString()}`;

            document.getElementById('loading-indicator').classList.remove('hidden');

            fetch(url, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('lego-sets-container').innerHTML = html;
                    document.getElementById('loading-indicator').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при загрузке данных.');
                });
        }
    </script>
    {{--        <p><a href="{{route('admin.dashboard')}}">Админ панель</a></p>--}}
    <div class="catalog-container">
        <aside class="filters">
            <form method="GET" action="{{ route('lego_sets.index') }}" id="filters-form">
                <!-- Серия -->
                <div class="filter-section">
                    <h4 class="filter-title">
                        Серия
                        <span class="arrow">
                            <img src="{{asset('lego_images/filter-arrow.svg')}}" alt="">
                        </span>
                    </h4>
                    <div class="filter-content">
                        @foreach($series as $serie)
                            <label>
                                <input type="checkbox" class="filter-option" name="series[]" value="{{ $serie->id }}"
                                    {{ in_array($serie->id, request('series', [])) ? 'checked' : '' }}>
                                <p>{{ $serie->name }}</p>
                            </label>
                        @endforeach
                    </div>
                    <hr aria-hidden="true">
                </div>

                <!-- Интересы -->
                <div class="filter-section">
                    <h4 class="filter-title">
                        Интересы
                        <span class="arrow"><img src="{{asset('lego_images/filter-arrow.svg')}}"></span>
                    </h4>
                    <div class="filter-content">
                        @foreach($interests as $interest)
                            <label>
                                <input type="checkbox" class="filter-option" name="interests[]" value="{{ $interest->id }}"
                                    {{ in_array($interest->id, request('interests', [])) ? 'checked' : '' }}>
                                {{ $interest->name }}
                            </label>
                        @endforeach
                    </div>
                    <hr aria-hidden="true">
                </div>

                <!-- Цена -->
                <div class="filter-section">
                    <h4 class="filter-title">
                        Цена
                        <span class="arrow"><img src="{{asset('lego_images/filter-arrow.svg')}}"></span>
                    </h4>
                    <div class="filter-content">
                        <label>
                            <input type="radio" class="filter-option" name="price" value="0-1500"
                                {{ request('price') == '0-1500' ? 'checked' : '' }}>
                            до 1500 ₽
                        </label>
                        <label>
                            <input type="radio" class="filter-option" name="price" value="20000-25000"
                                {{ request('price') == '20000-25000' ? 'checked' : '' }}>
                            20000 ₽ - 25000 ₽
                        </label>
                    </div>
                </div>
            </form>
        </aside>
        @if ($legoSets->isEmpty())
            <p>По запросу "{{ request('search') }}" ничего не найдено.</p>
        @else
            <main class="catalog">
                <div class="selected-filters">
                    <ul id="selected-filters-list"></ul>
                </div>
                <div class="catalog-grid" id="lego-sets-container">
                    @include('components.lego_sets', ['legoSets' => $legoSets])
                </div>
                <div id="loading-indicator" class="loading-indicator hidden">
                    <div class="loader"></div>
                </div>
                <div id="pagination-placeholder"></div>
            </main>
            <script src="{{ asset('js/page-loader.js') }}"></script>
    </div>
    @endif
    <script src="{{asset('js/filters-submit.js')}}"></script>
    <script>
        document.querySelectorAll('.filter-title').forEach(function(title) {
            title.addEventListener('click', function() {
                var section = this.closest('.filter-section');
                section.classList.toggle('open'); // Переключаем состояние
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            const selectedFiltersList = document.getElementById('selected-filters-list');
            const filtersForm = document.getElementById('filters-form');

            // Обновляем список выбранных фильтров
            const updateSelectedFilters = () => {
                selectedFiltersList.innerHTML = '';

                const filters = document.querySelectorAll('.filter-option:checked');
                filters.forEach(filter => {
                    const filterValue = filter.closest('label').textContent.trim();

                    const listItem = document.createElement('li');
                    listItem.textContent = filterValue; // Отображаем только значение выбранного фильтра

                    // Добавляем кнопку для удаления фильтра с изображением
                    const removeButton = document.createElement('button');
                    removeButton.classList.add('remove-filter');
                    const deleteIcon = document.createElement('img');
                    deleteIcon.src = "{{ asset('lego_images/remove-filter.svg') }}"; // Путь к изображению крестика
                    deleteIcon.alt = "Удалить фильтр";
                    deleteIcon.classList.add('delete-icon');

                    removeButton.appendChild(deleteIcon);

                    removeButton.addEventListener('click', () => {
                        filter.checked = false; // Убираем галочку у фильтра
                        updateSelectedFilters(); // Обновляем список выбранных фильтров
                        filtersForm.dispatchEvent(new Event('change')); // Отправляем форму для обновления каталога
                    });

                    listItem.appendChild(removeButton);
                    selectedFiltersList.appendChild(listItem);
                });
            };

            // Обработчик изменения состояния фильтров
            document.querySelectorAll('.filter-option').forEach(option => {
                option.addEventListener('change', () => {
                    updateSelectedFilters();
                    filtersForm.dispatchEvent(new Event('change')); // Отправляем форму при изменении фильтра
                });
            });

            // Инициализация при загрузке страницы
            updateSelectedFilters();
        });
    </script>

    <script src="{{ asset('js/slider.js') }}"></script>
@endsection
