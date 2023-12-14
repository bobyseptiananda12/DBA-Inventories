        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon ">
                    <i class="fas fa-server"></i>
                </div>
                <div class="sidebar-brand-text mx-3">DBA Inventory</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php if($halaman == "Dashboard") echo "active"; ?>">
                <a class="nav-link" href="../index.php">
                    <i class=" fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Halaman
            </div>
            <li class="nav-item <?php if($halaman == "List Database") echo "active"; ?>">
                <a class="nav-link" href="inventory.php">
                    <i class="fas fa-database"></i>
                    <span>List Database</span></a>
            </li>
            <li class="nav-item <?php if($halaman == "List Database User") echo "active"; ?>">
                <a class="nav-link" href="db_user.php">
                    <i class="fas fa-database"></i>
                    <span>User - Database</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                General Information
            </div>
            <?php if ($isAdmin) : ?>

                <li class="nav-item <?php if($halaman == "Users") echo "active"; ?>">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-user"></i>
                        <span>Daftar Pengguna</span></a>
                </li>
                <li class="nav-item <?php if($halaman == "Daftar Karyawan") echo "active"; ?>">
                    <a class="nav-link" href="karyawan_telkom.php">
                        <i class="fas fa-address-card"></i>
                        <span>Daftar Karyawan</span></a>
                </li>
            <?php endif; ?>
            <li class="nav-item <?php if($halaman == "Profile") echo "active"; ?>">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user"></i>
                    <span>Profile</span></a>
            </li>
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <script>
            function redirectToIndex() {
                // Use JavaScript to redirect to the desired location
                window.location.href = "/index.php";
            }
        </script>