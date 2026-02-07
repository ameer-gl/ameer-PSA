<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/login.php");
    exit;
}

include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Allami Homes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
            :root {
            --dark-green: #0a2e15;
            --medium-green: #0f4d25;
            --light-green: #1a936f;
            --accent-green: #3cf281;
            --black: #121212;
            --dark-gray: #1e1e1e;
            --white: #ffffff;
            --light-gray: #f1f1f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        .admin-header {
            background-color: rgba(10, 46, 21, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid var(--light-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--accent-green), var(--light-green));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }

        .admin-logo-icon {
            color: var(--accent-green);
            font-size: 2rem;
            animation: pulse 2s infinite;
        }

        .admin-nav {
            display: flex;
            gap: 1.5rem;
        }

        .admin-nav-link {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .admin-nav-link:hover {
            background-color: var(--medium-green);
            color: var(--accent-green);
        }

        .btn-logout {
            padding: 0.7rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            background: transparent;
            color: var(--accent-green);
            border: 2px solid var(--accent-green);
        }

        .btn-logout:hover {
            background: var(--accent-green);
            color: var(--black);
            box-shadow: 0 0 15px var(--accent-green);
            transform: translateY(-3px);
        }

        /* Main Content */
        .admin-dashboard {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .dashboard-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
            background: linear-gradient(to right, var(--accent-green), var(--light-green));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .dashboard-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, transparent, var(--accent-green), transparent);
        }

        /* Sections */
        .dashboard-section {
            background: linear-gradient(145deg, var(--dark-green), var(--black));
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 3rem;
            border: 1px solid rgba(60, 242, 129, 0.1);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease;
        }

        .dashboard-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 0;
            background: var(--accent-green);
            transition: height 0.5s ease;
        }

        .dashboard-section:hover::before {
            height: 100%;
        }

        .section-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--accent-green);
        }

        /* Forms */
        .admin-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--light-gray);
        }

        .form-input, .form-select {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            border: 1px solid var(--medium-green);
            background-color: var(--dark-gray);
            color: var(--white);
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: var(--accent-green);
            box-shadow: 0 0 10px rgba(60, 242, 129, 0.3);
        }

        .form-button {
            grid-column: span 2;
            padding: 1rem;
            border-radius: 8px;
            border: none;
            background: linear-gradient(to right, var(--light-green), var(--accent-green));
            color: var(--black);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .form-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(60, 242, 129, 0.4);
        }

        /* Feedback Section */
        .feedback-container {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .feedback-item {
            background-color: var(--dark-gray);
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 3px solid var(--accent-green);
            animation: slideIn 0.5s ease;
        }

        .feedback-user {
            font-weight: 600;
            color: var(--accent-green);
            margin-bottom: 0.5rem;
        }

        .feedback-message {
            color: var(--light-gray);
            margin-bottom: 0.5rem;
        }

        .feedback-date {
            font-size: 0.9rem;
            color: var(--light-green);
            font-style: italic;
        }

        /* Animations */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 992px) {
            .admin-form {
                grid-template-columns: 1fr;
            }
            
            .form-button {
                grid-column: span 1;
            }
        }

        @media screen and (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            
            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
        }

        @media screen and (max-width: 480px) {
            .admin-dashboard {
                padding: 0 1rem;
            }
            
            .dashboard-section {
                padding: 1.5rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--medium-green);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--light-green);
        }/
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-logo">
            <div class="admin-logo-icon"><i class="fas fa-building"></i></div>
            <div class="admin-logo-text">ALLAMI HOMES | ADMIN</div>
        </div>
        <a href="auth/logout.php" class="btn-logout">Logout</a>
    </header>

    <div class="admin-dashboard">
        <h1 class="dashboard-title">Admin Dashboard</h1>

        <!-- Upload/Edit Images Section -->
        <section class="dashboard-section image-management">
            <h2 class="section-title">Manage Apartment Images</h2>
            <form action="upload-image.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-group">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category" class="form-select" required>
                        <option value="aerial">Aerial</option>
                        <option value="eyelevel">Eye Level</option>
                        <option value="blueprint">Blueprint</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="slot_number" class="form-label">Slot Number (1–19):</label>
                    <input type="number" name="slot_number" class="form-input" min="1" max="19" required>
                </div>
                
                <div class="form-group">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" name="image" class="form-input" accept="image/*" required>
                </div>
                
                <button type="submit" class="form-button">Upload/Replace Image</button>
            </form>
        </section>

        <!-- Existing Images List (Edit/Delete) -->
        <section class="dashboard-section">
            <h2 class="section-title">Current Apartment Images</h2>
            <div class="feedback-container">
                <?php
                $images = $conn->query("SELECT * FROM apartment_images ORDER BY id DESC");
                if ($images->num_rows > 0) {
                    while ($img = $images->fetch_assoc()) {
                        echo "
                        <div class='feedback-item'>
                            <div class='feedback-user'>Category: {$img['category']} | Slot: {$img['slot_number']}</div>
                            <div class='feedback-message'>
   <img src='uploads/{$img['image_path']}' alt='Apartment Image' style='max-width:200px; border-radius:8px;'>

</div>

                            <div style='margin-top:10px; display:flex; gap:10px;'>
                                <!-- Edit -->
                                <form action='edit-image.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='{$img['id']}'>
                                    <input type='file' name='new_image' accept='image/*' required>
                                    <button type='submit' style='background:#4CAF50; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;'>Edit</button>
                                </form>
                                <!-- Delete -->
                                <form action='delete-image.php' method='POST' onsubmit=\"return confirm('Delete this image?');\">
                                    <input type='hidden' name='id' value='{$img['id']}'>
                                    <button type='submit' style='background:#ff4d4d; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;'>Delete</button>
                                </form>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<div class='feedback-item'>
                            <div class='feedback-message'>No apartment images uploaded yet.</div>
                          </div>";
                }
                ?>
            </div>
        </section>

        <!-- Show User Feedback -->
        <section class="dashboard-section feedback-admin">
            <h2 class="section-title">User Feedback</h2>
            <div class="feedback-container">
                <?php
                $result = $conn->query("
                    SELECT f.*, u.username 
                    FROM feedback f 
                    JOIN users u ON f.user_id = u.id 
                    ORDER BY f.created_at DESC
                ");
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='feedback-item'>
                                <div class='feedback-user'>{$row['username']}</div>
                                <div class='feedback-message'>{$row['message']}</div>
                                <div class='feedback-date'>{$row['created_at']}</div>
                                <form action='delete-feedback.php' method='POST' style='margin-top:10px;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' style='background:#ff4d4d; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;' onclick=\"return confirm('Delete this feedback?')\">Delete</button>
                                </form>
                              </div>";
                    }
                } else {
                    echo "<div class='feedback-item'>
                            <div class='feedback-message'>No feedback submitted yet.</div>
                          </div>";
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>
