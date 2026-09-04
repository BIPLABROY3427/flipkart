// Disable Right Click (Context Menu)
document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});

// Disable Keyboard Shortcuts for Developer Tools and View Source
document.onkeydown = function (e) {
    // F12 key
    if (e.keyCode === 123) {
        return false;
    }

    // Ctrl+Shift+I (Windows) or Cmd+Option+I (Mac) for DevTools
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.keyCode === 73) {
        return false;
    }

    // Ctrl+Shift+J (Windows) or Cmd+Option+J (Mac) for Console
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.keyCode === 74) {
        return false;
    }

    // Ctrl+U (Windows) or Cmd+Option+U (Mac) for View Source
    if ((e.ctrlKey || e.metaKey) && e.keyCode === 85) {
        return false;
    }

    // Ctrl+Shift+C (Windows) or Cmd+Option+C (Mac) for Inspect Element
    if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.keyCode === 67) {
        return false;
    }
};

// Disable Text Selection and Dragging
document.addEventListener('selectstart', function(e) { e.preventDefault(); });
document.addEventListener('dragstart', function(e) { e.preventDefault(); });

// Advanced DevTools Blocker (Anti-Debugger Loop)
// This will freeze the DevTools if they somehow manage to open it
setInterval(function() {
    (function() {
        return false;
    }
    ['constructor']('debugger')
    ['call']());
}, 50);
