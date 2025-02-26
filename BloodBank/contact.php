<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bbms";

    $conn = new mysqli($servername, $username, $password, $database);

    $fullname = trim($_POST['fullname']);
    $contactno = trim($_POST['contactno']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($fullname) || empty($contactno) || empty($email) || empty($message)) {
        $_SESSION['message_error'] = "All fields are required.";
        header("Location: contact.php");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (fullname, contactno, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $contactno, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['message_sent'] = true;
    } else {
        $_SESSION['message_error'] = "Failed to send message. Please try again.";
    }

    $stmt->close();
    $conn->close();

    header("Location: contact.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contact Us - BloodBank</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1524721696987-b9527df9e512?q=80&w=1933&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .footer {
            background: transparent;
            color: black;
            padding: 20px 0;
            text-align: center;
            margin-top: 30px;
        }
        .footer a {
            color: black;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <?php $active = "contact"; include('head.php'); ?>
    </div>

    <div id="page-container" style="margin-top:50px; position: relative; min-height: 84vh;">
        <div class="container">
            <h1 class="mt-4 mb-3 text-primary">Contact</h1>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <h3 class="text-secondary">Send us a Message</h3>
                    <form method="post">
                        <div class="form-group">
                            <label>Full Name:</label>
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number:</label>
                            <input type="tel" class="form-control" name="contactno" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Message:</label>
                            <textarea rows="4" class="form-control" name="message" required></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>Contact Us</h4>
                    <p><strong>Address:</strong> Siddeshwari, Dhaka</p>
                    <p><strong>Phone:</strong> +880-12345678</p>
                    <p><strong>Email:</strong> <a href="mailto:shahriarhossain20@gmail.com">shahriarhossain20@gmail.com</a></p>
                </div>
                <div class="col-md-6">
                    <h4>Follow Us</h4>
                    <p><a href="#">Facebook</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            <?php if (isset($_SESSION['message_sent']) && $_SESSION['message_sent']): ?>
                alert("Message sent successfully!");
                <?php unset($_SESSION['message_sent']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['message_error'])): ?>
                alert("<?php echo $_SESSION['message_error']; ?>");
                <?php unset($_SESSION['message_error']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
