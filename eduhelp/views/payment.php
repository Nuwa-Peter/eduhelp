<?php
if (!isset($_GET['school_id'])) {
    die('No school ID provided.');
}

$school_id = $_GET['school_id'];
?>

<h1>Mock Payment Gateway</h1>
<p>This is a mock payment gateway for testing purposes.</p>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Payment Details</h5>
        <p>
            <b>School ID:</b> <?php echo $school_id; ?><br>
            <b>Amount:</b> 100,000 UGX
        </p>
        <form action="scripts/process_payment.php" method="POST">
            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">
            <input type="hidden" name="amount" value="100000">
            <input type="hidden" name="transaction_id" value="<?php echo uniqid('txn_'); ?>">
            <button type="submit" class="btn btn-success">Pay Now</button>
        </form>
    </div>
</div>
