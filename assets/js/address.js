function hidePageLoader() {
  const loader = document.getElementById("fkPageLoader");
  if (loader) {
    loader.classList.add("hide");
    setTimeout(function () {
      loader.style.display = "none";
    }, 300);
  }
}
window.onload = function () {
  document.getElementById('address-form-view').style.display = 'block';
};

const pincodeInput = document.getElementById('pincode');
const stateSelect = document.getElementById('state');
const cityInput = document.getElementById('city');
let activePincodeController = null;
let lastResolvedPincode = '';
let stateWasAutoFilled = false;
let cityWasAutoFilled = false;

const stateAliases = {
  andamanandnicobar: 'Andaman and Nicobar Islands',
  andamanandnicobarisland: 'Andaman and Nicobar Islands',
  nctofdelhi: 'Delhi',
  nationalcapitalterritoryofdelhi: 'Delhi',
  dadraandnagarhaveli: 'Dadra and Nagar Haveli and Daman and Diu',
  damananddiu: 'Dadra and Nagar Haveli and Daman and Diu',
  orissa: 'Odisha',
  pondicherry: 'Puducherry',
  uttaranchal: 'Uttarakhand'
};

function stateKey(value) {
  return String(value || '')
    .toLowerCase()
    .replace(/&/g, 'and')
    .replace(/[^a-z]/g, '');
}

function selectStateByName(stateName) {
  const incomingKey = stateKey(stateName);
  const canonicalName = stateAliases[incomingKey] || String(stateName || '');
  const canonicalKey = stateKey(canonicalName);
  const matchedOption = Array.from(stateSelect.options).find(option => {
    return option.value && stateKey(option.value) === canonicalKey;
  });

  if (!matchedOption) return false;

  stateSelect.value = matchedOption.value;
  stateWasAutoFilled = true;
  return true;
}

function setDistrictAsCity(district) {
  const cleanDistrict = String(district || '').trim();
  if (!cleanDistrict) return false;

  cityInput.value = cleanDistrict;
  cityWasAutoFilled = true;
  return true;
}

function clearPreviousAutoFill() {
  if (stateWasAutoFilled) stateSelect.value = '';
  if (cityWasAutoFilled) cityInput.value = '';
  stateWasAutoFilled = false;
  cityWasAutoFilled = false;
}

stateSelect.addEventListener('change', function () {
  stateWasAutoFilled = false;
});

cityInput.addEventListener('input', function () {
  cityWasAutoFilled = false;
});

async function fetchJsonSafely(url, signal) {
  try {
    const response = await fetch(url, {
      cache: 'no-store',
      signal,
      headers: { Accept: 'application/json' }
    });

    if (!response.ok) return null;
    return await response.json();
  } catch (error) {
    if (error && error.name === 'AbortError') throw error;
    return null;
  }
}

function parsePostalApiResult(payload) {
  if (!payload) return null;

  const root = Array.isArray(payload) ? payload[0] : payload;
  if (!root || typeof root !== 'object') return null;

  const status = String(root.Status || root.status || '').toLowerCase();
  if (status && status !== 'success' && status !== 'ok') return null;

  let records = [];
  if (Array.isArray(root.PostOffice)) records = root.PostOffice;
  else if (Array.isArray(root.postOffice)) records = root.postOffice;
  else if (Array.isArray(root.data)) records = root.data;
  else if (
    Array.isArray(payload) &&
    payload.length &&
    (payload[0].District || payload[0].district)
  ) records = payload;

  const record = records.find(item => {
    return item && (item.District || item.district) &&
      (item.State || item.state || item.statename || item.stateName);
  });

  if (!record) return null;

  return {
    district: String(record.District || record.district || '').trim(),
    state: String(
      record.State || record.state || record.statename || record.stateName || ''
    ).trim()
  };
}

async function getPincodeDetails(pincode, signal) {
  const primaryPayload = await fetchJsonSafely(
    `https://api.postalpincode.in/pincode/${encodeURIComponent(pincode)}`,
    signal
  );
  let details = parsePostalApiResult(primaryPayload);
  if (details) return details;

  const fallbackPayload = await fetchJsonSafely(
    `https://api.pincodeapi.in/api/v1/pincode/${encodeURIComponent(pincode)}`,
    signal
  );
  details = parsePostalApiResult(fallbackPayload);
  if (details) return details;

  const nominatimPayload = await fetchJsonSafely(
    `https://nominatim.openstreetmap.org/search?format=json&country=India&postalcode=${encodeURIComponent(pincode)}&addressdetails=1&limit=1&accept-language=en`,
    signal
  );
  const address = Array.isArray(nominatimPayload) && nominatimPayload[0]
    ? nominatimPayload[0].address
    : null;

  if (!address) return null;

  return {
    district: String(
      address.state_district || address.district || address.county ||
      address.city_district || address.city || address.town || ''
    ).trim(),
    state: String(address.state || '').trim()
  };
}

async function lookupPincode(pincode) {
  if (!/^\d{6}$/.test(pincode)) return;

  if (activePincodeController) activePincodeController.abort();
  const controller = new AbortController();
  activePincodeController = controller;

  try {
    const details = await getPincodeDetails(pincode, controller.signal);

    if (
      controller !== activePincodeController ||
      pincodeInput.value !== pincode ||
      !details
    ) return;

    setDistrictAsCity(details.district);
    selectStateByName(details.state);
    lastResolvedPincode = pincode;
  } catch (error) {
    if (!error || error.name !== 'AbortError') {
      lastResolvedPincode = '';
    }
  } finally {
    if (controller === activePincodeController) {
      activePincodeController = null;
    }
  }
}

function handlePincodeInput() {
  const cleanPincode = pincodeInput.value.replace(/\D/g, '').slice(0, 6);
  if (pincodeInput.value !== cleanPincode) pincodeInput.value = cleanPincode;

  if (activePincodeController) {
    activePincodeController.abort();
    activePincodeController = null;
  }

  if (cleanPincode !== lastResolvedPincode) clearPreviousAutoFill();

  if (cleanPincode.length === 6) {
    lookupPincode(cleanPincode);
  } else {
    lastResolvedPincode = '';
  }
}

pincodeInput.addEventListener('input', handlePincodeInput);
pincodeInput.addEventListener('blur', function () {
  const pincode = pincodeInput.value;
  if (/^\d{6}$/.test(pincode) && pincode !== lastResolvedPincode) {
    lookupPincode(pincode);
  }
});

function getLocation() {
  const spinner = document.getElementById('loc-spinner');
  const btnText = document.getElementById('loc-btn-text');

  if (navigator.geolocation) {
    spinner.style.display = 'block';
    btnText.textContent = 'Fetching...';

    navigator.geolocation.getCurrentPosition(showPosition, () => {
      spinner.style.display = 'none';
      btnText.textContent = 'Use my location';
      alert("Unable to retrieve location. Please check browser permissions.");
    });
  } else {
    alert("Geolocation is not supported.");
  }
}

function showPosition(position) {
  const lat = position.coords.latitude;
  const lon = position.coords.longitude;

  fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1&accept-language=en`)
    .then(res => res.json())
    .then(data => {
      if (data && data.address) {
        const addr = data.address;

        const district = addr.state_district || addr.district ||
          addr.county || addr.city_district || addr.city ||
          addr.town || addr.village || '';
        const postcode = String(addr.postcode || '')
          .replace(/\D/g, '')
          .slice(0, 6);

        setDistrictAsCity(district);
        selectStateByName(addr.state || '');

        if (postcode.length === 6) {
          pincodeInput.value = postcode;
          lastResolvedPincode = '';
          lookupPincode(postcode);
        }

        // House/building and Road/Area/Colony stay untouched so the
        // customer can enter the exact delivery address manually.
      }

      spinner.style.display = 'none';
      btnText.textContent = 'Use my location';
    })
    .catch(() => {
      document.getElementById('loc-spinner').style.display = 'none';
      document.getElementById('loc-btn-text').textContent = 'Use my location';
    });
}

function saveAddress() {
  const name = document.getElementById('name').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const pincode = document.getElementById('pincode').value.trim();
  const address = document.getElementById('address_line').value.trim();
  const locality = document.getElementById('locality').value.trim();
  const city = document.getElementById('city').value.trim();
  const state = document.getElementById('state').value.trim();
  const typeEl = document.querySelector('input[name="addrType"]:checked');
  const type = typeEl ? typeEl.value : 'Home';

  const addrData = { name, phone, pincode, address, locality, city, state, type };

  sessionStorage.setItem('selectedAddress', JSON.stringify(addrData));

  const params = new URLSearchParams(window.location.search);
  const product = params.get('product');
  if (product) {
    window.location.href = 'order-summary.php?product=' + encodeURIComponent(product);
  } else {
    window.location.href = 'order-summary.php';
  }
}
document.addEventListener("contextmenu", function (e) { e.preventDefault(); });
document.addEventListener("keydown", function (e) {
  if (e.ctrlKey && ["u", "U", "s", "S", "c", "C", "p", "P"].includes(e.key)) e.preventDefault();
  if (e.keyCode === 123) e.preventDefault();
});
document.addEventListener("dragstart", function (e) { e.preventDefault(); });
document.addEventListener("selectstart", function (e) { e.preventDefault(); });

(function () {
  const params = new URLSearchParams(window.location.search);
  const product = params.get('product');
  const backPage = product ? "product.php?product=" + encodeURIComponent(product) : "index.php";
  let isRedirecting = false;

  history.pushState({ backButtonGuard: true }, '', window.location.href);

  window.addEventListener('popstate', function () {
    if (isRedirecting) return;

    isRedirecting = true;
    window.location.replace(backPage);
  });
})();

document.addEventListener("DOMContentLoaded", function () {
  setTimeout(hidePageLoader, 100);
});

setTimeout(hidePageLoader, 500);
