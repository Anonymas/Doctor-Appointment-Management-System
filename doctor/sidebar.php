<nav class="sidebar close"> 
    <header>
            <div class="image-text">
                <span class="image">
                    <img src="../img/prime_care_logo.jpg" alt="logo">
                </span>
                <div class="text header-text"> 
                    <span class="name"> <?php echo substr($username, 0, 13); ?>..</span>
                    <span class="profession"> <?php echo substr($useremail, 0, 22); ?> </span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>  
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <a href="#">
                        <i class='bx bx-search icon'></i>
                        <input type="text" placeholder="Search ...">
                    </a>
                </li>
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="index.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="schedule.php">
                            <i class='bx bx-plus-medical icon'></i>
                            <span class="text nav-text">Sessions</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="appointment.php">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Appointments</span>
                        </a>
                    </li>
                    <li class="nav-link">
                <a href="patient.php">
                    <i class='bx bxs-capsule icon'></i>
                    <span class="text nav-text"> Patients</span>
                </a>
            </li>
                    <li class="nav-link">
                        <a href="settings.php">
                            <i class='bx bx-cog icon'></i>
                            <span class="text nav-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li> 
                    <a href="../logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span> 
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>
                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>