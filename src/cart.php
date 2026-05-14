<?php
session_start();

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

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ─── Remove item ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    unset($_SESSION['cart'][$_POST['remove']]);
    header('Location: cart.php');
    exit;
}

// ─── Update quantity ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    $key = $_POST['item_key'];
    $qty = (int) $_POST['quantity'];
    if ($qty <= 0) {
        unset($_SESSION['cart'][$key]);
    } else {
        $_SESSION['cart'][$key] = $qty;
    }
    header('Location: cart.php');
    exit;
}

// ─── Build cart items ─────────────────────────────────────────────────────────
// Cart key is "name|category" (same as menu.php)
$cartItems = [];
$subtotal  = 0.00;

foreach ($_SESSION['cart'] as $key => $qty) {
    [$itemName, $itemCat] = explode('|', $key);
    foreach ($coffees as $coffee) {
        if ($coffee['name'] === $itemName && $coffee['category'] === $itemCat) {
            $line      = $coffee['price'] * $qty;
            $subtotal += $line;
            $cartItems[] = [
                'key'        => $key,
                'name'       => $coffee['name'],
                'price'      => $coffee['price'],
                'image'      => $coffee['image'],
                'qty'        => $qty,
                'line_total' => $line,
            ];
            break;
        }
    }
}

$cartCount = array_sum($_SESSION['cart']);
$total     = $subtotal;

function formatPrice(float $p): string {
    return '₱ ' . number_format($p, 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Coffee — Cart</title>
    <link href="./output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Source+Code+Pro:wght@600&display=swap" rel="stylesheet">
</head>
<body class="bg-taupe-50 text-black min-h-screen font-inter flex flex-col">

<!-- ── Navbar ── -->
<nav class="flex flex-row border-b border-gray-200 bg-taupe-50 sticky top-0 z-50">
    <div class="container mx-auto flex items-center px-3 justify-between py-3">
        <a href="home.php" class="flex items-center gap-2 font-code text-2xl font-semibold tracking-wide">
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
            <div class="w-9 h-9 rounded-full bg-gray-300"></div>
        </div>
    </div>
</nav>

<main class="container mx-auto px-4 py-10 flex-1">

    <div class="flex items-baseline gap-3 mb-8 border-b border-gray-200 pb-4">
        <h1 class="font-[Newsreader] text-5xl font-bold">Cart</h1>
        <span class="text-gray-500 text-sm"><?= $cartCount ?> item<?= $cartCount !== 1 ? 's' : '' ?></span>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-24 text-gray-400">
            <p class="text-xl mb-4">Your cart is empty.</p>
            <a href="menu.php" class="bg-olive-600 hover:bg-olive-700 text-white px-6 py-3 rounded text-sm font-medium">
                Browse Menu
            </a>
        </div>

    <?php else: ?>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <!-- ── Cart items ── -->
        <div class="flex-1 flex flex-col gap-4">
            <?php foreach ($cartItems as $item):
                $safeKey = htmlspecialchars($item['key'], ENT_QUOTES);
            ?>
            <div class="bg-taupe-100 rounded-lg border border-taupe-200 flex items-center gap-4 p-4">

                <img src="<?= htmlspecialchars($item['image']) ?>"
                     alt="<?= htmlspecialchars($item['name']) ?>"
                     class="w-20 h-20 object-cover rounded-md flex-shrink-0">

                <div class="flex-1 min-w-0">
                    <p class="font-semibold uppercase tracking-wide text-xs text-gray-500">
                        <?= htmlspecialchars($item['name']) ?>
                    </p>
                    <p class="font-[Newsreader] text-lg font-bold mt-0.5">
                        <?= formatPrice($item['price']) ?>
                    </p>

                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-500">
                            <?= $item['qty'] ?> pc<?= $item['qty'] !== 1 ? 's.' : '.' ?>
                        </span>
                        <button type="button"
                            onclick="toggleEdit('<?= $safeKey ?>')"
                            class="text-gray-400 hover:text-black text-sm">▼</button>

                        <span id="edit-<?= $safeKey ?>" class="hidden items-center gap-1">
                            <form method="post" action="cart.php" class="flex items-center gap-1">
                                <input type="hidden" name="item_key" value="<?= $safeKey ?>">
                                <input type="number" name="quantity" value="<?= $item['qty'] ?>"
                                       min="0" class="w-14 border border-gray-300 rounded px-2 py-1 text-xs">
                                <button type="submit" name="update_qty" value="1"
                                        class="bg-olive-600 text-white px-2 py-1 rounded text-xs hover:bg-olive-700">
                                    OK
                                </button>
                            </form>
                        </span>
                    </div>
                </div>

                <div class="text-right flex-shrink-0">
                    <p class="font-[Newsreader] font-bold text-lg"><?= formatPrice($item['line_total']) ?></p>
                    <form method="post" action="cart.php" class="mt-1">
                        <input type="hidden" name="remove" value="<?= $safeKey ?>">
                        <button type="submit" class="text-xs text-gray-400 hover:text-red-500">Remove</button>
                    </form>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <!-- ── Sidebar ── -->
        <div class="w-full lg:w-72 flex-shrink-0 flex flex-col gap-4">

            <div class="bg-taupe-100 border border-taupe-200 rounded-lg p-4">
                <p class="text-sm font-semibold mb-3">Service</p>
                <button class="w-full bg-olive-600 text-white py-2 rounded text-sm font-medium">Pick-up</button>
            </div>

            <div class="bg-taupe-100 border border-taupe-200 rounded-lg p-4">
                <p class="text-sm font-semibold mb-4">Order summary</p>

                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Subtotal</span><span><?= formatPrice($subtotal) ?></span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 mb-3">
                    <span>Shipping</span><span>₱ 00.00</span>
                </div>
                <div class="flex justify-between font-bold text-sm border-t border-gray-300 pt-3">
                    <span>Total</span><span><?= formatPrice($total) ?></span>
                </div>

                <a href="payment.php"
                   class="mt-4 w-full bg-olive-600 hover:bg-olive-700 text-white py-2.5 rounded text-sm font-medium flex items-center justify-between px-4">
                    Continue to payment <span>→</span>
                </a>
            </div>

        </div>
    </div>

    <?php endif; ?>
</main>

    <footer class="bg-taupe-100 border-t border-taupe-200 text-center py-8 text-sm text-gray-700 tracking-wide mt-auto">
        <p class="font-semibold">CONTACT US</p>
        <p class="mt-2 text-gray-500">Vintar, Ilocos Norte | 096971287654 | dailydosecoffee@gmail.com</p>
    </footer>

<script>
    function toggleEdit(key) {
        const el = document.getElementById('edit-' + key);
        el.classList.toggle('hidden');
        el.classList.toggle('flex');
    }
</script>
</body>
</html>
