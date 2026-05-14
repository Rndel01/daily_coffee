<?php
session_start();
$cartCount = array_sum($_SESSION['cart'] ?? []);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="./output.css" rel="stylesheet">
</head>

<body>
    <!-- HEADER -->
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
        </div>
    </div>
</nav>

    <!-- THE REST -->
    <div class="flex min-h-screen flex-col bg-taupe-50">
        <main class="flex-1">
            <section class="container mx-auto px-4 py-32">
                <div class="mx-auto max-w-4xl text-center font-[Newsreader]">
                    <h1 class="text-black mb-6 text-5xl font-bold">
                        DAILY COFFEE
                    </h1>
                    <p class="text-muted-background mb-10 text-xl">
                        "Your Daily Dose of Delight"
                    </p>
                    <div class="flex flex-col items-center gap-4">
                        <a href="menu.php">
                            <Button size="lg" class="bg-olive-600 text-white h-10 w-35 font-medium">
                                Browse our Menu
                            </Button>
                        </a>
                    </div>
                </div>
            </section>
        </main>

    <footer class="bg-taupe-100 border-t border-taupe-200 text-center py-8 text-sm text-gray-700 tracking-wide mt-auto">
        <p class="font-semibold">CONTACT US</p>
        <p class="mt-2 text-gray-500">Vintar, Ilocos Norte | 096971287654 | dailydosecoffee@gmail.com</p>
    </footer>
</body>

</html>