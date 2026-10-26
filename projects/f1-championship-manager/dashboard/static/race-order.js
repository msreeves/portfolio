(function () {
  const list = document.getElementById("result-order-list");
  const form = document.getElementById("race-lock-in-form");
  const hidden = document.getElementById("driver-order-input");
  if (!list || !form || !hidden) return;

  let dragEl = null;

  function items() {
    return Array.from(list.querySelectorAll(".result-order-item"));
  }

  function syncPositions() {
    items().forEach((item, index) => {
      const pos = item.querySelector(".result-order-pos");
      if (!pos) return;
      const n = index + 1;
      pos.textContent = String(n);
      pos.classList.toggle("pos-badge--p1", n === 1);
      pos.classList.toggle("pos-badge--muted", n !== 1);
    });
  }

  function serializeOrder() {
    const ids = [];
    items().forEach((item) => {
      const id = item.getAttribute("data-driver-id");
      if (id) ids.push(id);
    });
    hidden.value = JSON.stringify(ids);
  }

  function moveItem(item, direction) {
    if (!item) return;
    if (direction === "up") {
      const prev = item.previousElementSibling;
      if (prev) prev.before(item);
    } else if (direction === "down") {
      const next = item.nextElementSibling;
      if (next) next.after(item);
    }
    syncPositions();
    item.focus();
  }

  list.addEventListener("dragstart", (e) => {
    const item = e.target.closest(".result-order-item");
    if (!item) return;
    dragEl = item;
    item.classList.add("result-order-item--dragging");
    e.dataTransfer.effectAllowed = "move";
    e.dataTransfer.setData("text/plain", item.getAttribute("data-driver-id") || "");
  });

  list.addEventListener("dragend", () => {
    if (dragEl) dragEl.classList.remove("result-order-item--dragging");
    dragEl = null;
    syncPositions();
  });

  list.addEventListener("dragover", (e) => {
    e.preventDefault();
    const over = e.target.closest(".result-order-item");
    if (!over || !dragEl || over === dragEl) return;
    const rect = over.getBoundingClientRect();
    const after = e.clientY > rect.top + rect.height / 2;
    if (after) {
      over.after(dragEl);
    } else {
      over.before(dragEl);
    }
    syncPositions();
  });

  list.addEventListener("keydown", (e) => {
    const item = e.target.closest(".result-order-item");
    if (!item) return;
    if (e.key === "ArrowUp" && (e.altKey || e.metaKey)) {
      e.preventDefault();
      moveItem(item, "up");
    } else if (e.key === "ArrowDown" && (e.altKey || e.metaKey)) {
      e.preventDefault();
      moveItem(item, "down");
    }
  });

  form.addEventListener("submit", () => {
    serializeOrder();
  });

  syncPositions();
})();
