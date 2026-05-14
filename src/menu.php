<?php

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

$grouped = [];
foreach ($coffees as $item) {
    $grouped[$item["category"]][] = $item;
}

$categories = ["cold", "hot", "non-coffee"];

// CART
session_start();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
    $key = $_POST["add_to_cart"];
    $_SESSION["cart"][$key] = ($_SESSION["cart"][$key] ?? 0) + 1;
    header("Location: " . $_SERVER["PHP_SELF"] . "?added=1");
    exit;
}

$cartCount = array_sum($_SESSION["cart"]);

function formatPrice(float $price): string {
    return "₱ " . number_format($price, 2);
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

<body class="bg-taupe-50 text-black min-h-screen">

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

<!-- CART NOTICE -->
<?php if (isset($_GET['added'])): ?>
<div class="bg-olive-600 text-white text-center py-2 tracking-wide text-sm font-inter">
    ✓ Item added to cart — you now have <?= $cartCount ?> item(s).
</div>
<?php endif; ?>

<!-- HERO BAR -->

<div class="container mb-8 border-b border-gray-200 mx-auto px-4 py-10 flex flex-col md:flex-row md:items-end md:justify-between gap-6">

    <h1 class="font-[Newsreader] text-5xl font-bold text-black">
        Menu
    </h1>

    <div class="flex flex-wrap gap-2">

        <button
            class="filter-tab px-5 py-2 rounded border border-black text-black bg-black text-white uppercase tracking-widest text-xs font-inter"
            data-filter="all"
        >
            All
        </button>

        <?php foreach ($categories as $cat): ?>
        <button
            class="filter-tab px-5 py-2 rounded border border-gray-400 text-gray-700 uppercase tracking-widest text-xs hover:bg-black hover:text-white hover:border-black font-inter"
            data-filter="<?= htmlspecialchars($cat) ?>"
        >
            <?= strtoupper($cat) ?>
        </button>
        <?php endforeach; ?>

    </div>
</div>


<!-- SECTION -->
<main class="container mx-auto px-4 py-12">

<?php foreach ($categories as $cat): ?>
    <?php if (empty($grouped[$cat])) continue; ?>

    <section class="menu-section mb-16" data-cat="<?= htmlspecialchars($cat) ?>">

        <!-- SECTION HEADING -->
        <div class="mb-8 border-b border-gray-200 pb-3">
            <h2 class="font-[Newsreader] text-4xl font-bold uppercase tracking-wide text-black">
                <?= strtoupper($cat) ?>
            </h2>
            <div class="w-12 h-[2px] bg-olive-600 mt-2"></div>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php foreach ($grouped[$cat] as $item):
                $key = htmlspecialchars($item['name'] . '|' . $item['category'], ENT_QUOTES);
            ?>

            <div class="bg-white rounded border border-gray-200 overflow-hidden hover:shadow-md hover:-translate-y-0.5 duration-300 flex flex-col">

                <!-- IMAGE -->
                <div class="aspect-square overflow-hidden bg-taupe-100">
                    <img
                        src="<?= htmlspecialchars($item['image']) ?>"
                        alt="<?= htmlspecialchars($item['name']) ?>"
                        class="w-full h-full object-cover hover:scale-105 duration-500"
                    >
                </div>

                <!-- BODY -->
                <div class="p-4 flex flex-col flex-1">

                    <h3 class="font-inter uppercase tracking-wide text-lg font-semibold text-gray-500 mb-1">
                        <?= htmlspecialchars($item['name']) ?>
                    </h3>

                    <p class="font-[Newsreader] text-2xl font-bold text-black mb-4">
                        <?= formatPrice($item['price']) ?>
                    </p>

                    <form
                        method="post"
                        action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?added=1"
                        class="mt-auto"
                    >
                        <input type="hidden" name="add_to_cart" value="<?= $key ?>">

                        <button
                            type="submit"
                            class="w-full bg-olive-600 hover:bg-olive-700 text-white py-2.5 rounded text-xs font-semibold uppercase tracking-widest font-inter"
                        >
                            Add to Cart
                        </button>
                    </form>

                </div>
            </div>

            <?php endforeach; ?>
        </div>

    </section>

<?php endforeach; ?>
</main>

    <footer class="bg-taupe-100 border-t border-taupe-200 text-center py-8 text-sm text-gray-700 tracking-wide mt-auto">
        <p class="font-semibold">CONTACT US</p>
        <p class="mt-2 text-gray-500">Vintar, Ilocos Norte | 096971287654 | dailydosecoffee@gmail.com</p>
    </footer>

<!-- SCRIPT -->
<script>
    const tabs     = document.querySelectorAll('.filter-tab');
    const sections = document.querySelectorAll('.menu-section');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {

            tabs.forEach(t => {
                t.classList.remove('bg-black', 'text-white', 'border-black');
                t.classList.add('border-gray-400', 'text-gray-700');
            });

            tab.classList.add('bg-black', 'text-white', 'border-black');
            tab.classList.remove('border-gray-400', 'text-gray-700');

            const filter = tab.dataset.filter;

            sections.forEach(section => {
                if (filter === 'all' || section.dataset.cat === filter) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        });
    });
</script>

</body>
</html>
