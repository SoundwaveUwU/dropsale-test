<!DOCTYPE html>
<html>
<head>
    <title>Импорт пользователей</title>
</head>
<body>
    <button id="import">импортировать пользователей</button>
    <ul id="stats">
        <li>Всего: <span id="total">{{ $total }}</span></li>
        <li>Добавлено: <span id="created">0</span></li>
        <li>Обновлено: <span id="updated">0</span></li>
    </ul>
    <div id="loading" style="display:none">Импортируем...</div>
    <div id="error" style="display:none;background:red;color:white">Пока без ошибок :)</div>
</body>

<script>
    const button = document.getElementById('import');
    const statsList = document.getElementById('stats');
    const loading = document.getElementById('loading');
    const error = document.getElementById('error');

    button.addEventListener('click', async function () {
        button.disabled = true
        error.style.display = 'none'
        statsList.style.display = 'none'
        loading.style.display = 'block'
        try {
            const response = await fetch('/api/import-users', {
                method: 'POST',
                headers: { Accept: 'application/json' }
            })
            const json = await response.json()

            for (let key in json) {
                document.getElementById(key).innerHTML = json[key]
            }

            statsList.style.display = 'block'
        } catch (e) {
            statsList.style.display = 'none'
            loading.style.display = 'none'
            error.style.display = 'block'

            error.innerHTML = e.message
            console.error(e);
        }

        button.disabled = false
        loading.style.display = 'none'
    })
</script>
</html>
