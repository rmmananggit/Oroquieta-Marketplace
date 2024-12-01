<?php
include("./includes/authentication.php");
include("./includes/header.php");
include("./includes/topbar.php");
?>
<section class="section profile">
      <div class="row">
        <div class="col-xl-4">

        <?php

            $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
            $users = "SELECT
                users.user_id, 
                users.email, 
                users.username, 
                users.`password`, 
                users.*
            FROM
                users
            WHERE
                users.user_id = $userId";
            $users_run = mysqli_query($con, $users);
                    ?>
                    <?php
                    if(mysqli_num_rows($users_run) > 0)
                    {
                        foreach($users_run as $user)
                        {
                    ?>

                    <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <?php
                        // Determine profile image source
                        $profileImageSrc = !empty($user['profile_image']) 
                            ? 'data:image/jpeg;base64,' . base64_encode($user['profile_image']) 
                            : './assets/img/noimage.jpg';
                        ?>

                        <!-- Display the profile image -->
                        <img class="img-fluid avatar-xxl rounded-circle" 
                            src="<?= $profileImageSrc; ?>" 
                            alt="Profile Image" 
                            style="object-fit: cover;">
                            
                        <h2><?= $user['first_name']; ?> <?= $user['last_name']; ?></h2>
                        <h3><span class="badge bg-primary">Administrator</span></h3>
                        <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>

                    </div>
                    </div>


            <?php
                    }
                }
                else
                {
                    ?>
                    <h4>No Record Found!</h4>
                    <?php
                }

            ?>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                        <?php

            $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
            $users = "SELECT
                users.user_id, 
                users.email, 
                users.username, 
                users.`password`, 
                users.*
            FROM
                users
            WHERE
                users.user_id = $userId";
            $users_run = mysqli_query($con, $users);
                    ?>
                    <?php
                    if(mysqli_num_rows($users_run) > 0)
                    {
                        foreach($users_run as $user)
                        {
                         ?>
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic"><?= !empty($user['aboutme']) ? htmlspecialchars($user['aboutme'], ENT_QUOTES, 'UTF-8') : "This user has not provided any information about themselves."; ?>
                  </p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?= $user['first_name']; ?> <?= $user['last_name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?= $user['address_street']; ?>, <?= $user['address_baranggay']; ?>, <?= $user['address_city']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?= $user['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Birthday</div>
                    <div class="col-lg-9 col-md-8"><?= $user['date_of_birth']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone Number</div>
                    <div class="col-lg-9 col-md-8"><?= $user['phone_number']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">Philippines</div>
                  </div>

                  <?php
                    }
                }
                else
                {
                    ?>
                    <h4>No Record Found!</h4>
                    <?php
                }

            ?>
                </div>

            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <?php

                $userId = mysqli_real_escape_string($con, $_SESSION['auth_user']['userId']);
                $users = "SELECT
                                users.*
                            FROM
                                users
                            WHERE
                                users.user_id = $userId";
                $users_run = mysqli_query($con, $users);
                        ?>
                        <?php
                        if(mysqli_num_rows($users_run) > 0)
                        {
                            foreach($users_run as $user)
                            {
                            ?>

                  <!-- Profile Edit Form -->
                  <form method="POST" action="./controller/edit_profile.php" enctype="multipart/form-data">
                  <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                                <?php
                                $profileImageSrc = !empty($user['profile_image'])
                                    ? 'data:image/jpeg;base64,' . base64_encode($user['profile_image'])
                                    : './assets/img/noimage.jpg';
                                ?>
                                <img id="profileImagePreview" class="img-fluid avatar-xxl rounded-circle" 
                                    src="<?= $profileImageSrc; ?>" 
                                    alt="Profile Image" 
                                    style="object-fit: cover;">

                                <div class="pt-2 d-flex align-items-center">
                                    <!-- Upload Button with space -->
                                    <label for="uploadImage" class="btn btn-primary btn-sm" title="Upload new profile image" style="margin-right: 10px;">
                                        <i class="bi bi-upload"></i> Upload
                                    </label>
                                    <input type="file" name="profile_image" id="uploadImage" style="display: none;" onchange="previewImage(event)">
                                </div>
                            </div>


                    </div>

                    <div class="row mb-3">
                      <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="firstName" type="text" class="form-control" id="firstName" value="<?= $user['first_name']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="lastName" type="text" class="form-control" id="lastName" value="<?= $user['last_name']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                        <div class="col-md-8 col-lg-9">
                            <textarea 
                            name="about" 
                            class="form-control" 
                            id="about" 
                            style="height: 100px" 
                            placeholder="Write something about yourself..."><?= $user['aboutme'] ?: ''; ?></textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                      <label for="street" class="col-md-4 col-lg-3 col-form-label">Street</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="street" type="text" class="form-control" id="street" value="<?= $user['address_street']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="baranggay" class="col-md-4 col-lg-3 col-form-label">Baranggay</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="baranggay" type="text" class="form-control" id="baranggay" value="<?= $user['address_baranggay']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">City</label>
                      <div class="col-md-8 col-lg-9">
                        <input disabled name="country" type="text" class="form-control" id="Country" value="Oroquieta">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="<?= $user['phone_number']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="<?= $user['email']; ?>">
                      </div>
                    </div>

                           <div class="row mb-3">
                             <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input 
                                    name="twitter" 
                                    type="text" 
                                    class="form-control" 
                                    id="Twitter" 
                                    value="<?= $user['twitterLink'] ?: ''; ?>" 
                                    placeholder="Enter your Twitter profile link (https://)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input 
                                    name="facebook" 
                                    type="text" 
                                    class="form-control" 
                                    id="Facebook" 
                                    value="<?= $user['facebookLink'] ?: ''; ?>" 
                                    placeholder="Enter your Facebook profile link (https://)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                                <div class="col-md-8 col-lg-9">
                                    <input 
                                    name="instagram" 
                                    type="text" 
                                    class="form-control" 
                                    id="Instagram" 
                                    value="<?= $user['instagramLink'] ?: ''; ?>" 
                                    placeholder="Enter your Instagram profile link (https://)">
                                </div>
                            </div>


                    <div class="text-center">
                      <button type="submit" name="editProfile" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                        <?php
                            }
                        }
                        else
                        {
                            ?>
                            <h4>No Record Found!</h4>
                            <?php
                        }

                    ?>
            </div>


                    <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form method="POST" action="./controller/change_password.php">
                            <div class="row mb-3">
                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="password" type="password" class="form-control" id="currentPassword" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                                </div>
                            </div>

                            <!-- Password Criteria Description -->
                            <div class="row mb-3">
                                <div class="col-md-8 col-lg-9 offset-md-4 offset-lg-3">
                                    <p class="text-muted">
                                        <strong>Password Criteria:</strong><br>
                                        - At least 8 characters long<br>
                                        - Contains both uppercase and lowercase letters<br>
                                        - Includes at least one number<br>
                                        - May include special characters (e.g., @, #, $, etc.)
                                    </p>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>


                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
</section>



<?php
include("./includes/footer.php");
?>