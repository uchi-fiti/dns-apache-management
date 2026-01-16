<!DOCTYPE html>
<html>
<head>
    <title>DNS Management</title>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div style="margin-left: 220px; padding: 20px;">
        <h1>DNS Domains</h1>
        
        <p><a href="add_domain.php">
            <button>Add Domain</button>
        </a></p>
        
        <h2>Existing Domains</h2>
        
        <?php
        $namedConfFile = './etc/bind/named.conf.local';
        
        if (file_exists($namedConfFile)) {
            $content = file_get_contents($namedConfFile);
            
            // Parse zones from the file
            preg_match_all('/zone\s+"([^"]+)"\s+{/', $content, $matches);
            
            if (!empty($matches[1])) {
                echo '<table border="1" cellpadding="10">';
                echo '<tr><th>Domain</th><th>Actions</th></tr>';
                
                foreach ($matches[1] as $domain) {
                    echo '<tr>';
                    echo '<td><a href="records.php?domain=' . urlencode($domain) . '">' . htmlspecialchars($domain) . '</a></td>';
                    echo '<td>';
                    echo '<a href="delete_domain.php?domain=' . urlencode($domain) . '" onclick="return confirm(\'Are you sure you want to delete ' . htmlspecialchars($domain) . '?\');">';
                    echo '<button>Delete</button>';
                    echo '</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                
                echo '</table>';
            } else {
                echo '<p>No domains found.</p>';
            }
        } else {
            echo '<p>Configuration file not found.</p>';
        }
        ?>
        
    </div>
</body>
</html>
