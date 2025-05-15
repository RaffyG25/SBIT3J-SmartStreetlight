<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if($_SESSION['id_role'] == 3){
    header("Location: ../dashboard.php");
}
else if ($_SESSION['id_role'] == 2){
    header("Location: ../captain/dashboard.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard with Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen flex">
    <div id="sidebar" class="bg-white text-gray-900 border-r border-gray-200 transition-all duration-300 ease-in-out h-full flex flex-col w-64">
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
            <h1 class="text-lg font-semibold">Admin Dashboard</h1>
            <button id="collapse-btn" class="lg:hidden rounded-full p-1 hover:bg-gray-100">
                <svg id="collapse-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left h-5 w-5"><path d="m15 18-6-6 6-6"/></svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto p-2">
            <div class="space-y-2">
                <a href="dashboard.php" class="flex items-center p-2 rounded-md hover:bg-gray-100 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard mr-2 h-4 w-4"><rect width="22" height="9" x="1" y="3" rx="4" ry="4"/><rect width="22" height="9" x="1" y="12" rx="4" ry="4"/><path d="M6 6h6"/><path d="M6 15h6"/></svg>
                    <span class="menu-item-label">Dashboard</span>
                </a>
                <a href="users.php" class="flex items-center p-2 rounded-md hover:bg-gray-100 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard mr-2 h-4 w-4"><rect width="22" height="9" x="1" y="3" rx="4" ry="4"/><rect width="22" height="9" x="1" y="12" rx="4" ry="4"/><path d="M6 6h6"/><path d="M6 15h6"/></svg>
                    <span class="menu-item-label">Users</span>
                </a>
                <a href="../logout.php" class="flex items-center p-2 rounded-md hover:bg-gray-100 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out mr-2 h-4 w-4"><path d="M9 21H5a2 2 0 0 1-2-2v-4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    <span class="menu-item-label">Logout</span>
                </a>
                 <hr class="my-4 border-gray-200">
            </div>
        </nav>
    </div>

    <main class="flex-1 p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

    <?php
        $sensors = include '../assets/sensors.php';

        if (!empty($sensors)) {
            foreach ($sensors as $sens) {
                if ($sens["ledStatus"]  == "ON") {
                    $led_status = "ON";
                    $image_src = "../assets/img/ON.png";
                } else {
                    $led_status = "OFF";
                    $image_src = "../assets/img/OFF.png";
                }

                echo '<div class="bg-white rounded-lg shadow-md overflow-hidden flex" style="height: 200px;">';
                echo '<div class="w-1/3">';
                echo '<br/>';
                echo '<img src="' . $image_src . '" alt="LED Status ' . $led_status . '" class="w-25 h-25 object-cover">';
                echo '</div>';
                echo '<div class="p-4 w-2/3 flex flex-col justify-between">';
                echo '<h3 class="text-lg font-semibold text-gray-900">LED ' . $sens["id_sensor"] . '</h3>'; // Title: LED (1), LED (2), etc.
                echo '<p class="mt-2 text-gray-700">LDR Value: ' . $sens["ldrValue"] .  '</p>';
                echo '<div class="mt-3">';
                echo '<span class="text-sm text-gray-600">Status: ' . $sens["ledStatus"] .  '</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<div class='bg-white rounded-lg shadow-md p-4'>No data found</div>"; // Or any other message you prefer
        }
        ?>

</main>
    <script>
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('collapse-btn');
        const collapseIcon = document.getElementById('collapse-icon');
        const menuItemLabels = document.querySelectorAll('.menu-item-label');

        let isCollapsed = false;

        collapseBtn.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            sidebar.classList.toggle('w-20', isCollapsed);
            sidebar.classList.toggle('w-64', !isCollapsed);

            menuItemLabels.forEach(label => {
                label.classList.toggle('hidden', isCollapsed);
            });

            if (isCollapsed) {
                collapseIcon.setAttribute('d', 'M9 18l6-6-6-6');
            } else {
                collapseIcon.setAttribute('d', 'M15 18l-6-6 6-6');
            }
        });

        const body = document.querySelector('body');
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu h-6 w-6 text-gray-700"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>`;
        mobileMenuBtn.classList.add('md:hidden', 'absolute', 'top-4', 'left-4', 'z-50', 'bg-white', 'rounded-full', 'p-1', 'shadow-md');
        body.insertBefore(mobileMenuBtn, body.firstChild);

        const overlay = document.createElement('div');
        overlay.classList.add('fixed', 'inset-0', 'bg-black', 'opacity-0', 'z-40', 'transition-opacity', 'duration-300', 'md:hidden');
        body.appendChild(overlay);

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('opacity-50');
            overlay.classList.toggle('opacity-0');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('opacity-50');
            overlay.classList.toggle('opacity-0');
        });

        const menuLinks = document.querySelectorAll('.menu-item-label');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.toggle('translate-x-0');
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('opacity-50');
                    overlay.classList.toggle('opacity-0');
                }
            });
        });


        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-50');
                overlay.classList.add('opacity-0');
            }
             if (window.innerWidth > 768 && isCollapsed) {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                isCollapsed = false;
                 menuItemLabels.forEach(label => {
                    label.classList.remove('hidden');
                });
                collapseIcon.setAttribute('d', 'M15 18l-6-6 6-6');
            }
        });
    </script>
</body>
</html>
