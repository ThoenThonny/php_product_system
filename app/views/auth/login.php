<div class="row justify-content-center">
    <div class="col-md-4">
        <h3 class="text-center">Login</h3>
        <form method="post">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <p class="text-center mt-3">
                Don't have an account? <a href="<?= BASE_URL ?>auth/register">Register here</a>
            </p>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>