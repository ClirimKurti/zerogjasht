<?php
if (!function_exists('zerogjasht_cta')) {
    function zerogjasht_cta()
    {
        // Single widget code
        $cta = '<style> div[data-widget-id="1709208"] { min-height: 300px; } </style>
                <div data-type="_mgwidget" data-widget-id="1709208"></div>
                <script>
                    (function(w,q){
                        w[q]=w[q]||[];
                        w[q].push(["_mgc.load"]);
                    })(window,"_mgq");
                </script>';
        return $cta;
    }
}

add_filter('the_content', function ($content) {
    $cta = zerogjasht_cta();

    if (!$cta) {
        return $content;
    }

    $words = explode(' ', $content);

    if (count($words) > 100) {
        $first_part = implode(' ', array_slice($words, 0, 100));
        $remaining_part = implode(' ', array_slice($words, 100));

        $content = $first_part . $cta . $remaining_part;
    }

    return $content;
}, 10);
