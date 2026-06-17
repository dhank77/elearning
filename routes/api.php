<?php

use App\Http\Controllers\Webhook\XenditWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('webhooks/xendit', XenditWebhookController::class)->name('webhooks.xendit');