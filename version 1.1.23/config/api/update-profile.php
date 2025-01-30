<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

try {
    // Input validation
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
    $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
    $location = trim(filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING));
    $bio = trim(filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING));

    if (empty($username) || empty($email)) {
        throw new Exception('All fields are required');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    $db = getDB();
    $db->beginTransaction();

    // Check if username exists
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE username = ? AND id != ?");
    if (!$stmt->execute([$username, $_SESSION['user_id']])) {
        throw new Exception('Database error while checking username');
    }
    
    if ($stmt->fetch()['count'] > 0) {
        throw new Exception('Username already taken');
    }

    // Check if email exists
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE email = ? AND id != ?");
    if (!$stmt->execute([$email, $_SESSION['user_id']])) {
        throw new Exception('Database error while checking email');
    }
    
    if ($stmt->fetch()['count'] > 0) {
        throw new Exception('Email already taken');
    }

    // Update profile
    $stmt = $db->prepare("
        UPDATE users 
        SET username = ?, 
            email = ?,
            first_name = ?,
            last_name = ?,
            phone = ?,
            location = ?,
            bio = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
    ");
    if (!$stmt->execute([
        $username, 
        $email, 
        $first_name, 
        $last_name, 
        $phone, 
        $location, 
        $bio, 
        $_SESSION['user_id']
    ])) {
        throw new Exception('Failed to update profile');
    }

    // Update session
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['phone'] = $phone;
    $_SESSION['location'] = $location;
    $_SESSION['bio'] = $bio;

    $db->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Profile updated successfully',
        'data' => [
            'username' => $username,
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'location' => $location,
            'bio' => $bio
        ]
    ]);

} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    error_log('Profile Update Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
