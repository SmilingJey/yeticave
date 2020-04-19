<?php
    function renderTemplate($file, $data) {
        if (!file_exists($file)) return '';
        ob_start();
        require($file);
        return ob_get_clean();
    }
