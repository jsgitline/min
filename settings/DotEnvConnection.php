<?php

# Создаём объект .env
$dotEnv = \Dotenv\Dotenv::createMutable(SITE_PATH);


# Загружаем .env
$dotEnv->load();
