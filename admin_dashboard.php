<?php
require_once 'config/database.php';

// Simple authentication (in production, use proper authentication)
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['admin_password']) && $_POST['admin_password'] === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin Login</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; padding: 20px; }
                .form-group { margin-bottom: 15px; }
                label { display: block; margin-bottom: 5px; }
                input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
                button { background: #1a365d; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
            </style>
        </head>
        <body>
            <h2>Admin Login</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="admin_password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </body>
        </html>
        <?php
        exit;
    }
}

$database = new Database();
$db = $database->getConnection();

// Handle status updates
if (isset($_POST['update_status'])) {
    $purchaseId = intval($_POST['purchase_id']);
    $newStatus = $_POST['new_status'];
    
    $update = $db->prepare("
        UPDATE ticket_purchases 
        SET payment_status = ? 
        WHERE purchase_id = ?
    ");
    $update->execute([$newStatus, $purchaseId]);
    
    $updateBooking = $db->prepare("
        UPDATE booking_requests 
        SET payment_status = ? 
        WHERE request_id = (
            SELECT request_id FROM booking_requests 
            WHERE table_number = (SELECT table_number FROM ticket_purchases WHERE purchase_id = ?) 
            AND seat_number = (SELECT seat_number FROM ticket_purchases WHERE purchase_id = ?)
            LIMIT 1
        )
    ");
    $updateBooking->execute([$newStatus, $purchaseId, $purchaseId]);
}

// Get all bookings
$bookings = $db->query("
    SELECT 
        tp.purchase_id,
        tp.payment_reference,
        c.first_name,
        c.last_name,
        c.email,
        c.phone,
        tp.table_number,
        tp.seat_number,
        tp.payment_method,
        tp.payment_status,
        tp.amount_paid,
        tp.purchase_date
    FROM ticket_purchases tp
    JOIN customers c ON tp.customer_id = c.customer_id
    ORDER BY tp.purchase_date DESC
")->fetchAll();

// Get statistics
$stats = $db->query("
    SELECT 
        COUNT(*) as total_bookings,
        SUM(CASE WHEN payment_status = 'completed' THEN 1 ELSE 0 END) as completed_bookings,
        SUM(CASE WHEN payment_status = 'pending' THEN 1 ELSE 0 END) as pending_bookings,
        SUM(CASE WHEN payment_status = 'completed' THEN amount_paid ELSE 0 END) as total_revenue
    FROM ticket_purchases
")->fetch();

// Get seat availability
$seatAvailability = $db->query("
    SELECT 
        table_number,
        seat_number,
        payment_status,
        CONCAT(c.first_name, ' ', c.last_name) as customer_name
    FROM ticket_purchases tp
    JOIN customers c ON tp.customer_id = c.customer_id
    ORDER BY table_number, seat_number
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Royal Gala - Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: #1a365d; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 2em; font-weight: bold; color: #1a365d; }
        .section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-completed { color: #28a745; font-weight: bold; }
        .status-cancelled { color: #dc3545; font-weight: bold; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .seating-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
        .seat { padding: 10px; border: 1px solid #ddd; border-radius: 4px; text-align: center; font-size: 12px; }
        .seat.available { background: #d4edda; }
        .seat.occupied { background: #f8d7da; }
        .seat.vip { background: #e2e3e5; }
        .seat.royalty { background: #fff3cd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Royal Gala Admin Dashboard</h1>
            <p>Manage bookings and monitor event progress</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total_bookings'] ?></div>
                <div>Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['completed_bookings'] ?></div>
                <div>Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['pending_bookings'] ?></div>
                <div>Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">R<?= number_format($stats['total_revenue'], 2) ?></div>
                <div>Total Revenue</div>
            </div>
        </div>

        <div class="section">
            <h2>Seating Chart</h2>
            <div class="seating-grid">
                <?php
                $seats = [];
                foreach ($seatAvailability as $seat) {
                    $seats[$seat['table_number']][$seat['seat_number']] = $seat;
                }
                
                for ($table = 1; $table <= 20; $table++) {
                    $tableClass = 'seat';
                    if ($table <= 2) $tableClass .= ' royalty';
                    elseif ($table <= 4) $tableClass .= ' vip';
                    
                    echo "<div class='$tableClass'>";
                    echo "<strong>Table $table</strong><br>";
                    
                    for ($seat = 1; $seat <= 10; $seat++) {
                        if (isset($seats[$table][$seat])) {
                            $seatInfo = $seats[$table][$seat];
                            $statusClass = $seatInfo['payment_status'] === 'completed' ? 'occupied' : 'available';
                            echo "<div class='$statusClass'>S$seat: {$seatInfo['customer_name']}</div>";
                        } else {
                            echo "<div class='available'>S$seat: Available</div>";
                        }
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <div class="section">
            <h2>All Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Table</th>
                        <th>Seat</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $booking['purchase_id'] ?></td>
                        <td><?= htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']) ?></td>
                        <td><?= htmlspecialchars($booking['email']) ?></td>
                        <td><?= htmlspecialchars($booking['phone']) ?></td>
                        <td><?= $booking['table_number'] ?></td>
                        <td><?= $booking['seat_number'] ?></td>
                        <td><?= ucfirst($booking['payment_method']) ?></td>
                        <td>R<?= number_format($booking['amount_paid'], 2) ?></td>
                        <td class="status-<?= $booking['payment_status'] ?>">
                            <?= ucfirst($booking['payment_status']) ?>
                        </td>
                        <td><?= date('Y-m-d H:i', strtotime($booking['purchase_date'])) ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="purchase_id" value="<?= $booking['purchase_id'] ?>">
                                <select name="new_status" onchange="this.form.submit()">
                                    <option value="pending" <?= $booking['payment_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="completed" <?= $booking['payment_status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $booking['payment_status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>