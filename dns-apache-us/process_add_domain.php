<?php
// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_domain.php');
    exit;
}

// Get form data
$domain = trim($_POST['domain']);
$ip_address = trim($_POST['ip_address']);

// Basic validation
if (empty($domain) || empty($ip_address)) {
    header('Location: add_domain.php?error=Domain and IP address are required');
    exit;
}

// Validate IP address format
if (!filter_var($ip_address, FILTER_VALIDATE_IP)) {
    header('Location: add_domain.php?error=Invalid IP address format');
    exit;
}

// Validate domain format (basic)
if (!preg_match('/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $domain)) {
    header('Location: add_domain.php?error=Invalid domain format');
    exit;
}

// File paths
$namedConfFile = './etc/bind/named.conf.local';
$zoneFile = './etc/bind/zones/db.' . $domain;
$templateFile = './etc/bind/db.template';

// Check if domain already exists
if (file_exists($namedConfFile)) {
    $content = file_get_contents($namedConfFile);
    if (strpos($content, 'zone "' . $domain . '"') !== false) {
        header('Location: add_domain.php?error=Domain already exists');
        exit;
    }
}

try {
    // 1. Append to named.conf.local
    $zoneConfig = "\nzone \"$domain\" {\n";
    $zoneConfig .= "    type master;\n";
    $zoneConfig .= "    file './etc/bind/zones/db.$domain';\n";
    $zoneConfig .= "};\n";
    
    if (file_put_contents($namedConfFile, $zoneConfig, FILE_APPEND) === false) {
        throw new Exception('Failed to write to named.conf.local');
    }
    
    // 2. Create zone file from template
    if (!file_exists($templateFile)) {
        throw new Exception('Template file not found');
    }
    
    $templateContent = file_get_contents($templateFile);
    
    // Replace placeholders
    $zoneContent = str_replace('{DOMAIN}', $domain, $templateContent);
    $zoneContent = str_replace('{IP_ADDRESS}', $ip_address, $zoneContent);
    
    // Make sure zones directory exists
    $zonesDir = './etc/bind/zones';
    if (!is_dir($zonesDir)) {
        mkdir($zonesDir, 0755, true);
    }
    
    if (file_put_contents($zoneFile, $zoneContent) === false) {
        throw new Exception('Failed to create zone file');
    }
    
    // Success!
    header('Location: add_domain.php?success=1');
    exit;
    
} catch (Exception $e) {
    header('Location: add_domain.php?error=' . urlencode($e->getMessage()));
    exit;
}
?>
