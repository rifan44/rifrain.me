<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('portfolio:about', function (): void {
    $this->info('Portfolio content is stored in the site_contents table.');
})->purpose('Describe portfolio content storage');
