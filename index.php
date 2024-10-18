<?php

function testExtractValidDatesSTOA($text) {
    $expected = ["01/01/2024", "15/08/2023"];
    $result = extractValidDates($text);

    if (count($result) != count($expected)) {
        error_log("[FAIL] Expected " . count($expected) . " dates, got " . count($result));
        return false;
    }

    foreach ($expected as $i => $v) {
        if ($result[$i] != $v) {
            error_log("[FAIL] Expected $v, got " . $result[$i]);
            return false;
        }
    }

    return true;
}

function testExtractValidIPsSTOA($text) {
    $expected = ["192.168.0.1", "10.0.0.1", "172.16.254.1"];
    $result = extractValidIPs($text);

    if (count($result) != count($expected)) {
        error_log("[FAIL] Expected " . count($expected) . " IPs, got " . count($result));
        return false;
    }

    foreach ($expected as $i => $v) {
        if ($result[$i] != $v) {
            error_log("[FAIL] Expected $v, got " . $result[$i]);
            return false;
        }
    }

    return true;
}

function testExtractMonetaryValuesSTOA($text) {
    $expected = ["1.000,00", "-50,75", "12.345,67", "1.300.000,00", "1500,00"];
    $result = extractMonetaryValues($text);

    if (count($result) != count($expected)) {
        error_log("[FAIL] Expected " . count($expected) . " monetary values, got " . count($result));
        return false;
    }

    foreach ($expected as $i => $v) {
        if ($result[$i] != $v) {
            error_log("[FAIL] Expected $v, got " . $result[$i]);
            return false;
        }
    }

    return true;
}

// Função para validar expressoes regulares
function extractValidDates($text) {
    $pattern = '/\b\d{2}\/\d{2}\/\d{4}\b/';
    preg_match_all($pattern, $text, $matches);
    return $matches[0] ?? [];
}

// Função responsável por extrair e validar datas
function testExtractValidDates($text) {
    $expected = ["01/01/2024", "15/08/2023", "29/02/2023"];
    $result = extractValidDates($text);
    
    if (count($result) != count($expected)) {
        error_log("[FAIL] Expected " . count($expected) . " dates, got " . count($result));
        return false;
    }

    foreach ($expected as $i => $v) {
        if ($result[$i] != $v) {
            error_log("[FAIL] Expected $v, got " . $result[$i]);
            return false;
        }
    }
    return true;
}

// Função para validar expressoes regulares
function extractValidIPs($text) {
    // Regex para capturar IPs válidos no formato IPv4
    $pattern = '/\b(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/';
    preg_match_all($pattern, $text, $matches);
    return $matches[0] ?? [];
}

// Função responsável por extrair e validar IPs
function testExtractValidIPs($text) {
    $expected = ["192.168.0.1", "10.0.0.1", "172.16.254.1"];
    $result = extractValidIPs($text);

    if (count($result) != count($expected)) {
        error_log("[FAIL] Expected " . count($expected) . " IPs, got " . count($result));
        return false;
    }

    foreach ($expected as $i => $v) {
        if ($result[$i] != $v) {
            error_log("[FAIL] Expected $v, got " . $result[$i]);
            return false;
        }
    }
    return true;
}

// Função para validar expressoes regulares
function extractMonetaryValues($text) {
    // Regex para capturar valores monetários formatados corretamente
    $pattern = '/-?\s*R\$\s*\d{1,3}(?:\.\d{3})*,\d{2}/';
    preg_match_all($pattern, $text, $matches);

    // Remove espaços em branco indesejados antes dos valores capturados
    return array_map('trim', $matches[0] ?? []);
}

// Função responsável por extrair e validar valores
function testExtractMonetaryValues($text) {
    $expected = ["R$ 1.000,00", "-R$ 50,75", "R$ 12.345,67", "R$ 1.500,00", "R$ 1.300.000,00"];
    $result = extractMonetaryValues($text);

    if (count($result) != count($expected)) {
        error_log("[FAIL] Expected " . count($expected) . " monetary values, got " . count($result));
        return false;
    }

    foreach ($expected as $i => $v) {
        if ($result[$i] != $v) {
            error_log("[FAIL] Expected $v, got " . $result[$i]);
            return false;
        }
    }
    return true;
}

echo "Running tests...\n";
$t1 = testExtractValidDates("Datas:\n- 01/01/2024\n- 15/08/2023\n- 29/02/2023");
$t2 = testExtractValidIPs("Lista de ips:\n- 192.168.0.1\n- 10.0.0.1\n- 172.16.254.1\n- 1192.168.0.1\n- 300.0.0.1");
$t3 = testExtractMonetaryValues("Os valores são: \n R$ 1.000,00\n -R$ 50,75\n R$ 12.345,67\n R$ 1.500,00\n R$ 1.300.000,00");

if ($t1 && $t2 && $t3) {
    echo "Parabéns, você terminou a prova!\n";
} else {
    echo "Falhas ainda foram encontradas...\n";
}