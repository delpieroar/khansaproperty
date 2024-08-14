<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php' ?>
    <link rel="stylesheet" href="style/about.css" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Hubungi Kami</title>
</head>
<body>
    <?php include 'nav.php' ?>
    <main>
        <section>
            <div class="mx-auto max-w-screen-2xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:h-screen lg:grid-cols-2">
                    <div class="relative z-10 lg:py-16">
                        <div class="relative h-64 sm:h-80 lg:h-full">
                            <img
                                alt=""
                                src="pictures/logocontact.jpg"
                                class="absolute inset-0 h-full w-full object-cover"
                            />
                        </div>
                    </div>

                    <div class="relative flex items-center bg-gray-100">
                        <span
                            class="hidden lg:absolute lg:inset-y-0 lg:-start-16 lg:block lg:w-16 lg:bg-gray-100"
                        ></span>

                        <div class="p-8 sm:p-16 lg:p-24">
                            <h2 class="text-2xl font-bold sm:text-3xl">
                                CONTACT
                            </h2>

                            <div class="mt-4 text-gray-600">
                                <p class="mt-6">
                                Punya masalah teknis?Butuh detail tentang rencana Bisnis kami? atau Mau menjual rumah dengan cepat dan mudah? Hubungi kami sekarang!
                                </p>
                            </div>

                            <a
                                href="https://wa.me/6282286885158?text=Hello%2C%20I%20would%20like%20to%20sell%20my%20house."
                                class="mt-8 inline-block rounded border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                                target="_blank"
                            >
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'?>
</body>
</html>