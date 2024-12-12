document.addEventListener("DOMContentLoaded", function () {
    const filtersForm = document.getElementById("filters-form");
    const legoSetsContainer = document.getElementById("lego-sets-container");
    const loadingIndicator = document.getElementById("loading-indicator");

    // Функция для применения фильтров
    filtersForm.addEventListener("change", async () => {
        const formData = new FormData(filtersForm);

        loadingIndicator.classList.remove("hidden");

        // Добавляем класс для плавного исчезновения старого содержимого
        legoSetsContainer.classList.add("fade-out");

        try {
            const queryParams = new URLSearchParams(formData);

            // Отправляем AJAX-запрос для фильтров
            const response = await fetch(`${filtersForm.action}?${queryParams}`, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (response.ok) {
                const html = await response.text();

                // После завершения запроса заменяем содержимое
                legoSetsContainer.innerHTML = html;

                // Удаляем обработчик динамической подгрузки
                window.removeEventListener("scroll", loadMoreLegoSets);

                // Добавляем класс для плавного появления нового содержимого
                legoSetsContainer.classList.remove("fade-out");
                legoSetsContainer.classList.add("fade-in");

                // Убираем класс "fade-in" через время, чтобы анимация не повторялась
                setTimeout(() => {
                    legoSetsContainer.classList.remove("fade-in");
                }, 300);
            } else {
                console.error("Ошибка загрузки фильтров:", response.statusText);
            }
        } catch (error) {
            console.error("Ошибка:", error);
        } finally {
            loadingIndicator.classList.add("hidden");
        }
    });
});
