function addToast(message, type) {
    const container = document.getElementById('toast-container');

    // Создаем элемент уведомления
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;

    // Добавляем уведомление в контейнер
    container.appendChild(toast);

    // Удаляем уведомление через 5 секунд
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.5s';
        toast.addEventListener('animationend', () => toast.remove());
    }, 5000);
}
