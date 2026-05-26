document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('submitBtn');
    const modalAlertContainer = document.getElementById('modalAlertContainer');
    const alertContainer = document.getElementById('alertContainer');
    const contactModalEl = document.getElementById('contactModal');
    const modalInstance = bootstrap.Modal.getInstance(contactModalEl);
    
    if (!form.checkValidity()) {
        e.stopPropagation();
        form.classList.add('was-validated');
        return;
    }
    
    form.classList.remove('was-validated');
    submitBtn.disabled = true;
    modalAlertContainer.innerHTML = '';
    alertContainer.innerHTML = '';

    const formData = new FormData(form);

    fetch('contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        if (data.status === 'error') {
            modalAlertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show border-0 text-white shadow-sm" role="alert" style="background-color: #3b252c; border-left: 4px solid #f87171 !important;">
                    <div class="d-flex align-items-center">
                        <span class="me-2">⚠️</span>
                        <div><strong>Error:</strong> ${data.message}</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        } else if (data.status === 'success') {
            alertContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show border-0 text-white shadow-sm p-4" role="alert" style="background-color: #142e2b; border-left: 4px solid #34d399 !important;">
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-2 fs-4">✅</span>
                        <div><strong class="fs-5">Submission Success!</strong></div>
                    </div>
                    <p class="text-white-50 small mb-3">${data.message}</p>
                    
                    <div class="bg-dark bg-opacity-25 p-3 rounded border border-secondary border-opacity-25 small">
                        <div class="mb-1"><strong>Sender:</strong> ${data.data.name} (${data.data.email})</div>
                        <div class="mb-1"><strong>Subject:</strong> ${data.data.subject}</div>
                        <div class="mb-0 text-wrap"><strong>Message Summary:</strong> ${data.data.message}</div>
                    </div>
                    
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                
            form.reset();
            modalInstance.hide();
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        modalAlertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show border-0 text-white shadow-sm" role="alert" style="background-color: #3b252c; border-left: 4px solid #f87171 !important;">
                <div class="d-flex align-items-center">
                    <span class="me-2">⚠️</span>
                    <div><strong>Error:</strong> Something went wrong with the connection. Please try again.</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
    });
});