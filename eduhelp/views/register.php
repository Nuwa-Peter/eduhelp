<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Register a new school</div>
            <div class="card-body">
                <form action="scripts/register.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school_name" class="form-label">School Name</label>
                                <input type="text" class="form-control" id="school_name" name="school_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school_logo" class="form-label">School Logo</label>
                                <input type="file" class="form-control" id="school_logo" name="school_logo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Contact Phone</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <hr>
                    <h5 class="card-title">Headteacher Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="headteacher_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="headteacher_username" name="headteacher_username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="headteacher_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="headteacher_email" name="headteacher_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="headteacher_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="headteacher_password" name="headteacher_password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="headteacher_gender" class="form-label">Gender</label>
                                <select class="form-select" id="headteacher_gender" name="headteacher_gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
