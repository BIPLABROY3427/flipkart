function hidePageLoader() {
  const loader = document.getElementById("fkPageLoader");
  if (loader) {
    loader.classList.add("hide");
    setTimeout(function () {
      loader.style.display = "none";
    }, 300);
  }
}
const stateShortNames = {
  'Andaman and Nicobar Islands': 'AN',
  'Andhra Pradesh': 'AP',
  'Arunachal Pradesh': 'AR',
  'Assam': 'AS',
  'Bihar': 'BR',
  'Chandigarh': 'CH',
  'Chhattisgarh': 'CG',
  'Dadra and Nagar Haveli and Daman and Diu': 'DH',
  'Delhi': 'DL',
  'Goa': 'GA',
  'Gujarat': 'GJ',
  'Haryana': 'HR',
  'Himachal Pradesh': 'HP',
  'Jammu and Kashmir': 'JK',
  'Jharkhand': 'JH',
  'Karnataka': 'KA',
  'Kerala': 'KL',
  'Ladakh': 'LA',
  'Lakshadweep': 'LD',
  'Madhya Pradesh': 'MP',
  'Maharashtra': 'MH',
  'Manipur': 'MN',
  'Meghalaya': 'ML',
  'Mizoram': 'MZ',
  'Nagaland': 'NL',
  'Odisha': 'OD',
  'Puducherry': 'PY',
  'Punjab': 'PB',
  'Rajasthan': 'RJ',
  'Sikkim': 'SK',
  'Tamil Nadu': 'TN',
  'Telangana': 'TS',
  'Tripura': 'TR',
  'Uttar Pradesh': 'UP',
  'Uttarakhand': 'UK',
  'West Bengal': 'WB'
};
window.onload = function () {
  const addressStr = sessionStorage.getItem('selectedAddress');
  if (addressStr) {
    const addr = JSON.parse(addressStr);
    const savedState = String(addr.state || '').trim();
    const stateShort = stateShortNames[savedState] || savedState;
    const stateSuffix = stateShort ? `, ${stateShort}` : '';
    document.getElementById('addr-details').innerHTML = `
            <div class="addr-name">${addr.name} <span style="background:#f0f0f0;font-size:10px;padding:2px 4px;border-radius:2px;color:#878787;text-transform:uppercase;margin-left:5px">${addr.type}</span></div>
            <div class="addr-text">${addr.address}, ${addr.locality}, ${addr.city} - ${addr.pincode}${stateSuffix}</div>
            <div class="addr-phone">${addr.phone}</div>
        `;
  } else {
    window.location.replace('address.php?product=' + PRODUCT_SLUG);
  }
};

function proceedToPayment() {
  sessionStorage.setItem('totalAmount', PRODUCT_PRICE);
  window.location.href = 'payment.php?product=' + PRODUCT_SLUG;
}
document.addEventListener("contextmenu", function (e) { e.preventDefault(); });
document.addEventListener("keydown", function (e) {
  if (e.ctrlKey && ["u", "U", "s", "S", "c", "C", "p", "P"].includes(e.key)) e.preventDefault();
  if (e.keyCode === 123) e.preventDefault();
});
document.addEventListener("dragstart", function (e) { e.preventDefault(); });
document.addEventListener("selectstart", function (e) { e.preventDefault(); });

/* Do not add quantity changes to browser history. */
document.addEventListener("click", function (event) {
  const target = event.target instanceof Element ? event.target : null;
  const quantityLink = target ? target.closest("a.qty-btn") : null;

  if (!quantityLink || event.defaultPrevented) {
    return;
  }

  if (
    event.button !== 0 ||
    event.metaKey ||
    event.ctrlKey ||
    event.shiftKey ||
    event.altKey
  ) {
    return;
  }

  event.preventDefault();
  window.location.replace(quantityLink.href);
});

document.addEventListener("DOMContentLoaded", function () {
  setTimeout(hidePageLoader, 120);
});
// Fallback safety timeout
setTimeout(hidePageLoader, 3000);
