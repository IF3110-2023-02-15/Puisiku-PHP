<?php

define('IMAGE_VOLUME', $_ENV['PWD'] . '/public/img/');
define('AUDIO_VOLUME', $_ENV['PWD'] . '/public/audio/');

define('SRC_DIR', __DIR__ . '/');

define('CONTROLLER_DIR', SRC_DIR . 'controllers/');
define('SERVICES_DIR', SRC_DIR . 'services/');
define('MODELS_DIR', SRC_DIR . 'models/');
define('VIEWS_DIR', SRC_DIR . 'views/');
define('PAGES_DIR', SRC_DIR . 'views/pages/');

define("SUCCESS", "SUCCESS");

define("EMAIL_ALREADY_EXISTED", "EMAIL_ALREADY_EXISTED");
define("USER_NOT_FOUND", "USER_NOT_FOUND");
define("PASSWORD_INCORRECT", "PASSWORD_INCORRECT");

define("POEM_NOT_FOUND", "POEM_NOT_FOUND");