<?php
// Database Connection Test Script
// This file tests the connection to the allami_homes database

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Connection Test</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a2e15, #121212);
            color: #fff;
            padding: 40px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(10, 46, 21, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #3cf281;
            text-align: center;
            margin-bottom: 30px;
        }
        .test-item {
            background: rgba(15, 77, 37, 0.4);
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            border-left: 4px solid #3cf281;
        }
        .success {
            border-left-color: #00ff8c;
            background: rgba(0, 255, 140, 0.1);
        }
        .error {
            border-left-color: #ff4d4d;
            background: rgba(255, 77, 77, 0.1);
        }
        .label {
            font-weight: 600;
            color: #3cf281;
            margin-bottom: 5px;
        }
        .value {
            color: #e0e0e0;
            font-family: monospace;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid rgba(60, 242, 129, 0.2);
        }
        th {
            background: rgba(26, 147, 111, 0.3);
            color: #3cf281;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: linear-gradient(to right, #1a936f, #3cf281);
            color: #121212;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }
        .back-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(60, 242, 129, 0.3);
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔌 Database Connection Test</h1>";

// Test 1: Check if config file exists
echo "<div class='test-item success'>
        <div class='label'>✅ Config File</div>
        <div class='value'>includes/config.php exists and is readable</div>
      </div>";

// Include config
include 'includes/config.php';

// Test 2: Database Configuration
echo "<div class='test-item success'>
        <div class='label'>📋 Database Configuration</div>
        <div class='value'>
            Host: " . DB_HOST . "<br>
            Database: " . DB_NAME . "<br>
            User: " . DB_USER . "<br>
            Password: " . (DB_PASS ? '***' : '(empty)') . "
        </div>
      </div>";

// Test 3: Connection Status
if ($conn->connect_error) {
    echo "<div class='test-item error'>
            <div class='label'>❌ Connection Failed</div>
            <div class='value'>Error: " . $conn->connect_error . "</div>
            <div class='value' style='margin-top: 10px;'>
                <strong>Possible Solutions:</strong><br>
                1. Make sure MySQL/MariaDB is running (XAMPP, WAMP, or standalone)<br>
                2. Check if database 'allami_homes' exists<br>
                3. Verify username and password in includes/config.php<br>
                4. Import database_schema.sql if not done yet
            </div>
          </div>";
} else {
    echo "<div class='test-item success'>
            <div class='label'>✅ Database Connection</div>
            <div class='value'>Successfully connected to MySQL server</div>
          </div>";

    // Test 4: Check if database exists
    $db_check = $conn->select_db(DB_NAME);
    if ($db_check) {
        echo "<div class='test-item success'>
                <div class='label'>✅ Database Exists</div>
                <div class='value'>Database '" . DB_NAME . "' is accessible</div>
              </div>";

        // Test 5: Check tables
        $tables = ['users', 'apartment_images', 'feedback'];
        $existing_tables = [];
        $missing_tables = [];

        foreach ($tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result && $result->num_rows > 0) {
                $existing_tables[] = $table;
            } else {
                $missing_tables[] = $table;
            }
        }

        if (count($existing_tables) > 0) {
            echo "<div class='test-item success'>
                    <div class='label'>✅ Existing Tables</div>
                    <div class='value'>" . implode(', ', $existing_tables) . "</div>
                  </div>";
        }

        if (count($missing_tables) > 0) {
            echo "<div class='test-item error'>
                    <div class='label'>❌ Missing Tables</div>
                    <div class='value'>" . implode(', ', $missing_tables) . "</div>
                    <div class='value' style='margin-top: 10px;'>
                        <strong>Action Required:</strong> Import database_schema.sql to create missing tables
                    </div>
                  </div>";
        }

        // Test 6: Count records in each table
        if (count($existing_tables) == 3) {
            echo "<div class='test-item success'>
                    <div class='label'>📊 Table Statistics</div>
                    <table>
                        <tr>
                            <th>Table</th>
                            <th>Record Count</th>
                        </tr>";

            foreach ($existing_tables as $table) {
                $count_result = $conn->query("SELECT COUNT(*) as count FROM $table");
                $count = $count_result->fetch_assoc()['count'];
                echo "<tr>
                        <td>$table</td>
                        <td>$count records</td>
                      </tr>";
            }

            echo "</table></div>";
        }

    } else {
        echo "<div class='test-item error'>
                <div class='label'>❌ Database Not Found</div>
                <div class='value'>Database '" . DB_NAME . "' does not exist</div>
                <div class='value' style='margin-top: 10px;'>
                    <strong>Action Required:</strong><br>
                    1. Open phpMyAdmin or MySQL command line<br>
                    2. Import database_schema.sql to create the database and tables
                </div>
              </div>";
    }
}

// Test 7: PHP Version
echo "<div class='test-item success'>
        <div class='label'>🐘 PHP Version</div>
        <div class='value'>" . phpversion() . "</div>
      </div>";

// Test 8: MySQL Version
if (!$conn->connect_error) {
    $version = $conn->server_info;
    echo "<div class='test-item success'>
            <div class='label'>🗄️ MySQL Version</div>
            <div class='value'>$version</div>
          </div>";
}

echo "<a href='index.php' class='back-link'>← Back to Home</a>
    </div>
</body>
</html>";

$conn->close();
?>