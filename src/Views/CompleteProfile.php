<!DOCTYPE html>
<html>
<head>
  <title>Complete Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>Complete User Info</h2>
    <form method="POST" action="../controllers/RegistrationController.php" id="userForm" enctype="multipart/form-data">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="uname" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="phoneNumber">Phone Number</label>
        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" required>
      </div>
        <div class="form-group">
          <label for="profilePicture">Profile Picture</label>
          <input type="file" class="form-control-file" id="profilePicture" name="profilePicture" >
        </div>
      <div class="form-group">
        <label for="role">Role</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="userRole" value="user" checked>
          <label class="form-check-label" for="userRole">
            User
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="artisanRole" value="artisan">
          <label class="form-check-label" for="artisanRole">
            Artisan
          </label>
        </div>
      </div>
      <div id="artisanFields" style="display: none;">
        <div class="form-group">
          <label for="companyName">Company Name</label>
          <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Enter your company name">
        </div>
        <div class="form-group">
          <label for="companyAddress">Company Address</label>
          <input type="text" class="form-control" id="companyAddress" name="companyAddress" placeholder="Enter your company address">
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" id="description" name="description" placeholder="Enter a description of your company" rows="4"></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
  // Get the radio buttons and artisan fields div
  const artisanRadio = document.getElementById('artisanRole');
  const userRadio = document.getElementById('userRole');
  const artisanFieldsDiv = document.getElementById('artisanFields');

  // Add event listener to the radio buttons
  artisanRadio.addEventListener('change', function() {
    if (this.checked) {
      artisanFieldsDiv.style.display = 'block';
    } else {
      artisanFieldsDiv.style.display = 'none';
    }
  });

  userRadio.addEventListener('change', function() {
    if (this.checked) {
      artisanFieldsDiv.style.display = 'none';
    }
  });
</script>


