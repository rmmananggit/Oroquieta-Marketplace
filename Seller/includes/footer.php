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

        // Update modal content
        $('#deleteProductName').text(productName);
        $('#deleteProductId').val(productId);

        // Show the modal
        $('#deleteConfirmationModal').modal('show');
    });
</script>


</body>

</html>

