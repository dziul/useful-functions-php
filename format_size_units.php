<?php

/**
 * Formatar o tamanho da unidade
 * @param number|string $bytes 
 * @param type|bool $modeWritten Modo escrito ou não @example TRUE: 12GB FALSE: 12
 * @return type
 */
function format_size_units($bytes, $modeWritten=false)
{
	$bytes+=0; //caso seja string|converte em numero

    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . $modeWritten ? 'GB': '';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . $modeWritten ? 'MB': '';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . $modeWritten ? 'KB': '';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . $modeWritten ? 'bytes': '';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . $modeWritten ? 'byte': '';
    }
    else
    {
        $bytes = '0' . $modeWritten ? 'byte': '';
    }

    return  !$modeWritten ?  ($bytes+0): $bytes;
}