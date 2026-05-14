<?php
session_start();

if (empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit;
}

$coffees = [
    ["name" => "Daily Coffee",      "category" => "cold",       "price" => 150.00, "image" => "/assets/daily-coffee.jpg"],
    ["name" => "Matcha",            "category" => "cold",       "price" => 160.00, "image" => "/assets/matcha.jpg"],
    ["name" => "Oreo Latte",        "category" => "cold",       "price" => 140.00, "image" => "/assets/oreo.jpg"],
    ["name" => "Caramel Macchiato", "category" => "cold",       "price" => 130.00, "image" => "/assets/caramel.jpg"],
    ["name" => "Salted Caramel",    "category" => "cold",       "price" => 130.00, "image" => "/assets/salted-caramel.jpg"],
    ["name" => "Spanish Latte",     "category" => "cold",       "price" => 130.00, "image" => "/assets/spanish.jpg"],
    ["name" => "Salted Caramel",    "category" => "hot",        "price" => 140.00, "image" => "/assets/salted-caramel.jpg"],
    ["name" => "Spanish Latte",     "category" => "hot",        "price" => 140.00, "image" => "/assets/spanish.jpg"],
    ["name" => "Chocolate Milk",    "category" => "hot",        "price" => 140.00, "image" => "/assets/chocolate.jpg"],
    ["name" => "Caramel Macchiato", "category" => "hot",        "price" => 140.00, "image" => "/assets/caramel.jpg"],
    ["name" => "Oreo Matcha",       "category" => "non-coffee", "price" => 160.00, "image" => "/assets/oreo.jpg"],
    ["name" => "Matcha Latte",      "category" => "non-coffee", "price" => 150.00, "image" => "/assets/matcha.jpg"],
    ["name" => "Oreo Milk",         "category" => "non-coffee", "price" => 130.00, "image" => "/assets/oreo.jpg"],
    ["name" => "Chocolate Milk",    "category" => "non-coffee", "price" => 120.00, "image" => "/assets/chocolate.jpg"],
];


// PAYMENT SUBMISSION
$success = false;
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    $name   = trim($_POST['name']   ?? '');
    $email  = trim($_POST['email']  ?? '');
    $method = $_POST['method']      ?? '';

    if (!$name)   $errors[] = 'Full name is required.';
    if (!$email)  $errors[] = 'Email is required.';
    if (!$method) $errors[] = 'Please select a payment method.';

    if (empty($errors)) {
        $_SESSION['cart'] = [];
        $success = true;
    }
}

// BUILD ORDER SUMMARY
$cartItems = [];
$subtotal  = 0.00;

if (!$success) {
    foreach ($_SESSION['cart'] as $key => $qty) {
        [$itemName, $itemCat] = explode('|', $key);
        foreach ($coffees as $coffee) {
            if ($coffee['name'] === $itemName && $coffee['category'] === $itemCat) {
                $line      = $coffee['price'] * $qty;
                $subtotal += $line;
                $cartItems[] = array_merge($coffee, ['qty' => $qty, 'line_total' => $line]);
                break;
            }
        }
    }
}

$total     = $subtotal;
$cartCount = array_sum($_SESSION['cart']);

function formatPrice(float $p): string {
    return '₱ ' . number_format($p, 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Coffee — Payment</title>
    <link href="./output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Source+Code+Pro:wght@600&display=swap" rel="stylesheet">
</head>
<body class="bg-taupe-50 text-black min-h-screen font-inter flex flex-col">

<!-- NAVBAR -->
<nav class="flex flex-row border-b border-gray-200 bg-taupe-50 sticky top-0 z-50">
    <div class="container mx-auto flex items-center px-3 justify-between py-3">
        <a href="index.php" class="flex items-center gap-2 font-code text-2xl font-semibold tracking-wide">
            <img src="assets/dc_logobg.png" alt="Daily Coffee Logo" class="w-9 h-9" onerror="this.style.display='none'">
            DAILY COFFEE
        </a>
        <div class="flex items-center gap-4 text-sm">
            <a href="menu.php"      class="hover:underline underline-offset-4">Menu</a>
            <a href="about-us.php" class="hover:underline underline-offset-4">About Us</a>
            <a href="cart.php"
               class="flex items-center gap-1 bg-olive-600 hover:bg-olive-700 text-white px-4 py-2 rounded text-sm font-medium">
                Cart
                <span class="text-white font-bold flex items-center justify-center text-sm">
                    <?= $cartCount ?>
                </span>
            </a>
        </div>
    </div>
</nav>

<main class="container mx-auto px-4 py-10 flex-1">

    <?php if ($success): ?>
    <!-- ORDER PLACED -->
    <div class="max-w-md mx-auto text-center py-24">
        <div class="text-5xl mb-6"></div>
        <h1 class="font-[Newsreader] text-4xl font-bold mb-3">Order placed!</h1>
        <p class="text-gray-500 mb-8">Thank you! Your order will be ready for pick-up shortly.</p>
        <a href="menu.php"
           class="bg-olive-600 hover:bg-olive-700 text-white px-6 py-3 rounded text-sm font-medium">
            Back to Menu
        </a>
    </div>

    <?php else: ?>
        <!-- HERO BAR -->
    <div class="mb-8 border-b border-gray-200 pb-4">
        <h1 class="font-[Newsreader] text-5xl font-bold">Payment</h1>
    </div>

    <?php if ($errors): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 rounded p-4 mb-6 text-sm">
        <ul class="list-disc list-inside space-y-1">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <!-- PAYMENT -->
        <form method="post" action="payment.php" class="flex-1 flex flex-col gap-6">

            <div class="bg-taupe-100 border border-taupe-200 rounded-lg p-6">
                <h2 class="font-semibold text-sm mb-4 uppercase tracking-wide">Contact Information</h2>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Full Name</label>
                        <input type="text" name="name"
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                               placeholder="Juan dela Cruz"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-olive-600 bg-white">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Email</label>
                        <input type="email" name="email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               placeholder="juan@example.com"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-olive-600 bg-white">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Contact Number <span class="text-gray-400">(optional)</span></label>
                        <input type="text" name="contact"
                               value="<?= htmlspecialchars($_POST['contact'] ?? '') ?>"
                               placeholder="09XX XXX XXXX"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-olive-600 bg-white">
                    </div>
                </div>
            </div>

            <div class="bg-taupe-100 border border-taupe-200 rounded-lg p-6">
                <h2 class="font-semibold text-sm mb-4 uppercase tracking-wide">Payment Method</h2>
                <div class="flex flex-col gap-3">
                    <?php
                    $methods  = ['cash' => 'Cash on Pick-up', 'gcash' => 'GCash', 'maya' => 'Maya'];
                    $selected = $_POST['method'] ?? 'cash';
                    foreach ($methods as $val => $label):
                    ?>
                    <label class="flex items-center gap-3 cursor-pointer bg-white border border-gray-200 rounded px-4 py-3 hover:border-olive-600">
                        <input type="radio" name="method" value="<?= $val ?>"
                               <?= $selected === $val ? 'checked' : '' ?>
                               class="accent-olive-600">
                        <span class="text-sm"><?= $label ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-taupe-100 border border-taupe-200 rounded-lg p-4 text-sm text-gray-600">
                <strong>Pick-up only</strong> — Your order will be ready at our store in Vintar, Ilocos Norte.
            </div>

            <button type="submit" name="pay" value="1"
                    class="w-full bg-olive-600 hover:bg-olive-700 text-white py-3 rounded font-medium text-sm flex items-center justify-between px-6">
                Place Order <span>→</span>
            </button>
        </form>

        <!-- ORDER SUMMARY -->
        <div class="w-full lg:w-72 flex-shrink-0">
            <div class="bg-taupe-100 border border-taupe-200 rounded-lg p-5">
                <p class="font-semibold text-sm mb-4">Order summary</p>

                <div class="flex flex-col gap-3 mb-4">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="flex items-center gap-3">
                        <img src="<?= htmlspecialchars($item['image']) ?>"
                             alt="<?= htmlspecialchars($item['name']) ?>"
                             class="w-12 h-12 object-cover rounded flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-wide truncate">
                                <?= htmlspecialchars($item['name']) ?>
                            </p>
                            <p class="text-xs text-gray-500"><?= $item['qty'] ?> pc<?= $item['qty'] !== 1 ? 's' : '' ?></p>
                        </div>
                        <p class="text-sm font-bold flex-shrink-0"><?= formatPrice($item['line_total']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-gray-300 pt-3 flex flex-col gap-1 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span><span><?= formatPrice($subtotal) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span><span>₱ 00.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-black border-t border-gray-300 pt-2 mt-1">
                        <span>Total</span><span><?= formatPrice($total) ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>

</main>

    <footer class="bg-taupe-100 border-t border-taupe-200 text-center py-8 text-sm text-gray-700 tracking-wide mt-auto">
        <p class="font-semibold">CONTACT US</p>
        <p class="mt-2 text-gray-500">Vintar, Ilocos Norte | 096971287654 | dailydosecoffee@gmail.com</p>
    </footer>

</body>
</html>
