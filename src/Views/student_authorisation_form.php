<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/Views/header.php"); ?>
<div id="auth-form">
    <div>
        <div id="login_error" class="error_description_block"></div>
        <label for="login_input">Введите свою почту</label>
        <input type="email" required id="login_input" name="login" value="lebanvla@volsu.ru">
    </div>
    <div>
        <div id="password_error" class="error_description_block"></div>
        <label for="password_input">Введите свой пароль</label>
        <input type="password" required id="password_input" pattern="[a-zA-Z0-9]{7,}" name="password" value="qwertyuiop">
    </div>
    <button id="login_btn">Войти в личный кабинет</button>
</div>



<div>Забыли пароль? Необходимо обратиться в технический отдел в аудитории 1-05В</div>
<div>Если Вы ещё не получили свой пароль и логин, дождитесь его выдачи</div>


<script>
    document.getElementById('login_btn').addEventListener('click', function() {
        // Скрываем предыдущие ошибки
        hideAllErrors();

        // Получаем данные формы
        const login = document.getElementById('login_input').value;
        const password = document.getElementById('password_input').value;

        // Базовая валидация на клиенте
        if (!login || !password) {
            showError('login_error', 'Все поля обязательны для заполнения');
            return;
        }

        // Проверка email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(login)) {
            showError('login_error', 'Введите корректный email адрес');
            return;
        }

        // Проверка пароля
        if (password.length < 7) {
            showError('password_error', 'Пароль должен содержать минимум 7 символов');
            return;
        }

        // Отправка запроса
        sendAuthRequest(login, password);
    });

    function sendAuthRequest(login, password) {
        fetch('http://localhost/student/authorisation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `login=${encodeURIComponent(login)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Успешная авторизация - переходим по ссылке
                    window.location.href = data.link;
                } else if (data.status === 'error') {
                    // Обработка ошибок
                    handleAuthError(data.title, data.description);
                }
            })
            .catch(error => {
                showError('login_error', 'Произошла ошибка при отправке запроса');
            });
    }

    function handleAuthError(errorTitle, errorDescription) {
        if (errorTitle === 'login') {
            showError('login_error', errorDescription);
        } else if (errorTitle === 'password') {
            showError('password_error', errorDescription);
        } else if (errorTitle === 'system') {
            // Общая ошибка
            alert(errorDescription);
        }
    }

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function hideAllErrors() {
        document.getElementById('login_error').style.display = 'none';
        document.getElementById('password_error').style.display = 'none';
    }
</script>