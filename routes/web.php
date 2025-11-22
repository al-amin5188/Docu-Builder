<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/demo-page', [PageController::class, 'show']);
Route::get('/demo-page/download-zip', [PageController::class, 'downloadZIP']);


use App\Services\BlockRenderer;

Route::get('/test-block', function () {
    $block = [
    "name" => "alert",
    "tag" => "div",
    "type" => "container",
    "attrs" => [
        "class" => ["output", "alert-output", "alert-{!-variant-!}"],
        "style" => "padding:12px;border-radius:6px;margin:10px 0;"
    ],
    "children" => [
        [
            "tag" => "strong",
            "type" => "container",
            "innerText" => "{!-title-!} "
        ],
        [
            "tag" => "span",
            "type" => "container",
            "innerText" => "{!-message-!}"
        ]
    ]
];

$data = [
    "variant" => "success", // class="alert-success"
    "title" => "Success!",
    "message" => "Your operation completed successfully."
];

    
    return view('test', [
        'html' => BlockRenderer::render($block, $data)
    ]);

});
