<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="./controller/logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

</main><!-- End #main -->

 <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Oroquieta Marketplace</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Integrate by <a href="#">Misamis University</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
  if(isset($_SESSION['status']) && $_SESSION['status_code'] !='') {
      ?>
      <script>
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "<?php echo $_SESSION['status_code']; ?>",
          title: "<?php echo $_SESSION['status']; ?>"
        });
      </script>
      <?php
      unset($_SESSION['status']);
      unset($_SESSION['status_code']);
  }     
?>


  <!-- address java script -->
  <script>
document.addEventListener('DOMContentLoaded', () => {
  fetch('assets/js/address.json')
    .then(response => response.json())
    .then(data => {
      populateRegions(data);
    });

  function populateRegions(data) {
    const regionDropdown = document.getElementById('regionDropdown');
    const provinceDropdown = document.getElementById('provinceDropdown');
    const municipalityDropdown = document.getElementById('municipalityDropdown');
    const barangayDropdown = document.getElementById('barangayDropdown');

    // Add regions to dropdown
    for (let key in data) {
      const region = data[key];
      regionDropdown.add(new Option(region.region_name, key));
    }

    regionDropdown.addEventListener('change', function() {
      const selectedRegionKey = this.value;
      const provinceList = data[selectedRegionKey].province_list;
      populateProvinces(provinceList);
    });

    function populateProvinces(provinceList) {
      provinceDropdown.innerHTML = '<option selected disabled value="">Choose...</option>';
      for (let province in provinceList) {
        provinceDropdown.add(new Option(province, province));
      }

      provinceDropdown.addEventListener('change', function() {
        const selectedProvince = this.value;
        const municipalityList = provinceList[selectedProvince].municipality_list;
        populateMunicipalities(municipalityList);
      });
    }

    function populateMunicipalities(municipalityList) {
      municipalityDropdown.innerHTML = '<option selected disabled value="">Choose...</option>';
      for (let municipality in municipalityList) {
        municipalityDropdown.add(new Option(municipality, municipality));
      }

      municipalityDropdown.addEventListener('change', function() {
        const selectedMunicipality = this.value;
        const barangayList = municipalityList[selectedMunicipality].barangay_list;
        populateBarangays(barangayList);
      });
    }

    function populateBarangays(barangayList) {
      barangayDropdown.innerHTML = '<option selected disabled value="">Choose...</option>';
      barangayList.forEach(barangay => {
        barangayDropdown.add(new Option(barangay, barangay));
      });
    }
  }
});
</script>

<!-- Script for phone number -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const phoneInput = document.getElementById('validationCustom04');

  phoneInput.addEventListener('input', () => {
    // Remove non-numeric characters and ensure the length does not exceed 9
    phoneInput.value = phoneInput.value.replace(/\D/g, '').slice(0, 9);
  });
});
</script>

<script>
    $(document).on('click', '.view-details-link', function () {
        const productId = $(this).data('id');

        // Show a loading spinner in the modal body while fetching data
        $('#productDetailsContent').html(`
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

        // Fetch the product details using AJAX
        $.ajax({
            url: './controller/get-product-details.php', // PHP file to handle the request
            type: 'GET',
            data: { id: productId },
            success: function (response) {
                // Populate the modal with the fetched data
                $('#productDetailsContent').html(response);
            },
            error: function () {
                $('#productDetailsContent').html('<p class="text-danger">Failed to load product details. Please try again.</p>');
            }
        });
    });
</script>

<!-- Delete JavaScript -->
<script>
    $(document).on('click', '.delete-product', function () {
        const productId = $(this).data('id');
        const productName = $(this).data('name');


        $('#deleteProductName').text(productName);
        $('#deleteProductId').val(productId);


        $('#deleteConfirmationModal').modal('show');
    });

// Delete Images
    document.addEventListener('click', function (event) {
    if (event.target.classList.contains('delete-image') || event.target.classList.contains('set-primary')) {
        const action = event.target.classList.contains('delete-image') ? 'delete' : 'set_primary';
        const imageId = event.target.getAttribute('data-id');
        const productId = document.querySelector('.edit-image[data-id]').getAttribute('data-id'); // Get product_id

        fetch('./controller/update-product-images.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=${action}&image_id=${imageId}&product_id=${productId}`
        })
        .then(response => response.text())
        .then(data => {
            // Optionally display a success message or handle the data
            // Example: Update UI with status message
            const statusMessage = document.getElementById('status-message');
            if (statusMessage) {
                statusMessage.textContent = data; // Display success/failure message
            }

            // Reload images in modal (as you were doing before)
            document.querySelector(`.edit-image[data-id="${productId}"]`).click();
        })
        .catch(error => console.error('Error:', error));
    }
});

// Fetch Images
document.addEventListener('DOMContentLoaded', function () {
    const editImageButtons = document.querySelectorAll('.edit-image');

    editImageButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const imageContent = document.getElementById('productImageContent');

            // Clear previous content
            imageContent.innerHTML = '<p>Loading images...</p>';

            // Fetch images
            fetch(`./controller/fetch-product-images.php?product_id=${productId}`)
                .then(response => response.text())
                .then(data => {
                    imageContent.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching images:', error);
                    imageContent.innerHTML = '<p class="text-danger">Failed to load images. Please try again.</p>';
                });
        });
    });
});

// Fetch Details
document.addEventListener('DOMContentLoaded', function () {
    const editLinks = document.querySelectorAll('.edit-product');

    editLinks.forEach(link => {
        link.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            
            fetch(`./controller/edit-product-details.php?product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('editProductId').value = data.product_id;
                        document.getElementById('editProductName').value = data.name;
                        document.getElementById('editDescription').value = data.description;
                        document.getElementById('editPrice').value = data.price;
                        document.getElementById('editCategory').value = data.category;
                        document.getElementById('editQuantity').value = data.quantity;
                    } else {
                        alert('Error: Product details not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching product details:', error);
                    alert('Error fetching product details');
                });
        });
    });
});


    const newPasswordInput = document.getElementById('newPassword');
    const passwordFeedback = document.getElementById('passwordFeedback');
    const submitButton = document.getElementById('submitBtn');
    const renewPasswordInput = document.getElementById('renewPassword');

    // Regular expressions for validation
    const minLength = /.{8,}/;
    const hasUppercase = /[A-Z]/;
    const hasLowercase = /[a-z]/;
    const hasNumber = /\d/;
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/;

    // Function to validate the password
    function validatePassword() {
        const password = newPasswordInput.value;
        const confirmPassword = renewPasswordInput.value;
        let feedbackMessage = '';

        // Validate password against criteria
        let isValid = true;
        let validCriteriaCount = 0;

        if (minLength.test(password)) {
            validCriteriaCount++;
        } else {
            isValid = false;
        }

        if (hasUppercase.test(password)) {
            validCriteriaCount++;
        } else {
            isValid = false;
        }

        if (hasLowercase.test(password)) {
            validCriteriaCount++;
        } else {
            isValid = false;
        }

        if (hasNumber.test(password)) {
            validCriteriaCount++;
        } else {
            isValid = false;
        }

        if (hasSpecialChar.test(password)) {
            validCriteriaCount++;
        } else {
            isValid = false;
        }

        // Check if the password matches the confirmation
        if (password !== confirmPassword) {
            isValid = false;
            feedbackMessage = 'Passwords do not match';
        } else if (validCriteriaCount === 5) {
            feedbackMessage = 'Password is strong!';
        } else {
            feedbackMessage = 'Password does not meet all criteria';
        }

        // Update feedback message and color
        if (validCriteriaCount === 5 && password === confirmPassword) {
            feedbackMessage = 'Password is strong!';
            newPasswordInput.classList.add('valid');
            newPasswordInput.classList.remove('invalid');
            submitButton.disabled = false;
        } else {
            newPasswordInput.classList.add('invalid');
            newPasswordInput.classList.remove('valid');
            submitButton.disabled = true;
        }

        passwordFeedback.textContent = feedbackMessage;
    }

    // Event listeners
    newPasswordInput.addEventListener('input', validatePassword);
    renewPasswordInput.addEventListener('input', validatePassword);


</script>


</body>

</html>

