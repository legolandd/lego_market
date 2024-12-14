let currentPage = 1;
let isLoading = false;
const itemsPerPage = 15; // Количество элементов на странице, согласно серверу

const container = document.getElementById('lego-sets-container');
const loadingIndicator = document.getElementById('loading-indicator');

const loadMoreLegoSets = async () => {
    if (isLoading) return;

    // Проверяем, достигли ли мы низа страницы
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
        isLoading = true;

        // Показать индикатор загрузки
        loadingIndicator.classList.remove('hidden');

        currentPage++;

        try {
            // Получаем текущие параметры из URL
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', currentPage); // Обновляем номер страницы

            const url = `/load-more-lego?${urlParams.toString()}`;

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await response.json();

            // Добавляем новые LEGO-наборы в контейнер
            if (data.html) {
                container.innerHTML += data.html;
            }

            // Проверка на количество наборов
            const newSetsCount = (data.html.match(/class="catalog-item"/g) || []).length;
            console.log('Количество новых наборов:', newSetsCount);

            // Если сервер вернул только один набор или меньше, прекращаем дальнейшую подгрузку
            if (data.total <= 1) {
                console.log('Загружено недостаточно наборов. Больше подгружать не нужно.');
                // Отключаем подгрузку (снимаем обработчик прокрутки)
                window.removeEventListener('scroll', loadMoreLegoSets);
            }

            // Если больше страниц нет, отключаем обработчик прокрутки
            if (!data.hasMore) {
                window.removeEventListener('scroll', loadMoreLegoSets);
            }
        } catch (error) {
            console.error('Ошибка при загрузке:', error);
        } finally {
            isLoading = false;

            // Скрыть индикатор загрузки
            loadingIndicator.classList.add('hidden');
        }
    }
};

// Назначаем обработчик scroll
window.addEventListener('scroll', loadMoreLegoSets);
