$('#addBusinessModal').on('hidden.bs.modal', function (e) {
    $('#businessName').val('');
    $(this).remove();
});

function modalClose(modal) {
    modal.modal("hide");
}

// BUSINESS MODAL
var addBusinessModal = $('#addBusinessModal');

$("#addBusiness").on("click", function () {
    addBusinessModal.modal('show');
});

$("#closeBusinessModal").on("click", function () {
    modalClose(addBusinessModal);
});

$("#saveBusiness").on("click", function (event) {
    event.preventDefault();

    $.ajax({
        url: 'save-new-business',
        type: 'POST',
        data: $('#addBusinessForm').serialize(),
        success: function (response) {

            if (response.error) {
                toastr.error(response.message, "Error");
            } else {
                toastr.success(response.message, "Success");
                modalClose(addBusinessModal);
                window.businessTypeTable.ajax.reload(null, false);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                toastr.error(jqXHR.responseJSON.message, "Error");
            } else {
                toastr.error("An unexpected error occurred.", "Error");
            }
        }

    });
});


// PRICE METRICS MODAL
var addPriceMetricsModal = $('#addPriceMetricsModal');

$("#addPriceMetrics").on("click", function () {
    addPriceMetricsModal.modal('show');
});

$("#closePriceMetricsModal").on("click", function () {
    modalClose(addPriceMetricsModal);
});

$("#savePriceMetrics").on("click", function (event) {
    event.preventDefault();
});