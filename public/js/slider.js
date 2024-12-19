class Slider {
    constructor(container, options = {}) {
        this.container = container;
        this.sliderWrapper = container.querySelector('.slider-wrapper');
        this.items = container.querySelectorAll('.slider-item');
        this.prevBtn = container.querySelector('.prev');
        this.nextBtn = container.querySelector('.next');
        this.currentIndex = 0;

        // Настройки
        this.visibleItems = options.visibleItems || 1; // Показывать 1 элемент по умолчанию
        this.autoSlideTime = options.autoSlideTime || 10000;

        this.init();
    }

    init() {
        if (!this.sliderWrapper || this.items.length === 0) {
            console.warn('Slider initialization failed: missing elements', this.container);
            return;
        }
        this.updateSlider();
        this.setupListeners();

        if (this.autoSlideTime) {
            this.startAutoSlide();
        }
    }

    updateSlider() {
        if (this.items.length === 0) {
            console.warn('No slider items found in', this.container);
            return;
        }

        const containerWidth = this.container.clientWidth; // Ширина контейнера
        const itemWidth = containerWidth / this.visibleItems; // Ширина одного элемента
        const totalWidth = itemWidth * this.items.length;

        this.items.forEach(item => {
            item.style.width = `${itemWidth}px`; // Устанавливаем ширину элемента
        });

        this.sliderWrapper.style.width = `${totalWidth}px`;
        this.sliderWrapper.style.transform = `translateX(-${this.currentIndex * itemWidth}px)`;
    }


    nextSlide() {
        const totalSlides = this.items.length;

        this.currentIndex = Math.min(this.currentIndex + 1, totalSlides - this.visibleItems);
        this.updateSlider();
    }

    prevSlide() {
        this.currentIndex = Math.max(this.currentIndex - 1, 0);
        this.updateSlider();
    }

    startAutoSlide() {
        this.stopAutoSlide();
        this.autoSlideInterval = setInterval(() => this.nextSlide(), this.autoSlideTime);
    }

    stopAutoSlide() {
        if (this.autoSlideInterval) {
            clearInterval(this.autoSlideInterval);
        }
    }

    setupListeners() {
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.prevSlide();
                this.startAutoSlide();
            });
        }

        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.nextSlide();
                this.startAutoSlide();
            });
        }

        window.addEventListener('resize', () => this.updateSlider());
    }
}

// Initialize sliders
document.addEventListener('DOMContentLoaded', () => {
    // Для верхнего слайдера (фото)
    document.querySelectorAll('.main-slider-container').forEach(container => {
        new Slider(container, { visibleItems: 1, autoSlideTime: 5000 });
    });

    // Для нижнего слайдера (карточки)
    document.querySelectorAll('.lego-slider-container').forEach(container => {
        new Slider(container, { visibleItems: 5, autoSlideTime: 10000 });
    });
});
