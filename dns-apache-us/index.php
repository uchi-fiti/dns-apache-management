<!DOCTYPE html>
<html>
<head>
    <title>DNS + APACHE Manager</title>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div style="margin-left: 220px; padding: 20px;">
        <h1>DNS + APACHE Manager</h1>
        <p>Choose which service you want to manage:</p>
        
        <div style="margin-top: 30px;">
            <a href="dns.php" style="display: inline-block; padding: 20px; border: 1px solid #000; margin: 10px; text-decoration: none;">
                <h2>DNS Management</h2>
                <p>Manage DNS domains and records</p>
            </a>
            
            <a href="apache.php" style="display: inline-block; padding: 20px; border: 1px solid #000; margin: 10px; text-decoration: none;">
                <h2>APACHE Management</h2>
                <p>Manage Apache web pages</p>
            </a>
        </div>
    </div>
</body>
</html>
