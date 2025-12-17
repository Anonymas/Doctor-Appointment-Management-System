<!-- Add Doctor Popup -->
<div id="addDoctorPopup" class="overlay">
    <div class="popup">
        <center>
            <a class="close" href="doctor.php">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Doctor</p><br><br>
                            </td>
                        </tr>
                        <tr>
                            <form action="add-doctor.php" method="POST" class="add-new-form" onsubmit="return validateForm()">
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="name" class="input-text" placeholder="Doctor Name" required><br>
                            </td>
                        </tr>
                        <!-- Add other fields for adding a doctor -->
                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Add" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                    </form>
                </tr>
            </table>
        </div>
    </div>
</center>
<br><br>
</div>
</div>

<!-- Edit Doctor Popup -->
<div id="editDoctorPopup" class="overlay">
    <div class="popup">
        <center>
            <a class="close" href="doctor.php">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Doctor Details</p>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <form action="edit-doctor.php" method="POST" class="add-new-form">
                                <!-- Add fields for editing a doctor -->
                                <td class="label-td" colspan="2">
                                    <input type="hidden" name="id" id="editDoctorId">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="name" id="editDoctorName" class="input-text" placeholder="Doctor Name" required><br>
                            </td>
                        </tr>
                        <!-- Add other fields for editing a doctor -->
                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Save" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                    </form>
                </tr>
            </table>
        </div>
    </div>
</center>
<br><br>
</div>
</div>

<!-- View Doctor Popup -->
<div id="viewDoctorPopup" class="overlay">
    <div class="popup">
        <center>
            <a class="close" href="doctor.php">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Doctor Details</p>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <!-- Display fields for viewing a doctor -->
                                <label for="viewName" class="form-label">Name: </label>
                                <p id="viewName"></p>
                            </td>
                        </tr>
                        <!-- Add other fields for viewing a doctor -->
                    </table>
                </div>
            </div>
        </center>
        <br><br>
    </div>
</div>

<!-- Remove Doctor Popup -->
<div id="removeDoctorPopup" class="overlay">
    <div class="popup">
        <center>
            <a class="close" href="doctor.php">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Remove Doctor</p>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <!-- Display fields for confirming removal of a doctor -->
                                <p>Are you sure you want to remove this doctor?</p>
                                <input type="hidden" name="removeDoctorId" id="removeDoctorId">
                            </td>
                        </tr>
                        <!-- Add other fields for confirming removal of a doctor -->
                        <tr>
                            <td colspan="2">
                                <button class="login-btn btn-primary-soft btn" onclick="confirmRemoveDoctor()">Yes
                                </button>
                                <button class="login-btn btn-primary btn" onclick="closeRemoveDoctorPopup()">No</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
        <br><br>
    </div>
</div>

<!-- JavaScript for handling popups -->
<script>
    // Function to open the add doctor popup
    function openAddDoctorPopup() {
        document.getElementById('addDoctorPopup').style.display = 'block';
    }

    // Function to close the add doctor popup
    function closeAddDoctorPopup() {
        document.getElementById('addDoctorPopup').style.display = 'none';
    }

    // Function to open the edit doctor popup
    function openEditDoctorPopup(id, name) {
        document.getElementById('editDoctorId').value = id;
        document.getElementById('editDoctorName').value = name;
        document.getElementById('editDoctorPopup').style.display = 'block';
    }

    // Function to close the edit doctor popup
    function closeEditDoctorPopup() {
        document.getElementById('editDoctorPopup').style.display = 'none';
    }

    // Function to open the view doctor popup
    function openViewDoctorPopup(name) {
        document.getElementById('viewName').textContent = name;
        document.getElementById('viewDoctorPopup').style.display = 'block';
    }

    // Function to close the view doctor popup
    function closeViewDoctorPopup() {
        document.getElementById('viewDoctorPopup').style.display = 'none';
    }

    // Function to open the remove doctor popup
    function openRemoveDoctorPopup(id) {
        document.getElementById('removeDoctorId').value = id;
        document.getElementById('removeDoctorPopup').style.display = 'block';
    }

    // Function to close the remove doctor popup
    function closeRemoveDoctorPopup() {
        document.getElementById('removeDoctorPopup').style.display = 'none';
    }

    // Function to confirm removal of a doctor
    function confirmRemoveDoctor() {
        var doctorId = document.getElementById('removeDoctorId').value;
        // You can implement AJAX request here to remove the doctor from the database
        // Example:
        // var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         // Handle response
        //     }
        // };
        // xhttp.open("GET", "remove-doctor.php?id=" + doctorId, true);
        // xhttp.send();
        // For now, let's just close the popup
        closeRemoveDoctorPopup();
    }
</script>

