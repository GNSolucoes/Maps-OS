<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('formatPhone')) {
    function formatPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) > 11) {
            $phone = substr($phone, 0, 13); // Limita tamanho
        }
        return $phone;
    }
}

if (!function_exists('whatsapp_link')) {
    function whatsapp_link($phone, $message = '')
    {
        $phone = formatPhone($phone);
        if (empty($phone)) return '#';
        
        // Adiciona 55 se não tiver (assumindo Brasil)
        if (strlen($phone) <= 11) {
            $phone = '55' . $phone;
        }

        $text = urlencode($message);
        return "https://wa.me/{$phone}?text={$text}";
    }
}
