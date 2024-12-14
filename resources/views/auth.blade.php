<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    <title>Авторизация</title>
</head>
<body>
    <div class="wrapper">
        <div class="form-wrapper sign-in">
            <form action="{{route('login')}}" method="POST">
                @csrf
                <h2>Войдите в свою учетную запись</h2>
                <div class="input-group">
                    <input type="text" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$" required>
                    <label for="email">Почта</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Пароль</label>
                </div>
                <button type="submit">Войти</button>
                <div class="signUp-link">
                    <p>У вас еще нет аккаунта? <a href="#" class="signUpBtn-link">Зарегистрироваться</a></p>
                </div>
            </form>
        </div>
        <div class="form-wrapper sign-up">
            <form action="{{route('register')}}" method="POST">
                @csrf
                <h2>Регистрация</h2>
                <div class="input-group">
                    <input type="text" name="name" id="name" required>
                    <label for="name">Имя пользователя</label>
                </div>
                <div class="input-group">
                    <input type="text" name="email" id="email" required>
                    <label for="email">Почта</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Пароль</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                    <label for="password_confirmation">Подтвердите пароль</label>
                </div>
                <button type="submit">Зарегистрироваться</button>
                <div class="signUp-link">
                    <p>У вас уже есть аккаунт? <a href="#" class="signInBtn-link">Войти</a></p>
                </div>
            </form>

        </div>
    </div>
    <div class="toast-container" id="toast-container"></div>
    <script>
        // Функция для добавления уведомления
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;

            // Добавляем уведомление в контейнер
            container.appendChild(toast);

            // Удаляем уведомление через 5 секунд
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }

        // Проверяем уведомления из сессии и отображаем их
        @if (session('success'))
        showToast("{{ session('success') }}", 'success');
        @endif

        @if (session('error'))
        showToast("{{ session('error') }}", 'error');
        @endif

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        showToast("{{ $error }}", 'error');
        @endforeach
        @endif
    </script>

<script>
    const signUpBtnLink = document.querySelector('.signUpBtn-link');
    const signInBtnLink = document.querySelector('.signInBtn-link');
    const wrapper = document.querySelector('.wrapper');

    signUpBtnLink.addEventListener('click', () => {
        wrapper.classList.toggle('active');
    });

    signInBtnLink.addEventListener('click', () => {
        wrapper.classList.toggle('active');
    });
</script>
</body>
</html>
