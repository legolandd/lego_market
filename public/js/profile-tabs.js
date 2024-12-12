document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.sidebar .text');
    const tabs = document.querySelectorAll('.tab-content');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            links.forEach(link => link.classList.remove('active'));
            tabs.forEach(tab => tab.classList.remove('active'));

            const targetTab = document.getElementById(this.dataset.tab + '-tab');
            this.classList.add('active');
            targetTab.classList.add('active');
        });
    });
});
