</div><!-- end row -->
</div> <!-- end container fluid -->
<footer class="text-center mb-0 py-3">
    <p class="text-muted small mb-0">Copyright &copy; <?php echo  date("Y");?> <a href="https://satriam.github.io" style="text-decoration:none;">
    <b>Satria Mulya</b></a>. All Rights Reserved</p>
</footer>
</div>
<!-- Unlock Modal -->
<div class="modal fade" id="unlockModal" tabindex="-1" aria-labelledby="unlockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unlockModalLabel">Enter Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="password" id="unlockPassword" class="form-control" placeholder="Enter Password">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="unlockButton">Unlock</button>
            </div>
        </div>
    </div>
</div>

<!-- Lock Popup Modal -->
<div class="modal fade" id="lockPopupModal" tabindex="-1" aria-labelledby="lockPopupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lockPopupModalLabel">System Locked</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The system is locked. Please unlock the system to access the content.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<!-- Locked Content -->
<div class="container d-flex justify-content-center align-items-center min-vh-100" id="lockedMessage">
    <h1 class="text-center">P BALAP!</h1>
</div>
    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
    <!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script> -->
    <script type="text/javascript">
      $(document).ready(function() {
    $('#table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
$(document).ready(function() {
    $('#table_data').DataTable( {
    } );
} );
    </script>

    <script type = "text/javascript">

$(document).ready(function() {
    $(".tabell-data").DataTable( {
    } );
} );
    </script>

<script type="text/javascript">
 $(document).ready(function() {
     $(".js-example-responsive").select2();
 });
</script>


<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    const unlockPasswordInput = document.getElementById('unlockPassword');
    const unlockButton = document.getElementById('unlockButton');
    const unlockModal = new bootstrap.Modal(document.getElementById('unlockModal'), {});
    const lockPopupModal = new bootstrap.Modal(document.getElementById('lockPopupModal'), {}); // Modal for lock popup
    const lockedMessage = document.getElementById('lockedMessage'); // Reference to the locked message element

    // Function to lock the system
    function lockSystem() {
        showLockedContent();
        // You can add additional logic here if needed
    }

    // Function to show locked content and hide unlocked content
    function showLockedContent() {
        unlockedContent.classList.add('d-none');
        lockedMessage.classList.remove('d-none'); // Show the locked message
    }

    // Function to hide locked content
    function hideLockedContent() {
        lockedMessage.classList.add('d-none'); // Hide the locked message
    }

    // Function to show unlocked content and hide locked content
    function showUnlockedContent() {
        hideLockedContent();
        unlockedContent.classList.remove('d-none');
        unlockModal.hide(); // Hide the modal when the password is correct
    }

    // Function to clear input value in the modal
    function clearModalInput() {
        unlockPasswordInput.value = ''; // Clear the input value
    }

    // Function to check if the system is locked and update the UI accordingly
    function checkLockStatus() {
        const lockTime = localStorage.getItem('lockTime');
        const currentTime = new Date().getTime();
        const sixHoursInMillis = 6 * 60 * 60 * 1000; // 6 hours in milliseconds

        if (lockTime && currentTime - lockTime < sixHoursInMillis) {
            showUnlockedContent();
        } else {
            lockSystem();
            lockPopupModal.show(); // Show lock popup modal after 6 hours
        }
    }

    // Check the lock status when the page loads
    checkLockStatus();

    // Event listener for the unlock button
    unlockButton.addEventListener('click', function () {
        const enteredPassword = unlockPasswordInput.value;
        // Add your password validation logic here
        // For simplicity, let's assume the correct password is 'password'
        if (enteredPassword === 'rehandling2023!') {
            localStorage.setItem('lockTime', new Date().getTime());
            showUnlockedContent();
            hideLockedContent(); // Hide the locked message when unlocked
        } else {
            alert('Incorrect Password. Please try again.');
        }
    });

    // Event listener for the "OK" button on the lock popup modal
    const lockPopupOkButton = document.querySelector('#lockPopupModal .btn-primary');
    lockPopupOkButton.addEventListener('click', function () {
        unlockModal.show(); // Show the password modal
    });

    // Event listener for the 'hidden.bs.modal' event on the unlock modal
    unlockModal._element.addEventListener('hidden.bs.modal', clearModalInput);

    // Set up a timer to check the lock status every 10 seconds
    setInterval(checkLockStatus, 60000); // Check every 10 seconds
});

</script>

</body>
</html>


