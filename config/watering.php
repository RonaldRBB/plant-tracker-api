<?php

return [
    'intervals' => [
        'fertilizer' => env('FERTILIZER_INTERVAL', 15),
        'trichoderma' => env('TRICHODERMA_INTERVAL', 15),
        'slow_release' => env('SLOW_RELEASE_INTERVAL', 28),
        'slow_release_to_trichoderma' => env('SLOW_RELEASE_TO_TRICHODERMA_INTERVAL', 14),
        'trichoderma_to_fertilizer' => env('TRICHODERMA_TO_FERTILIZER_INTERVAL', 15),
    ],
    'minimum_waterings' => env('MINIMUM_WATERINGS_BEFORE_TREATMENTS', 4),
]; 