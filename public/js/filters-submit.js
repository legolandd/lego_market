document.addEventListener("DOMContentLoaded", function () {
    const filtersForm = document.getElementById("filters-form");
    const legoSetsContainer = document.getElementById("lego-sets-container");
    const loadingIndicator = document.getElementById("loading-indicator");

    // Функция для применения фильтров
    filtersForm.addEventListener("change", async () => {
        const formData = new FormData(filtersForm);

        // Показать индикатор загрузки
        loadingIndicator.classList.remove("hidden");

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
                legoSetsContainer.innerHTML = html;

                // Удаляем обработчик динамической подгрузки
                window.removeEventListener("scroll", loadMoreLegoSets);
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
