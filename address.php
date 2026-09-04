<?php
include('inc/function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Add delivery address</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/address.css">
  <script src="/assets/js/security.js"></script>
</head>

<body>
  <div id="fkPageLoader" class="fk-page-loader">
    <div class="fk-loader-spinner">
      <img src="/images/fklogo.png" alt="Loading">
    </div>
  </div>


  <div class="header">
    <svg onclick="history.back()" viewBox="0 0 24 24">
      <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
    </svg>
    <div class="header-title" id="page-title">Add delivery address</div>
  </div>

  <div class="stepper-container">
    <div class="stepper">
      <div class="step-line"></div>
      <div class="step active">
        <div class="step-circle">1</div>
        <span class="step-label">Address</span>
      </div>
      <div class="step">
        <div class="step-circle">2</div>
        <span class="step-label">Order Summary</span>
      </div>
      <div class="step">
        <div class="step-circle">3</div>
        <span class="step-label">Payment</span>
      </div>
    </div>
  </div>

  <div id="address-form-view">
    <div class="float-input">
      <input type="text" id="name" placeholder=" ">
      <label>Full Name</label>
    </div>

    <div class="float-input">
      <input type="tel" id="phone" placeholder=" ">
      <label>Phone number</label>
    </div>
    <div class="add-link">+ Add Alternate Phone Number</div>

    <div class="flex-row">
      <div class="float-input">
        <input type="text" id="pincode" placeholder=" " inputmode="numeric" maxlength="6" autocomplete="postal-code">
        <label>Pincode</label>
      </div>
      <button type="button" class="loc-btn" onclick="getLocation()">
        <svg viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="3" />
          <path
            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
        </svg>
        <span id="loc-btn-text">Use my location</span>
        <div class="spinner" id="loc-spinner"></div>
      </button>
    </div>

    <div class="flex-row">
      <div class="float-input select-input">
        <select id="state" autocomplete="address-level1" aria-label="State">
          <option value="">Select state</option>
          <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
          <option value="Andhra Pradesh">Andhra Pradesh</option>
          <option value="Arunachal Pradesh">Arunachal Pradesh</option>
          <option value="Assam">Assam</option>
          <option value="Bihar">Bihar</option>
          <option value="Chandigarh">Chandigarh</option>
          <option value="Chhattisgarh">Chhattisgarh</option>
          <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
          <option value="Delhi">Delhi</option>
          <option value="Goa">Goa</option>
          <option value="Gujarat">Gujarat</option>
          <option value="Haryana">Haryana</option>
          <option value="Himachal Pradesh">Himachal Pradesh</option>
          <option value="Jammu and Kashmir">Jammu and Kashmir</option>
          <option value="Jharkhand">Jharkhand</option>
          <option value="Karnataka">Karnataka</option>
          <option value="Kerala">Kerala</option>
          <option value="Ladakh">Ladakh</option>
          <option value="Lakshadweep">Lakshadweep</option>
          <option value="Madhya Pradesh">Madhya Pradesh</option>
          <option value="Maharashtra">Maharashtra</option>
          <option value="Manipur">Manipur</option>
          <option value="Meghalaya">Meghalaya</option>
          <option value="Mizoram">Mizoram</option>
          <option value="Nagaland">Nagaland</option>
          <option value="Odisha">Odisha</option>
          <option value="Puducherry">Puducherry</option>
          <option value="Punjab">Punjab</option>
          <option value="Rajasthan">Rajasthan</option>
          <option value="Sikkim">Sikkim</option>
          <option value="Tamil Nadu">Tamil Nadu</option>
          <option value="Telangana">Telangana</option>
          <option value="Tripura">Tripura</option>
          <option value="Uttar Pradesh">Uttar Pradesh</option>
          <option value="Uttarakhand">Uttarakhand</option>
          <option value="West Bengal">West Bengal</option>
        </select>
        <label>State</label>
        <svg class="select-arrow" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M7 9l5 5 5-5" />
        </svg>
      </div>
      <div class="float-input has-icon">
        <input type="text" id="city" placeholder=" " autocomplete="address-level2">
        <label>City</label>
        <svg class="input-icon" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
      </div>
    </div>

    <div class="float-input">
      <input type="text" id="address_line" placeholder=" ">
      <label>House No., Building Name</label>
    </div>

    <div class="float-input has-icon">
      <input type="text" id="locality" placeholder=" ">
      <label>Road name, Area, Colony</label>
      <svg class="input-icon" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8" />
        <line x1="21" y1="21" x2="16.65" y2="16.65" />
      </svg>
    </div>
    <div class="add-link">+ Add Nearby Famous Shop/Mall/Landmark</div>

    <div class="type-label">Type of address</div>
    <div class="type-pills">
      <input type="radio" name="addrType" id="typeHome" value="Home" checked hidden>
      <label for="typeHome" class="type-pill">
        <svg viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg> Home
      </label>

      <input type="radio" name="addrType" id="typeWork" value="Work" hidden>
      <label for="typeWork" class="type-pill">
        <svg viewBox="0 0 24 24">
          <path
            d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
        </svg> Work
      </label>
    </div>

    <div class="save-btn-wrapper" id="form-footer">
      <button class="save-btn" onclick="saveAddress()">Save Address</button>
    </div>
  </div>

  <script src="/assets/js/address.js"></script>
  <script src="/visitor.js" data-page="address" defer></script>
  <script type="module"
    src="https://static.cloudflareinsights.com/beacon.min.js/v3d52b47920f24c319d37e2661827c42b1787588026925"
    integrity="sha512-d9sL6GJLXn6fInD1+TVXhTcQOsmxeHfmHAvwGDIxp5TO+uo1fiWW7mHomMj4MLRlCsJDTqXzWLHJFFlPCEIj/A=="
    data-cf-beacon='{"version":"2024.11.0","token":"0b2008e19fd943c7831b0ee755168137","r":1}'
    crossorigin="anonymous"></script>
</body>

</html>
