<?php

// General
const APP_URL = 'http://localhost:8000';
const PRODUCTION = false;

// App
const APP_NAME = 'Harpia Application';
const APP_SLOGAN = 'My First Harpia Application';
const APP_VERSION = 1.0;

// Database connection
const DB_HOST = 'localhost';
const DB_DATABASE = 'newharpia';
const DB_USER = 'root';
const DB_PASSWORD = '';

const DB_CHARSET = 'utf8';
const DB_COLLATE = 'utf8_general_ci';

// Structure
const directory_storage = 'storage';
const directory_assets = 'assets';

// Try to create model database tables
const DB_FUNC_CREATE_TABLES = true;
const CONF_DEFAULT_TIMEZONE = 'America/Sao_Paulo';

// Default views for 404 and 503
const VIEW_NOT_FOUND = '404';
const VIEW_SERVICE_UNAVAILABLE = '503';

// Define maintenance
const IN_MAINTENANCE = false;
// use for example: '/panel' to specify path or * to global
const URL_MAINTENANCE = '/painel'; 