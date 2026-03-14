<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    */
    'show_warnings'        => env('DOMPDF_SHOW_WARNINGS', false),   // Throw an Exception on warnings from dompdf
    'orientation'          => env('DOMPDF_ORIENTATION', 'portrait'), // landscape or portrait
    'defines'              => [
        /**
         * The location of the DOMPDF font directory
         *
         * The directory where the fonts used by DOMPDF are stored.
         *
         * By default the $fontDir shared by dompdf/src/FontMetrics.php is used.
         * It is also set by FontMetrics::register_font()
         */
        // "fontDir" => public_path("fonts/dompdf/"),
        /**
         * The location of the DOMPDF font cache directory
         *
         * This directory must be writable by the webserver process.
         * This is used to cache converted fonts.
         *
         * By default the $fontCache shared by dompdf/src/FontMetrics.php is used.
         * It is also set by FontMetrics::register_font()
         */
        // "fontCache" => storage_path("app/dompdf/fonts/"),
        /**
         * The location of the temporary directory.
         *
         * This directory must be writable by the webserver process.
         * This is used to generate temporary files.
         *
         * By default sys_get_temp_dir()
         */
        "tempDir" => storage_path("app/dompdf/tmp/"),
        /**
         * The location of the chroot directory
         *
         * When this value is set, dompdf will restrict file access to this directory.
         *
         * By default no chroot restriction is applied.
         */
        // "chroot" => null,
        /**
         * Whether to enable font subsetting or not.
         *
         * When enabled, dompdf will attempt to reduce the size of embedded fonts.
         *
         * @see Font::subset()
         */
        "fontSubsetting" => true,
        /**
         * Whether to enable remote file access
         *
         * When enabled, dompdf can access external stylesheets and images.
         *
         * NOTE: This is a potential security risk.
         */
        "enableRemote" => false,
        /**
         * The default paper size.
         *
         * By default this is set to 'letter' (8.5" x 11").
         *
         * @see CPDF_Adapter::PAPER_SIZES for valid paper sizes
         */
        "defaultPaperSize" => "a4",
        /**
         * The default font family
         *
         * By default this is set to 'serif'
         *
         * @see Font_Metrics::get_font_families()
         */
        "defaultFont" => "serif",
        /**
         * DPI setting
         *
         * This adjusts the dpi of the output PDF
         *
         * @see CanvasFactory::get_instance()
         */
        "dpi" => 96,
        /**
         * Enable PHP fatal error handler
         *
         * When enabled, dompdf will wrap PHP fatal errors into an exception
         * and throw them.
         */
        "enablePhp" => true,
        /**
         * Enable inline JavaScript
         *
         * When enabled, inline JavaScript is executed.
         *
         * NOTE: This is a potential security risk.
         */
        "enableJavascript" => false,
        /**
         * Enable HTML5 Parser
         *
         * When enabled, dompdf will use the HTML5Lib parser.
         *
         * NOTE: This is a potential security risk.
         */
        "enableHtml5Parser" => true,
        /**
         * Enable CSS float
         *
         * When enabled, CSS float is supported.
         *
         * NOTE: This is a potential security risk.
         */
        "enableCssFloat" => true,
    ],
];
