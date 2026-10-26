(function () {
  const root = document.getElementById("app-confirm");
  if (!root) return;

  const titleEl = document.getElementById("confirm-modal-title");
  const bodyEl = document.getElementById("confirm-modal-body");
  const submitBtn = document.getElementById("confirm-modal-submit");
  let pendingForm = null;

  function closeModal() {
    root.hidden = true;
    root.setAttribute("aria-hidden", "true");
    document.body.classList.remove("confirm-modal-open");
    pendingForm = null;
  }

  function openModal(opts) {
    pendingForm = opts.form;
    titleEl.textContent = opts.title || "Are you sure?";
    bodyEl.textContent = opts.body || "";
    submitBtn.textContent = opts.confirmLabel || "Confirm";
    submitBtn.className = "btn " + (opts.variant === "danger" ? "btn--danger" : "btn--lock-in");
    root.hidden = false;
    root.setAttribute("aria-hidden", "false");
    document.body.classList.add("confirm-modal-open");
    submitBtn.focus();
  }

  document.querySelectorAll("[data-confirm-open]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const formId = btn.getAttribute("data-confirm-form");
      const form = formId ? document.getElementById(formId) : btn.closest("form");
      if (!form) return;
      openModal({
        form,
        title: btn.getAttribute("data-confirm-title") || "Are you sure?",
        body: btn.getAttribute("data-confirm-body") || "",
        confirmLabel: btn.getAttribute("data-confirm-label") || "Confirm",
        variant: btn.getAttribute("data-confirm-variant") || "default",
      });
    });
  });

  root.querySelectorAll("[data-confirm-cancel]").forEach((el) => {
    el.addEventListener("click", closeModal);
  });

  submitBtn.addEventListener("click", () => {
    if (pendingForm) pendingForm.requestSubmit();
    closeModal();
  });

  document.addEventListener("keydown", (e) => {
    if (root.hidden) return;
    if (e.key === "Escape") {
      e.preventDefault();
      closeModal();
    }
  });
})();
