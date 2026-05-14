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

<body class="overflow-hidden">
    <!-- NAVBAR -->
    <nav class="flex flex-row border-b border-gray-200 bg-taupe-50 sticky top-0 z-50">
        <div class="container mx-auto flex items-center px-3 justify-between py-3">
            <a href="home.php" class="flex items-center gap-2 font-code text-2xl font-semibold tracking-wide">
                <img src="assets/dc_logobg.png" alt="Daily Coffee Logo" class="w-9 h-9"
                    onerror="this.style.display='none'">
                DAILY COFFEE
            </a>
            <div class="flex items-center gap-4 text-sm">
                <a href="menu.php" class="hover:underline underline-offset-4">Menu</a>
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
    <main class="flex items-center justify-center min-h-screen bg-taupe-50">
        
    <div class="absolute inset-0 z-0">
        <img src="assets/bg1.jpg"
             class="w-full h-full object-cover opacity-50">
    </div>

        <div class="w-full max-w-2xl z-10 text-center font-[Newsreader]">

            <h3 class="text-black mb-6 text-7xl font-bold ">About Us</h3>

            <p class="text-black leading-relaxed mb-4 text-xl font-semibold">
                To us, coffee is both an art and a rigorous science. At The Daily Coffee Shop, we’ve stripped
                away the fluff to focus on what matters, the beans.
            </p>

            <p class="text-black leading-relaxed mb-6 text-xl font-semibold">
                We source our beans through ethical, direct-trade partnerships, ensuring every harvest is
                sustainable and every farmer is paid fairly. Our baristas are obsessed with the details such as
                dialing in the grind size, monitoring water temperature, and perfecting the extraction to ensure
                that every cup reflects the unique interior of its origin.
            </p>

            <p class="text-black leading-relaxed text-xl font-semibold">
                Quality isn't just a goal for us but a daily standard
            </p>

        </div>
    </main>

    <footer class="bg-taupe-100 border-t border-taupe-200 text-center py-8 text-sm text-gray-700 tracking-wide mt-auto">
        <p class="font-semibold">CONTACT US</p>
        <p class="mt-2 text-gray-500">Vintar, Ilocos Norte | 096971287654 | dailydosecoffee@gmail.com</p>
    </footer>
</body>

</html>