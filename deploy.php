<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config
// Zone ühendus
set('application', 'Hajusrakendus');
set('remote_user', 'virt118416');
set('http_user', 'virt118416');
set('keep_releases', 2);

host('ta22alber.itmajakas.ee')
    ->setHostname('ta22alber.itmajakas.ee')
    ->set('http_user', 'virt118416')
    ->set('deploy_path', '~/domeenid/www.ta22alber.itmajakas.ee/hajusrakendus')
    ->set('branch', 'main');



set('repository', 'git@github.com:LiisAlber/hajusrakendus.git');


// Tasks

task('opcache:clear', function () {
    run('killall php82-cgi || true');
})->desc('Clear opcache');

task('build:node', function () {
    cd('{{release_path}}');
    run('npm i');
    run('npx vite build');
    run('rm -rf node_modules');
});

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'build:node',
    'deploy:publish',
    'opcache:clear',
    'artisan:cache:clear'
]);

// Hooks

after('deploy:failed', 'deploy:unlock');
