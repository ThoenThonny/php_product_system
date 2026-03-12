<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="text-center">Register New Staff</h3>
        <form method="post" action="<?= BASE_URL ?>auth/store">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="FullName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Gender</label>
                <select name="Gen" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other" selected>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Date of Birth</label>
                <input type="date" name="Dob" class="form-control">
            </div>
            <div class="mb-3">
                <label>Position</label>
                <input type="text" name="Position" class="form-control" placeholder="e.g., Cashier, Manager">
            </div>
            <div class="mb-3">
                <label>Salary</label>
                <input type="number" step="0.01" name="Salary" class="form-control">
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="Username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="Password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="ConfirmPassword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <p class="text-center mt-3">
                Already have an account? <a href="<?= BASE_URL ?>auth/login">Login</a>
            </p>
        </form>
    </div>
</div>