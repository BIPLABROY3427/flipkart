document.addEventListener('click', function(event) {
          const target = event.target instanceof Element ? event.target : null;
          const colourLink = target ? target.closest('a.fk-color-thumb') : null;

          if (!colourLink || event.defaultPrevented) {
            return;
          }

          if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
          }

          event.preventDefault();

          if (!colourLink.classList.contains('active')) {
            window.location.replace(colourLink.href);
          }
        });

        (function() {
          'use strict';

          const MORE_TEXT = '...more';

          function splitCharacters(text) {
            const value = String(text || '');

            if (window.Intl && typeof Intl.Segmenter === 'function') {
              try {
                const segmenter = new Intl.Segmenter(undefined, {
                  granularity: 'grapheme'
                });
                return Array.from(segmenter.segment(value), function(part) {
                  return part.segment;
                });
              } catch (error) {

              }
            }

            return Array.from(value);
          }

          function createMoreButton(box) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'expandable-inline-more';
            button.textContent = MORE_TEXT;
            button.setAttribute(
              'aria-label',
              box.classList.contains('product-title') ?
              'Show full product name' :
              'Show full review comment'
            );
            button.setAttribute('aria-expanded', 'false');
            return button;
          }

          function getMoreReserveWidth(box, containerWidth) {
            const isProductTitle = box.classList.contains('product-title');
            const ratio = isProductTitle ? 0.30 : 0.24;
            const minimum = isProductTitle ? 88 : 72;
            const maximum = isProductTitle ? 132 : 116;

            return Math.min(maximum, Math.max(minimum, containerWidth * ratio));
          }

          function renderCollapsedContent(box, content, text, reserveWidth) {
            content.replaceChildren();
            content.appendChild(document.createTextNode(text.replace(/[\s\u00A0]+$/u, '')));
            content.appendChild(createMoreButton(box));

            if (Number.isFinite(reserveWidth) && reserveWidth > 0) {
              const spacer = document.createElement('span');
              spacer.className = 'expandable-more-reserve';
              spacer.setAttribute('aria-hidden', 'true');
              spacer.style.display = 'inline-block';
              spacer.style.width = reserveWidth + 'px';
              spacer.style.height = '1px';
              spacer.style.visibility = 'hidden';
              spacer.style.pointerEvents = 'none';
              content.appendChild(spacer);
            }
          }

          function renderFullContent(content, text) {
            content.textContent = text;
          }

          function makeMeasurementCopy(box, width) {
            const copy = box.cloneNode(false);
            copy.removeAttribute('id');
            copy.classList.remove('is-ready', 'is-expanded', 'is-overflowing');
            copy.classList.add('expandable-measure-copy');
            copy.style.width = width + 'px';

            const content = document.createElement('span');
            content.className = 'expandable-content';
            copy.appendChild(content);
            document.body.appendChild(copy);

            return {
              copy: copy,
              content: content
            };
          }

          function getLineHeight(element) {
            const styles = window.getComputedStyle(element);
            let lineHeight = parseFloat(styles.lineHeight);

            if (!Number.isFinite(lineHeight)) {
              const fontSize = parseFloat(styles.fontSize) || 16;
              lineHeight = fontSize * 1.4;
            }

            return lineHeight;
          }

          function fitsWithinLines(copy, lineHeight, lineLimit) {
            const allowedHeight = (lineHeight * lineLimit) + 0.75;
            return copy.scrollHeight <= allowedHeight;
          }

          function findExactCollapsedText(box, fullText, width, lineLimit) {
            const measure = makeMeasurementCopy(box, width);
            const copy = measure.copy;
            const content = measure.content;
            const lineHeight = getLineHeight(copy);

            renderFullContent(content, fullText);
            const overflowing = !fitsWithinLines(copy, lineHeight, lineLimit);

            if (!overflowing) {
              copy.remove();
              return {
                overflowing: false,
                text: fullText
              };
            }

            const characters = splitCharacters(fullText);
            const reserveWidth = getMoreReserveWidth(box, width);
            let low = 0;
            let high = characters.length;
            let best = '';

            while (low <= high) {
              const middle = Math.floor((low + high) / 2);
              const candidate = characters
                .slice(0, middle)
                .join('')
                .replace(/[\s\u00A0]+$/u, '');

              renderCollapsedContent(box, content, candidate, reserveWidth);

              if (fitsWithinLines(copy, lineHeight, lineLimit)) {
                best = candidate;
                low = middle + 1;
              } else {
                high = middle - 1;
              }
            }

            if (best) {
              let safeChars = splitCharacters(best);
              while (safeChars.length > 0) {
                const candidate = safeChars.join('').replace(/[\s\u00A0]+$/u, '');
                renderCollapsedContent(box, content, candidate, reserveWidth);

                if (fitsWithinLines(copy, lineHeight, lineLimit)) {
                  best = candidate;
                  break;
                }

                safeChars.pop();
              }
            }

            copy.remove();
            return {
              overflowing: true,
              text: best
            };
          }

          function refreshExpandableText(box) {
            const content = box.querySelector('.expandable-content');
            if (!content) return;

            if (!content.dataset.fullText) {
              content.dataset.fullText = content.textContent || '';
            }

            const fullText = content.dataset.fullText;
            const lineLimit = Math.max(1, Number(box.dataset.lines || 2));
            const wasExpanded = box.classList.contains('is-expanded');
            const width = box.getBoundingClientRect().width;

            if (!width || !fullText.trim()) {
              renderFullContent(content, fullText);
              box.classList.add('is-ready');
              box.classList.remove('is-expanded', 'is-overflowing');
              return;
            }

            const result = findExactCollapsedText(box, fullText, width, lineLimit);
            content.dataset.collapsedText = result.text;
            box.classList.toggle('is-overflowing', result.overflowing);
            box.classList.add('is-ready');

            if (!result.overflowing) {
              box.classList.remove('is-expanded');
              renderFullContent(content, fullText);
              box.removeAttribute('tabindex');
              box.removeAttribute('role');
              box.removeAttribute('aria-label');
              return;
            }

            if (wasExpanded) {
              box.classList.add('is-expanded');
              renderFullContent(content, fullText);
              box.setAttribute('tabindex', '0');
              box.setAttribute('role', 'button');
              box.setAttribute('aria-label', 'Collapse full text');
            } else {
              box.classList.remove('is-expanded');
              renderCollapsedContent(box, content, result.text);
              box.removeAttribute('tabindex');
              box.removeAttribute('role');
              box.removeAttribute('aria-label');
            }
          }

          function refreshAllExpandableText() {
            document.querySelectorAll('.expandable-text').forEach(refreshExpandableText);
          }

          function expandBox(box) {
            const content = box && box.querySelector('.expandable-content');
            if (!box || !content || !box.classList.contains('is-overflowing')) return;

            box.classList.add('is-expanded');
            renderFullContent(content, content.dataset.fullText || '');
            box.setAttribute('tabindex', '0');
            box.setAttribute('role', 'button');
            box.setAttribute('aria-label', 'Collapse full text');
          }

          function collapseBox(box) {
            const content = box && box.querySelector('.expandable-content');
            if (!box || !content || !box.classList.contains('is-overflowing')) return;

            box.classList.remove('is-expanded');
            renderCollapsedContent(box, content, content.dataset.collapsedText || '');
            box.removeAttribute('tabindex');
            box.removeAttribute('role');
            box.removeAttribute('aria-label');
          }

          document.addEventListener('click', function(event) {
            const moreButton = event.target.closest('.expandable-inline-more');

            if (moreButton) {
              event.preventDefault();
              event.stopPropagation();
              expandBox(moreButton.closest('.expandable-text'));
              return;
            }

            const expandedBox = event.target.closest('.expandable-text.is-expanded');
            if (expandedBox) {
              collapseBox(expandedBox);
            }
          });

          document.addEventListener('keydown', function(event) {
            const box = event.target.closest && event.target.closest('.expandable-text.is-expanded');
            if (!box || (event.key !== 'Enter' && event.key !== ' ')) return;

            event.preventDefault();
            collapseBox(box);
          });

          let resizeTimer = null;
          window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(refreshAllExpandableText, 120);
          });

          document.addEventListener('DOMContentLoaded', function() {
            requestAnimationFrame(refreshAllExpandableText);

            if (document.fonts && document.fonts.ready) {
              document.fonts.ready
                .then(refreshAllExpandableText)
                .catch(function() {});
            }
          });
        })();

        const reviewImageModal = document.getElementById('reviewImageModal');
        const reviewImagePreview = document.getElementById('reviewImagePreview');
        const reviewImageClose = document.getElementById('reviewImageClose');

        document.addEventListener('click', function(event) {
          const imageButton = event.target.closest('[data-review-image]');

          if (imageButton && reviewImageModal && reviewImagePreview) {
            reviewImagePreview.src = imageButton.getAttribute('data-review-image') || '';
            reviewImageModal.classList.add('show');
            reviewImageModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            return;
          }

          if (
            reviewImageModal &&
            (event.target === reviewImageModal || event.target === reviewImageClose)
          ) {
            reviewImageModal.classList.remove('show');
            reviewImageModal.setAttribute('aria-hidden', 'true');
            reviewImagePreview.src = '';
            document.body.style.overflow = '';
          }
        });

        document.addEventListener('keydown', function(event) {
          if (event.key === 'Escape' && reviewImageModal && reviewImageModal.classList.contains('show')) {
            reviewImageModal.classList.remove('show');
            reviewImageModal.setAttribute('aria-hidden', 'true');
            reviewImagePreview.src = '';
            document.body.style.overflow = '';
          }
        });

        function hidePageLoader() {
          const loader = document.getElementById("fkPageLoader");
          if (loader) {
            loader.classList.add("hide");
            setTimeout(function() {
              loader.style.display = "none";
            }, 300);
          }
        }
        const track = document.getElementById('sliderTrack');
        const dots = document.querySelectorAll('.dot');

        if (dots.length > 1) {
          let slideIndex = 0;
          track.addEventListener('scroll', () => {
            let idx = Math.round(track.scrollLeft / track.clientWidth);
            dots.forEach(d => d.classList.remove('active'));
            if (dots[idx]) dots[idx].classList.add('active');
            slideIndex = idx;
          });

          let autoSlide = setInterval(() => {
            slideIndex = (slideIndex + 1) % dots.length;
            track.scrollTo({
              left: slideIndex * track.clientWidth,
              behavior: 'smooth'
            });
          }, 3000);

          track.addEventListener('touchstart', () => clearInterval(autoSlide), {
            passive: true
          });
        }

        const adCarousel = document.getElementById('adCarousel');
        if (adCarousel) {
          setInterval(() => {
            if (adCarousel.scrollLeft + adCarousel.clientWidth >= adCarousel.scrollWidth - 10) {
              adCarousel.scrollTo({
                left: 0,
                behavior: 'smooth'
              });
            } else {
              adCarousel.scrollBy({
                left: window.innerWidth,
                behavior: 'smooth'
              });
            }
          }, 3500);
        }

        const saleCountdown = document.getElementById('saleCountdown');
        if (saleCountdown) {
          const saleHours = document.getElementById('saleHours');
          const saleMinutes = document.getElementById('saleMinutes');
          const saleSeconds = document.getElementById('saleSeconds');
          const durationSeconds = Number(saleCountdown.dataset.durationSeconds || 7200);
          const durationMs = Math.max(1, durationSeconds) * 1000;
          const productTimerKey = 'fk_sale_end_global';
          let saleEndTime = Number(localStorage.getItem(productTimerKey));

          if (!Number.isFinite(saleEndTime) || saleEndTime <= Date.now()) {
            saleEndTime = Date.now() + durationMs;
            localStorage.setItem(productTimerKey, String(saleEndTime));
          }

          const twoDigits = value => String(Math.max(0, value)).padStart(2, '0');

          function updateSaleCountdown() {
            let remainingMs = saleEndTime - Date.now();

            if (remainingMs <= 0) {
              saleEndTime = Date.now() + durationMs;
              localStorage.setItem(productTimerKey, String(saleEndTime));
              remainingMs = durationMs;
            }

            const totalSeconds = Math.max(0, Math.ceil(remainingMs / 1000));
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            saleHours.textContent = twoDigits(hours);
            saleMinutes.textContent = twoDigits(minutes);
            saleSeconds.textContent = twoDigits(seconds);
          }

          updateSaleCountdown();
          setInterval(updateSaleCountdown, 1000);
        }

        const timerEl = document.getElementById('countdown-timer');
        if (timerEl) {
          let h = 1,
            m = 57,
            s = 53;

          function updateTimer() {
            s--;
            if (s < 0) {
              s = 59;
              m--;
            }
            if (m < 0) {
              m = 59;
              h--;
            }
            if (h < 0) {
              h = 23;
            }
            timerEl.innerHTML = (h < 10 ? "0" + h : h) + "h " + (m < 10 ? "0" + m : m) + "m " + (s < 10 ? "0" + s : s) + "s";
          }
          setInterval(updateTimer, 1000);
        }

        function shareProduct() {
          const prodName = "Apple iPhone 16 Pro Max 512 GB: 5G Mobile Phone with Camera Control, 4K 120 fps Dolby Vision and a Huge Leap in Battery Life. Works with AirPods";
          if (navigator.share) {
            navigator.share({
              title: prodName,
              text: 'Check out ' + prodName + ' on Flipkart Now!',
              url: window.location.href
            }).catch(console.error);
          } else {
            alert('Sharing is not supported on this browser.');
          }
        }

        document.addEventListener("contextmenu", function(e) {
          e.preventDefault();
        });
        document.addEventListener("keydown", function(e) {
          if (e.ctrlKey && ["u", "U", "s", "S", "c", "C", "p", "P"].includes(e.key)) e.preventDefault();
          if (e.keyCode === 123) e.preventDefault();
        });
        document.addEventListener("dragstart", function(e) {
          e.preventDefault();
        });
        document.addEventListener("selectstart", function(e) {
          e.preventDefault();
        });

        window.addEventListener("load", function() {
          setTimeout(hidePageLoader, 100);
        });

        setTimeout(hidePageLoader, 500);