<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
    $nomor = $desa['nomor_operator'] ?? '';
    $wa    = $nomor && function_exists('format_telpon') ? format_telpon($nomor) : preg_replace('/[^0-9]/', '', $nomor);
    if ($wa && substr($wa, 0, 1) === '0') {
        $wa = '62' . substr($wa, 1);
    }
?>
<?php if (theme_config('chats', '1') == '1' && $wa) : ?>
<?php $teks = rawurlencode('Halo ' . ucwords($this->setting->sebutan_desa) . ' ' . ($desa['nama_desa'] ?? '') . ', saya ingin bertanya.'); ?>
<a href="https://wa.me/<?= $wa ?>?text=<?= $teks ?>" target="_blank" rel="noopener" class="grd-chat-wa" aria-label="Chat WhatsApp">
    <i class="fab fa-whatsapp"></i>
    <span class="grd-chat-wa__label">Chat Kami</span>
</a>
<?php endif ?>
