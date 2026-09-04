function hidePageLoader() {
  const loader = document.getElementById('fkPageLoader');
  if (loader) {
    loader.classList.add('hide');
    setTimeout(() => {
      loader.style.display = 'none';
    }, 300);
  }
}

window.addEventListener('load', function () {
  setTimeout(hidePageLoader, 400);
});

setTimeout(hidePageLoader, 500);

/* Gently reveal the main products on a fresh visit. */
let homeAutoScrollCancelled = false;
let homeAutoScrollStarted = false;

function cancelHomeAutoScroll() {
  homeAutoScrollCancelled = true;
}

['touchstart', 'pointerdown', 'wheel', 'keydown'].forEach(eventName => {
  window.addEventListener(eventName, cancelHomeAutoScroll, {
    passive: true,
    once: true
  });
});

function revealHomeProducts(attempt = 0) {
  if (homeAutoScrollCancelled || homeAutoScrollStarted || window.scrollY > 80) return;

  const navigationEntry = performance.getEntriesByType?.('navigation')?.[0];
  if (navigationEntry && navigationEntry.type === 'back_forward') return;

  const firstProduct = document.querySelector('#pGrid .fk-product-card');
  if (!firstProduct) {
    if (attempt < 12) {
      setTimeout(() => revealHomeProducts(attempt + 1), 200);
    }
    return;
  }

  const productRect = firstProduct.getBoundingClientRect();
  const startY = window.scrollY;
  const targetY = Math.max(
    0,
    startY + productRect.top - (window.innerHeight * 0.32)
  );
  const distance = targetY - startY;
  if (distance < 24) return;

  homeAutoScrollStarted = true;
  const duration = Math.min(7000, Math.max(4800, Math.abs(distance) * 5));
  const startedAt = performance.now();

  function animateAutoScroll(now) {
    if (homeAutoScrollCancelled) return;

    const progress = Math.min(1, (now - startedAt) / duration);
    const eased = 0.5 - (Math.cos(Math.PI * progress) / 2);
    window.scrollTo(0, startY + (distance * eased));

    if (progress < 1) requestAnimationFrame(animateAutoScroll);
  }

  requestAnimationFrame(animateAutoScroll);
}

window.addEventListener('load', function () {
  setTimeout(() => revealHomeProducts(0), 3000);
});

const sharedSaleTimerKey = 'fk_sale_end_global';
const sharedSaleDurationMs = 2 * 60 * 60 * 1000;
let sharedSaleEndTime = Number(localStorage.getItem(sharedSaleTimerKey));

if (!Number.isFinite(sharedSaleEndTime) || sharedSaleEndTime <= Date.now()) {
  sharedSaleEndTime = Date.now() + sharedSaleDurationMs;
  localStorage.setItem(sharedSaleTimerKey, String(sharedSaleEndTime));
}

function updateDodSaleCountdown() {
  let remainingMs = sharedSaleEndTime - Date.now();

  if (remainingMs <= 0) {
    sharedSaleEndTime = Date.now() + sharedSaleDurationMs;
    localStorage.setItem(sharedSaleTimerKey, String(sharedSaleEndTime));
    remainingMs = sharedSaleDurationMs;
  }

  const totalSeconds = Math.max(0, Math.ceil(remainingMs / 1000));
  const hours = Math.floor(totalSeconds / 3600);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  const seconds = totalSeconds % 60;

  document.getElementById('dodH').textContent = String(hours).padStart(2, '0');
  document.getElementById('dodM').textContent = String(minutes).padStart(2, '0');
  document.getElementById('dodS').textContent = String(seconds).padStart(2, '0');
}

updateDodSaleCountdown();
setInterval(updateDodSaleCountdown, 1000);

let carInt;
function renderBanners(bns) {
  const bs = document.getElementById('bannerSection');
  const ci = document.getElementById('carInner');
  const cd = document.getElementById('carDots');
  clearInterval(carInt);
  if (!bns || bns.length === 0) { bs.style.display = 'none'; return; }
  bs.style.display = 'block';
  ci.innerHTML = bns.map(b => `<div class="carousel-item"><img src="${b}"></div>`).join('');
  cd.innerHTML = bns.map((b, i) => `<div class="nw-dot ${i === 0 ? 'active' : ''}"></div>`).join('');
  ci.style.transform = `translateX(0)`;
  if (bns.length > 1) {
    let cid = 0;
    const dts = document.querySelectorAll('.nw-dot');
    carInt = setInterval(() => {
      cid = (cid + 1) % bns.length;
      ci.style.transform = `translateX(-${cid * 100}%)`;
      dts.forEach((d, i) => d.classList.toggle('active', i === cid));
    }, 3000);
  }
}

let basePrds = APP_DATA.products;
let currPrds = [...basePrds];
let pIdx = 0;
const stp = 16;
let pLdg = false;

let currSort = 'rec';
let currFilter = null;

function populateBrands() {
  const bl = document.getElementById('brandList');
  const brands = APP_DATA.brands || [];
  if (brands.length === 0) { bl.innerHTML = '<div style="padding:10px 0;color:#888;font-size:13px">No brands available</div>'; return; }
  bl.innerHTML = brands.map(b => `<div class="sheet-opt ${currFilter === b ? 'active' : ''}" onclick="applyFilter('${b}', this)">${b}</div>`).join('');
}

function openSheet(id) {
  document.getElementById('sheetOverlay').style.display = 'block';
  setTimeout(() => document.getElementById(id).classList.add('active'), 10);
}
function closeSheets() {
  document.querySelectorAll('.sheet').forEach(s => s.classList.remove('active'));
  setTimeout(() => document.getElementById('sheetOverlay').style.display = 'none', 300);
}

let hasMore = true;
let currCat = 'all';
let isInitial = true;
let currQuery = '';

function updateList() {
  currPrds = [];
  pIdx = 0;
  hasMore = true;
  document.getElementById('pGrid').innerHTML = '';
  
  // Only use preloaded APP_DATA if it's the very first load and no filters/search exist
  if (isInitial && currCat === 'all' && !currFilter && currSort === 'rec' && !currQuery) {
    isInitial = false;
    let h = '';
    APP_DATA.products.forEach(p => {
       currPrds.push(p);
       h += gtCd(p);
    });
    document.getElementById('pGrid').insertAdjacentHTML('beforeend', h);
    pIdx += APP_DATA.products.length;
  } else {
    isInitial = false;
    fetchMore();
  }
}

function applySort(type, el) {
  document.querySelectorAll('#sortSheet .sheet-opt').forEach(e => e.classList.remove('active'));
  el.classList.add('active');
  currSort = type;
  updateList();
  closeSheets();
}

function applyFilter(brand, el) {
  document.querySelectorAll('#filterSheet .sheet-opt').forEach(e => e.classList.remove('active'));
  el.classList.add('active');
  currFilter = brand;
  updateList();
  closeSheets();
}
function clearFilter() {
  document.querySelectorAll('#filterSheet .sheet-opt').forEach(e => e.classList.remove('active'));
  currFilter = null;
  updateList();
  closeSheets();
}

function getRatingStars(rating) {
  rating = parseFloat(rating) || 0;
  let full = Math.floor(rating);
  let half = (rating - full) >= 0.5 ? 1 : 0;
  let empty = 5 - full - half;
  let html = '';
  for (let i = 0; i < full; i++) {
    html += '<i class="fas fa-star"></i>';
  }
  if (half) {
    html += '<i class="fas fa-star-half-alt"></i>';
  }
  for (let i = 0; i < empty; i++) {
    html += '<i class="far fa-star"></i>';
  }
  return html;
}

function gtCd(p) {
  let prH = `<span class="fk-selling">₹${p.price}</span>`;
  if (p.raw_mrp > p.raw_price && p.disc > 0) prH = `<span class="fk-discount">↓${p.disc}%</span><span class="fk-mrp">₹${p.mrp}</span><span class="fk-selling">₹${p.price}</span>`;
  return `<a href="${MAIN_URL}product/${p.slug}" class="fk-product-card"><button class="fk-wishlist"><svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button><div class="fk-img-wrap"><img src="${p.img}" loading="lazy"></div><div class="fk-info"><div class="fk-title">${p.name}</div><div class="fk-rating-row"><div class="product-rating-line"><span class="product-stars">${getRatingStars(p.rating)}</span><span class="product-review-count">(${p.reviews})</span></div><span class="fk-assured"><img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/fa_62673a.png" alt="Assured"></span></div><div class="fk-price-row">${prH}</div><div class="fk-bank-row"><span class="fk-wow">WOW!</span><span class="fk-bank-label">Bank Offer</span></div></div></a>`;
}

function fetchMore() {
  if (pLdg || !hasMore) return;
  pLdg = true; 
  document.getElementById('pLdr').style.display = 'flex';
  
  let url = `/api_products.php?offset=${currPrds.length}&limit=20&cat_id=${currCat}&sort=${currSort}`;
  if (currFilter) url += `&brand=${encodeURIComponent(currFilter)}`;
  if (currQuery) url += `&q=${encodeURIComponent(currQuery)}`;
  
  fetch(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-Token': typeof API_TOKEN !== 'undefined' ? API_TOKEN : ''
    }
  })
    .then(r => r.json())
    .then(data => {
       if (data.success && data.products) {
         hasMore = data.has_more;
         let h = '';
         data.products.forEach(p => {
            currPrds.push(p);
            h += gtCd(p);
         });
         document.getElementById('pGrid').insertAdjacentHTML('beforeend', h);
         pIdx += data.products.length;
       } else {
         hasMore = false;
       }
       
       // Hold the load lock for 400ms to prevent rapid-fire fetching on fast scrolls,
       // which causes DOM injection freezing (jank). This makes scrolling feel smooth.
       setTimeout(() => {
         pLdg = false;
         document.getElementById('pLdr').style.display = 'none';
       }, 400);
    })
    .catch(e => {
       setTimeout(() => {
         pLdg = false;
         document.getElementById('pLdr').style.display = 'none';
       }, 400);
    });
}

function ldPs() {
  if (hasMore) fetchMore();
}

function switchCat(e, id) {
  if (e) e.preventDefault();
  document.querySelectorAll('.nw-cat-item').forEach(t => t.classList.remove('active'));
  document.querySelectorAll(`.nw-cat-item[data-id="${id}"]`).forEach(el => el.classList.add('active'));

  currCat = id;
  currFilter = null;
  currQuery = '';
  const searchInput = document.getElementById('searchInput');
  if (searchInput) searchInput.value = '';

  if (id === 'all') {
    renderBanners(APP_DATA.globalBanners);
    document.getElementById('dodTitle').innerText = '';
    const suggSec = document.getElementById('suggestedSection');
    const grabSec = document.getElementById('grabSection');
    if (suggSec) suggSec.style.display = 'block';
    if (grabSec) grabSec.style.display = 'block';
  } else {
    const cat = APP_DATA.categories.find(c => c.id === id);
    const bns = (cat && cat.banners && cat.banners.length) ? cat.banners : APP_DATA.globalBanners;
    renderBanners(bns);
    document.getElementById('dodTitle').innerText = 'Category Offers';
    const suggSec = document.getElementById('suggestedSection');
    const grabSec = document.getElementById('grabSection');
    if (suggSec) suggSec.style.display = 'none';
    if (grabSec) grabSec.style.display = 'none';
  }
  populateBrands();
  updateList();
}

const stickyTabs = document.getElementById('stickyCatTabs');
const origTabs = document.getElementById('catTabs');
const sortFilter = document.querySelector('.fk-sort-filter');

window.addEventListener('scroll', () => {
  const rect = origTabs.getBoundingClientRect();
  if (rect.bottom < 0) {
    stickyTabs.classList.add('show');
    sortFilter.style.top = stickyTabs.offsetHeight + 'px';
  } else {
    stickyTabs.classList.remove('show');
    sortFilter.style.top = '0px';
  }
  
  const scrollTop = window.scrollY || document.documentElement.scrollTop;
  const docHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
  const winHeight = window.innerHeight;
  
  if ((scrollTop + winHeight) >= docHeight - 600) {
    ldPs();
  }
}, { passive: true });

document.getElementById('searchForm')?.addEventListener('submit', e => {
  e.preventDefault();
  document.getElementById('searchInput')?.blur();
});

let searchTimeout;
document.getElementById('searchInput')?.addEventListener('input', e => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    currQuery = e.target.value.trim();
    if (currQuery !== '') {
      currCat = 'all';
      currFilter = null;
      document.querySelectorAll('.nw-cat-item').forEach(t => t.classList.remove('active'));
      
      // Hide sections for search results
      const bs = document.getElementById('bannerSection');
      if (bs) bs.style.display = 'none';
      
      const title = document.getElementById('dodTitle');
      if (title) title.innerText = `Search Results for "${currQuery}"`;
      
      const suggSec = document.getElementById('suggestedSection');
      const grabSec = document.getElementById('grabSection');
      if (suggSec) suggSec.style.display = 'none';
      if (grabSec) grabSec.style.display = 'none';
    } else {
      switchCat(null, 'all');
      return;
    }
    isInitial = false;
    updateList();
  }, 400);
});

window.addEventListener('load', () => {
  document.querySelector('.sheet-opt[data-sort="rec"]')?.classList.add('active');
  switchCat(null, 'all');
});

document.addEventListener("contextmenu", e => e.preventDefault());
document.addEventListener("keydown", e => {
  if (e.ctrlKey && ["u", "U", "s", "S", "c", "C", "p", "P"].includes(e.key)) e.preventDefault();
  if (e.keyCode === 123) e.preventDefault();
});
document.addEventListener("dragstart", e => e.preventDefault());
document.addEventListener("selectstart", e => e.preventDefault());
