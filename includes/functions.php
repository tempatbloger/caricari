<?php
// Pastikan ada tag <?php di baris pertama

function parseUrlCariCari($url) {
    $url = trim($url);
    $parse = parse_url($url);
    $fullHost = isset($parse['host']) ? $parse['host'] : '';
    $slug = isset($parse['path']) ? $parse['path'] : '/';
    
    if(isset($parse['query'])) $slug .= '?' . $parse['query'];

    if ($fullHost != '') {
        $posisiTitikTerakhir = strrpos($fullHost, '.');
        if (preg_match('/\.(com|co|ac|go|or|net|my)\.id$/i', $fullHost)) {
            $parts = explode('.', $fullHost);
            $ext = '.' . $parts[count($parts)-2] . '.' . $parts[count($parts)-1];
            $hostOnly = str_replace($ext, '', $fullHost);
        } else {
            $ext = substr($fullHost, $posisiTitikTerakhir);
            $hostOnly = substr($fullHost, 0, $posisiTitikTerakhir);
        }

        return [
            'host' => $hostOnly,
            'ext'  => $ext,
            'slug' => $slug
        ];
    }
    return false;
}
