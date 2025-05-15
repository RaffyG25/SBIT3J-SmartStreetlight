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

    require '../assets/fetch_account.php';

    $result = fetchAccounts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Streetlight</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus mr-2 h-4 w-4"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8" cy="7" r="4"/><path d="M20 8v6m-4-2h8"/></svg>
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

    <main class="flex-1 p-6">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="display: block; overflow: auto;">
                    <h5 class="card-title">Users</h2>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Role (ID)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $row["id_account"]. "</th>";
                                    echo "<td>" . $row["username"]. "</td>";
                                    echo "<td>" . $row["id_role"]. "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>" . ($result ? "No accounts found" : "Error fetching accounts") . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="margin-left: auto; display: block;">
                        Add User
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add User</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="../assets/create_user.php" method="POST" class="space-y-4">
                            <div class="modal-body">
                        <div>
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                            <input type="text" id="username" name="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter username">
                            <div id="username-error" class="text-red-500 text-xs italic" style="display: none;"></div>
                        </div>
                        <div>
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                            <input type="password" id="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter password">
                            <div id="password-error" class="text-red-500 text-xs italic" style="display: none;"></div>
                        </div>
                        <div>
                            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                            <select id="role" name="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="" disabled selected>-- SELECT A ROLE --</option>
                                <option value="1">1 - Admin</option>
                                <option value="2">2 - Captain</option>
                                <option value="3">3 - User</option>
                            </select>
                            <div id="role-error" class="text-red-500 text-xs italic" style="display: none;"></div>
                        </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="insert_user" class="btn btn-primary">Add User</button>
                            </div>
                            </form>

                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        // Close menu on item click (optional - if you want the menu to close automatically on item click)
        const menuLinks = document.querySelectorAll('.menu-item-label'); // Select by class used in <a>
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) { // Only close if it's the mobile menu
                    sidebar.classList.toggle('translate-x-0');
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('opacity-50');
                    overlay.classList.toggle('opacity-0');
                }
            });
        });


        // Responsive behavior to close sidebar on larger screens
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

        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var role = document.getElementById('role').value;
            var errorMessage = document.getElementById('error-message');

            //basic validation
            if (!username) {
                errorMessage.textContent="Username is required";
                return;
            }
             if (!password) {
                errorMessage.textContent="Password is required";
                return;
            }

            // Create an AJAX request to handle the form submission
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_user.php', true); // Create a new PHP file, add_user.php
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle the response from the server
                    if (xhr.responseText === 'success') {
                        alert('User added successfully!'); // Or use a better notification
                        modal.style.display = "none"; // Close the modal
                        // Optionally, clear the form fields
                        document.getElementById('username').value = '';
                        document.getElementById('password').value = '';
                        document.getElementById('role').value = '1';
                         errorMessage.textContent = '';

                    } else {
                        errorMessage.textContent = xhr.responseText; // Display the error message from PHP
                    }
                } else {
                    errorMessage.textContent = 'Error: ' + xhr.status;
                }
            };

            // Send the request with the form data
            var params = 'username=' + encodeURIComponent(username) +
                '&password=' + encodeURIComponent(password) +
                '&role=' + encodeURIComponent(role);
            xhr.send(params);
        });

    </script>
</body>
</html>
