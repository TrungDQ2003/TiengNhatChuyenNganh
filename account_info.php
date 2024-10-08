<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanji Memory Master - Account Information</title>
    <link rel="stylesheet" href="include/HomePage.css">
    <link rel="stylesheet" href="account_info.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
<header>
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <h1 class="title">Kanji Memory Master</h1>
        <a href="create_course.html"><button class="create-course">+ Create Course</button></a>
        <div class="user-icon" onclick="toggleDropdown()">
            <img style="width: 30px; height: 30px; border-radius: 50%; border: 1px solid black;" src="assets/hehe.jpg" alt="Profile Image">
            <div id="dropdown-menu" class="dropdown-menu">
                <a href="account_info.php" class="dropdown-item">
                    <span class="material-icons">person</span> Information
                </a>
                <a href="index.html" class="dropdown-item">
                    <span class="material-icons">logout</span>Log out
                </a>
            </div>
        </div>

    </header>

    <nav class="sidebar" id="sidebar">
        <ul>
            <a href="HomePage.html" style="text-decoration: none;"><li class="active" onclick="showSection('home')"><span class="material-icons">home</span> Home</li></a>
            <li onclick="showSection('library')"><span class="material-icons">folder</span> Your library</li>
            <p>Learn</p>
            <li onclick="showSection('quizzes')"><span class="material-icons">inventory_2</span> Quizzes</li>
        </ul>
    </nav>

    <div class="container">
        <h2>Account information</h2>
        <div class="account-info">
            <div class="image-section">
                <img src="assets/hehe.jpg" alt="Profile Image">
                <button class="upload-btn">+</button>
            </div>
            <table>
                <tr>
                    <td>Username</td>
                    <td>Trung</td>
                    <td><a href="#">Edit</a></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>trung@gmail.com</td>
                    <td><a href="#">Edit</a></td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td>12/01/2003</td>
                    <td><a href="#">Edit</a></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>Male</td>
                    <td><a href="#">Edit</a></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>********</td>
                    <td><a href="#">Edit</a></td>
                </tr>
            </table>
        </div>
        <a href="index.html" style="text-decoration: none;"><button class="logout-btn">Logout</button></a>
    </div>

    <footer>
        <a href="#">Điều khoản dịch vụ</a>
        <a href="#">Hỗ trợ</a>
    </footer>

    <script>
        function toggleDropdown() {
            var dropdownMenu = document.getElementById("dropdown-menu");
            if (dropdownMenu.style.display === "block") {
                dropdownMenu.style.display = "none";
            } else {
                dropdownMenu.style.display = "block";
            }
        }

        // Close the dropdown when clicking outside
        window.onclick = function (event) {
            if (!event.target.closest('.user-icon')) {
                var dropdownMenu = document.getElementById("dropdown-menu");
                if (dropdownMenu.style.display === "block") {
                    dropdownMenu.style.display = "none";
                }
            }
        }

        // Toggle Sidebar Menu
        function toggleMenu() {
            var sidebar = document.getElementById("sidebar");
            var container = document.getElementById("container");
            sidebar.classList.toggle("active");
            container.classList.toggle("menu-active");
        }

        // Display section
        function showSection(section) {
            document.getElementById("home-section").style.display = "none";
            document.getElementById("library-section").style.display = "none";
            document.getElementById("quizzes-section").style.display = "none";
            document.getElementById("quiz-screen-section").style.display = "none";

            document.getElementById(section + "-section").style.display = "block";
        }

        // Add active class to clicked item
        const sidebarItems = document.querySelectorAll('.sidebar ul li');

        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                sidebarItems.forEach(el => el.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>