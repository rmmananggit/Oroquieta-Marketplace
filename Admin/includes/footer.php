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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

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

$(document).ready(function () {
    $(".view-product-details").on("click", function () {
        const productId = $(this).data("id");

        // Clear previous content
        $("#productDetailsContent").html("<p>Loading...</p>");

        // Fetch product details
        $.ajax({
            url: "./controller/get-product-details.php",
            type: "GET",
            data: { id: productId },
            success: function (response) {
                const data = JSON.parse(response);

                if (data.success) {
                    const product = data.product;
                    const images = data.images;

                    // Generate images grid
                    const imagesHtml = images
                        .map(img => `<img src="${img}" class="product-image" alt="Product Image">`)
                        .join("");

                    // Populate modal content
                    $("#productDetailsContent").html(`
                        <p><strong>Name:</strong> ${product.name}</p>
                        <p><strong>Description:</strong> ${product.description}</p>
                        <p><strong>Price:</strong> ₱${product.price}</p>
                        <p><strong>Category:</strong> ${product.categoryName}</p>
                        <p><strong>Quantity:</strong> ${product.quantity}</p>
                        <div class="images-container">${imagesHtml}</div>
                    `);
                } else {
                    $("#productDetailsContent").html("<p>Product details could not be loaded.</p>");
                }
            },
            error: function () {
                $("#productDetailsContent").html("<p>An error occurred while loading product details.</p>");
            },
        });
    });
});

  function viewCustomerDetails(userId) {
    $.ajax({
        url: './controller/view_customer_details.php',  // Correct path to the PHP file
        method: 'GET',
        data: { id: 3 },  // Passing the user_id for the customer you want to view
        success: function(response) {
            console.log("AJAX Response:", response);  // Log the raw response for debugging
            try {
                const data = JSON.parse(response);  // Parse JSON response
                if (data.success) {
                    // If success, display customer details in the modal
                    let customer = data.data;

                    // Format the registration_date to 12-hour AM/PM format
                    let registrationDate = new Date(customer.registration_date);
                    let options = {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true,
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    };
                    let formattedDate = registrationDate.toLocaleString('en-US', options);

                    let customerDetails = `
                        <p><strong>Username:</strong> ${customer.username}</p>
                        <p><strong>Email:</strong> ${customer.email}</p>
                        <p><strong>Phone:</strong> ${customer.phone_number}</p>
                        <p><strong>Address:</strong> ${customer.address_street}, ${customer.address_baranggay}, ${customer.address_city}</p>
                        <p><strong>Birthday:</strong> ${customer.date_of_birth}</p>
                        <p><strong>Date Registered:</strong> ${formattedDate}</p> <!-- Use formatted date -->
                        <p><strong>Status:</strong> ${customer.account_status}</p>
                    `;
                    $('#customer-details').html(customerDetails);  // Update the modal content with customer data

                    // Show the modal (ensure you have modal-related JS functionality)
                    $('#customerModal').modal('show');
                } else {
                    $('#customer-details').html('<p>' + data.message + '</p>');  // Show error message if no customer found
                    $('#customerModal').modal('show');
                }
            } catch (error) {
                console.error('Error parsing response:', error);  // Log error if JSON parsing fails
                $('#customer-details').html('<p>Error processing the data.</p>');
                $('#customerModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);  // Log any AJAX error
            $('#customer-details').html('<p>Error processing your request.</p>');
            $('#customerModal').modal('show');
        }
    });
}

// Edit Category
function openEditModal(categoryId) {
    $.ajax({
        url: './controller/fetch_category_details.php',  // This is the PHP file that fetches category data by ID
        method: 'GET',
        data: { id: categoryId },
        success: function(response) {
            console.log("AJAX Response:", response);  // Log the response for debugging
            try {
                const data = JSON.parse(response);  // Parse the JSON response
                if (data.success) {
                    // Populate modal form fields with category data
                    $('#categoryId').val(data.data.id);
                    $('#categoryName').val(data.data.name);
                    $('#categoryDescription').val(data.data.description);
                    
                    // Show the modal
                    $('#editCategoryModal').modal('show');
                } else {
                    alert("Failed to fetch category details.");
                }
            } catch (error) {
                console.error('Error parsing response:', error);  // Log error if JSON parsing fails
                alert('Error fetching category details.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);  // Log any AJAX error
            alert('Error fetching category details.');
        }
    });
}


// Handle Category Update Submission
$('#editCategoryForm').on('submit', function(e) {
    e.preventDefault();  // Prevent the default form submission

    var formData = $(this).serialize();  // Serialize the form data

    $.ajax({
        url: './controller/update_category.php',  // PHP script to update the category
        method: 'POST',
        data: formData,
        success: function(response) {
            console.log("Update Response:", response);  // Log the response for debugging
            try {
                const data = JSON.parse(response);  // Parse JSON response
                if (data.success) {
                    // Show success Toaster message with consistent format
                    Swal.fire({
                        icon: 'success',
                        title: data.message,  // Message from the PHP response
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    // Close the modal after success
                    $('#editCategoryModal').modal('hide');  // Close the modal

                    // Reload the page after 2 seconds to show the updated category
                    setTimeout(function() {
                        location.reload();  // Reload the page
                    }, 2000);
                } else {
                    // Show error Toaster message with consistent format
                    Swal.fire({
                        icon: 'error',
                        title: data.message,  // Error message from PHP
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                }
            } catch (error) {
                console.error('Error parsing response:', error);  // Log error if JSON parsing fails
                Swal.fire({
                    icon: 'error',
                    title: 'Error updating category.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);  // Log any AJAX error
            Swal.fire({
                icon: 'error',
                title: 'Error updating category.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
        }
    });
});





</script>


</body>

</html>

