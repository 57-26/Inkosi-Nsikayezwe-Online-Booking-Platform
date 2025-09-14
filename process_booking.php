<?php
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Get form data
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $tableNumber = intval($_POST['table'] ?? 0);
    $seatNumber = intval($_POST['seat'] ?? 0);
    $paymentMethod = trim($_POST['payment'] ?? '');
    
    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || 
        empty($address) || $tableNumber <= 0 || $seatNumber <= 0 || empty($paymentMethod)) {
        throw new Exception('All fields are required');
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    // Validate table and seat numbers
    if ($tableNumber < 1 || $tableNumber > 20) {
        throw new Exception('Invalid table number');
    }
    
    if ($seatNumber < 1 || $seatNumber > 10) {
        throw new Exception('Invalid seat number');
    }
    
    // Check if seat is already taken
    $checkSeat = $db->prepare("
        SELECT COUNT(*) as count 
        FROM ticket_purchases 
        WHERE table_number = ? AND seat_number = ?
    ");
    $checkSeat->execute([$tableNumber, $seatNumber]);
    $seatTaken = $checkSeat->fetch()['count'] > 0;
    
    if ($seatTaken) {
        throw new Exception('This seat is already taken. Please select another seat.');
    }
    
    // Start transaction
    $db->beginTransaction();
    
    try {
        // Check if customer already exists
        $checkCustomer = $db->prepare("
            SELECT customer_id FROM customers 
            WHERE email = ?
        ");
        $checkCustomer->execute([$email]);
        $existingCustomer = $checkCustomer->fetch();
        
        $customerId = null;
        
        if ($existingCustomer) {
            $customerId = $existingCustomer['customer_id'];
        } else {
            // Create new customer
            $insertCustomer = $db->prepare("
                INSERT INTO customers (first_name, last_name, email, phone, address, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $insertCustomer->execute([$firstName, $lastName, $email, $phone, $address]);
            $customerId = $db->lastInsertId();
        }
        
        // Get event configuration for pricing
        $getConfig = $db->prepare("
            SELECT vip_price, general_price, vip_tables, royalty_tables 
            FROM event_config 
            ORDER BY last_updated DESC 
            LIMIT 1
        ");
        $getConfig->execute();
        $config = $getConfig->fetch();
        
        if (!$config) {
            throw new Exception('Event configuration not found');
        }
        
        // Determine ticket price based on table number
        $ticketPrice = 0;
        if ($tableNumber <= 2) {
            // Kings & Mayors - invitation only
            $ticketPrice = 0;
        } elseif ($tableNumber <= 4) {
            // VIP tables
            $ticketPrice = $config['vip_price'];
        } else {
            // General tables
            $ticketPrice = $config['general_price'];
        }
        
        // Create booking request
        $insertBooking = $db->prepare("
            INSERT INTO booking_requests (
                first_name, last_name, email, phone, address, 
                table_number, seat_number, payment_method, 
                payment_status, submission_date, expires_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), DATE_ADD(NOW(), INTERVAL 24 HOUR))
        ");
        $insertBooking->execute([
            $firstName, $lastName, $email, $phone, $address,
            $tableNumber, $seatNumber, $paymentMethod
        ]);
        $bookingId = $db->lastInsertId();
        
        // Create ticket purchase record
        $insertPurchase = $db->prepare("
            INSERT INTO ticket_purchases (
                customer_id, table_number, seat_number, payment_method, 
                payment_status, amount_paid, purchase_date
            ) VALUES (?, ?, ?, ?, 'pending', ?, NOW())
        ");
        $insertPurchase->execute([
            $customerId, $tableNumber, $seatNumber, $paymentMethod, $ticketPrice
        ]);
        $purchaseId = $db->lastInsertId();
        
        // Commit transaction
        $db->commit();
        
        // Generate payment reference
        $paymentReference = 'RG' . str_pad($purchaseId, 6, '0', STR_PAD_LEFT);
        
        // Update payment reference
        $updateRef = $db->prepare("
            UPDATE ticket_purchases 
            SET payment_reference = ? 
            WHERE purchase_id = ?
        ");
        $updateRef->execute([$paymentReference, $purchaseId]);
        
        // Send response
        echo json_encode([
            'success' => true,
            'message' => 'Booking request submitted successfully',
            'data' => [
                'booking_id' => $bookingId,
                'purchase_id' => $purchaseId,
                'payment_reference' => $paymentReference,
                'amount' => $ticketPrice,
                'table_number' => $tableNumber,
                'seat_number' => $seatNumber,
                'payment_method' => $paymentMethod
            ]
        ]);
        
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>