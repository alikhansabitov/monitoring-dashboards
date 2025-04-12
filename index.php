<?php
  // Определяем выбранный тип дашборда (по умолчанию 1).
  $dashboardType = isset($_GET['dashboard']) ? intval($_GET['dashboard']) : 1;

  // Массив с данными для 4 серверов.
  $servers = [
    [
      'id' => 1,
      'name' => 'Сервер 1',
      'cpu' => '42%',
      'memory' => '68%',
      'attack' => 'DDoS',
      'activity' => 'Аномальная активность за период 12:00-12:30',
      'recommendation' => 'Настроить firewall и ограничить количество одновременных подключений.'
    ],
    [
      'id' => 2,
      'name' => 'Сервер 2',
      'cpu' => '55%',
      'memory' => '75%',
      'attack' => 'Brute Force',
      'activity' => 'Активность с 11:00-11:15, превышающая норму',
      'recommendation' => 'Активировать блокировку учетных записей после нескольких неудачных попыток входа.'
    ],
    [
      'id' => 3,
      'name' => 'Сервер 3',
      'cpu' => '33%',
      'memory' => '52%',
      'attack' => 'SQL Injection',
      'activity' => 'Пиковая активность с 10:30-10:45',
      'recommendation' => 'Использовать подготовленные выражения и валидировать входные данные.'
    ],
    [
      'id' => 4,
      'name' => 'Сервер 4',
      'cpu' => '60%',
      'memory' => '80%',
      'attack' => 'Phishing',
      'activity' => 'Обнаружен подозрительный трафик в 09:00',
      'recommendation' => 'Проверить источник трафика и обновить антивирусное ПО.'
    ]
  ];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Система мониторинга и анализа угроз</title>
  <!-- Подключаем Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Дополнительные стили для темной темы -->
  <style>
    .dark-theme {
      background-color: #121212;
      color: #ffffff;
    }
    .dark-theme .card {
      background-color: #1e1e1e;
      color: #ffffff;
    }
    .dark-theme .navbar {
      background-color: #1a1a1a !important;
    }
    .dashboard-card {
      /* Пример стилизации карточек в стиле Grafana */
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>
  <!-- Навигационная панель -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Мониторинг</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <!-- Переключатель тем (светлая/тёмная) -->
          <li class="nav-item me-2">
            <button id="themeToggle" class="btn btn-outline-light">Светлая тема</button>
          </li>
          <!-- Кнопка настройки дашборда -->
          <li class="nav-item me-2">
            <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#settingsModal">
              Настройка
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Основной контейнер -->
  <div class="container mt-4">
    <h1 class="mb-4">Дашборды системы мониторинга</h1>
    <!-- Вывод карточек серверов -->
    <div class="row">
      <?php foreach ($servers as $server): ?>
        <div class="col-md-3 mb-4">
          <div class="card dashboard-card">
            <div class="card-header bg-primary text-white">
              <?= htmlspecialchars($server['name']); ?>
            </div>
            <div class="card-body">
              <?php if ($dashboardType === 1): ?>
                <!-- Вид 1: Нагрузка на сервера -->
                <p><strong>CPU:</strong> <?= htmlspecialchars($server['cpu']); ?></p>
                <p><strong>Память:</strong> <?= htmlspecialchars($server['memory']); ?></p>
              <?php else: ?>
                <!-- Вид 2: Дополнительные метрики -->
                <p><strong>График активности:</strong> <?= htmlspecialchars($server['activity']); ?></p>
                <p><strong>Анализ угроз:</strong> <?= htmlspecialchars($server['attack']); ?></p>
                <p><strong>Сетевой трафик:</strong> <?= rand(50, 100); ?> Мбит/с</p>
              <?php endif; ?>
              <!-- Кнопка для детального просмотра информации о сервере -->
              <button type="button" class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#serverModal<?= $server['id']; ?>">
                Подробнее
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  
  <!-- Модальные окна для детальной информации по каждому серверу -->
  <?php foreach ($servers as $server): ?>
  <div class="modal fade" id="serverModal<?= $server['id']; ?>" tabindex="-1" aria-labelledby="serverModalLabel<?= $server['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="serverModalLabel<?= $server['id']; ?>">Детали <?= htmlspecialchars($server['name']); ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body">
          <p><strong>Тип атаки:</strong> <?= htmlspecialchars($server['attack']); ?></p>
          <p><strong>Аномальная активность:</strong> <?= htmlspecialchars($server['activity']); ?></p>
          <p><strong>Рекомендации:</strong> <?= htmlspecialchars($server['recommendation']); ?></p>
          <?php if ($dashboardType === 1): ?>
            <p><strong>Нагрузка:</strong> CPU: <?= htmlspecialchars($server['cpu']); ?>, Память: <?= htmlspecialchars($server['memory']); ?></p>
          <?php else: ?>
            <p><strong>Дополнительные метрики:</strong></p>
            <ul>
              <li>График активности: отображает скачкообразные изменения активности.</li>
              <li>Анализ угроз: <?= htmlspecialchars($server['attack']); ?> – детальный анализ обнаруженных угроз.</li>
              <li>Сетевой трафик: примерное значение трафика <?= rand(50, 100); ?> Мбит/с.</li>
            </ul>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  <!-- Модальное окно для настройки дашбордов -->
  <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="index.php" method="get">
          <div class="modal-header">
            <h5 class="modal-title" id="settingsModalLabel">Настройка дашбордов</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
          </div>
          <div class="modal-body">
            <p>Выберите тип отображения дашбордов:</p>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="dashboard" id="dashboardType1" value="1" <?= $dashboardType === 1 ? "checked" : ""; ?>>
              <label class="form-check-label" for="dashboardType1">
                Нагрузка на сервера: CPU, Memory
              </label>
            </div>
            <div class="form-check mt-2">
              <input class="form-check-input" type="radio" name="dashboard" id="dashboardType2" value="2" <?= $dashboardType === 2 ? "checked" : ""; ?>>
              <label class="form-check-label" for="dashboardType2">
                График активности, Анализ угроз, Сетевой трафик
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary">Сохранить настройки</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Подключение Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Скрипт переключателя светлой/тёмной темы -->
  <script>
    const themeToggleBtn = document.getElementById('themeToggle');
    themeToggleBtn.addEventListener('click', function() {
      document.body.classList.toggle('dark-theme');
      // Изменяем текст кнопки
      if(document.body.classList.contains('dark-theme')){
        themeToggleBtn.textContent = 'Тёмная тема';
      } else {
        themeToggleBtn.textContent = 'Светлая тема';
      }
    });
  </script>
</body>
</html>
