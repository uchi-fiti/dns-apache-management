<!DOCTYPE html>
<html>
<head>
    <title>Add Domain</title>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div style="margin-left: 220px; padding: 20px;">
        <h1>Add New Domain</h1>
        
        <?php
        if (isset($_GET['success'])) {
            echo '<p style="color: green;">Domain added successfully!</p>';
        }
        if (isset($_GET['error'])) {
            echo '<p style="color: red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
        
        <form action="process_add_domain.php" method="POST">
            <table>
                <tr>
                    <td><label for="domain">Domain:</label></td>
                    <td><input type="text" id="domain" name="domain" placeholder="example.com" required></td>
                </tr>
                <tr>
                    <td><label for="ip_address">IP Address:</label></td>
                    <td><input type="text" id="ip_address" name="ip_address" placeholder="x.x.x.x" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Validate Domain</button>
                        <a href="dns.php"><button type="button">Cancel</button></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
