@php
    $grdChatWa = null;

    try {
        if (theme_config('chats', '1') == '1') {
            $nomor = $desa['nomor_operator'] ?? '';
            $wa    = $nomor && function_exists('format_telpon')
                ? format_telpon($nomor)
                : preg_replace('/[^0-9]/', '', (string) $nomor);

            if ($wa && substr($wa, 0, 1) === '0') {
                $wa = '62' . substr($wa, 1);
            }

            if ($wa) {
                $teks = rawurlencode('Halo ' . ucwords(setting('sebutan_desa')) . ' ' . ($desa['nama_desa'] ?? '') . ', saya ingin bertanya.');

                $grdChatWa = [
                    'wa'   => $wa,
                    'teks' => $teks,
                ];
            }
        }
    } catch (\Throwable $e) {
        $grdChatWa = null;
    }
@endphp

@if ($grdChatWa)
    <a href="https://wa.me/{{ $grdChatWa['wa'] }}?text={{ $grdChatWa['teks'] }}" target="_blank" rel="noopener" class="grd-chat-wa" aria-label="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="grd-chat-wa__label">Chat Kami</span>
    </a>
@endif
