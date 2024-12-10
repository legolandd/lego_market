let currentPage = 1;
let isLoading = false;

const container = document.getElementById('lego-sets-container');
const loadingIndicator = document.getElementById('loading-indicator');

window.addEventListener('scroll', async () => {
    if (isLoading) return;

    // Проверяем, достигли ли мы низа страницы
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
        isLoading = true;

        // Показать индикатор загрузки
        loadingIndicator.classList.remove('hidden');

        currentPage++;

        try {
            const response = await fetch(`/load-more-lego?page=${currentPage}`);
            const data = await response.json();

            // Добавляем новые LEGO-наборы в контейнер
            if (data.html) {
                container.innerHTML += data.html;
            }

            // Если больше страниц нет, остановить загрузку
            if (!data.hasMore) {
                window.removeEventListener('scroll', arguments.callee);
            }
        } catch (error) {
            console.error('Ошибка при загрузке:', error);
        } finally {
            isLoading = false;

            loadingIndicator.classList.add('hidden');
        }
    }
});

