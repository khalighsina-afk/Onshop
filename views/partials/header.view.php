<header>
    <nav>
        <a href="index.php" class="nav-link">Home</a>
        <a href="products.php" class="nav-link">Products</a>
        <a href="cart.php" class="nav-link">Cart</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin.php" class="nav-link">Admin</a>
            <?php else: ?>
                <a href="user-panel.php" class="nav-link">My Account</a>
            <?php endif; ?>
            <a href="logout.php" class="nav-link">Logout</a>

        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
            <a href="register.php" class="nav-link">Register</a>
        <?php endif; ?>
    </nav>
</header>