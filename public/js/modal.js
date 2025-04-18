$('#addBusinessModal').on('hidden.bs.modal', function (e) {
    $('#businessName').val('');
    $(this).remove();
});

$('#addPriceMetricsModal').on('hidden.bs.modal', function (e) {
    $('#business_id').val('');
    $('#inventory_id').val('');
    $('#addPriceMetricsForm').find('input').val('');
});

$('#downloadModal').on('hidden.bs.modal', function (e) {
    $('#clientName').val('');
    $('#clientAddress').val('');
    $('#clientMobileNumber').val('');
    $('#clientEmail').val('');
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
                window.location.reload();
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

$(document).on('click', '.edit-business-btn', function () {
    let businessId = $(this).data('id');
    let url = $(this).data('url');

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            $('#updateBusinessModal input[name="id"]').val(response.id);
            $('#updateBusinessModal input[name="name"]').val(response.name);

            $('#updateBusinessModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching business data for edit:', error);
            alert('Error fetching business edit data.');
        }
    });
});

$(document).on('click', '.delete-btn', function () {
    let businessId = $(this).data('id');
    let deleteUrl = $(this).data('url'); 

    
        $.ajax({
            url: deleteUrl, 
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, "Success");
                    window.businessTypeTable.ajax.reload(null, false);
                } else {
                    console.log(response)
                    toastr.error("An unexpected error occurred.", "Error");
                }
            },
            error: function (error) {
                console.log(error)
                toastr.error("An unexpected error occurred.", "Error");
            }
        });
    
});

$(document).on('click', '#updateBusinessSubmit', function () {
    let formData = $('#updateBusinessForm').serialize();
    let businessId = $('#updateBusinessModal input[name="id"]').val();
    let url = '/businesses/' + businessId;

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#updateBusinessModal').modal('hide');
            toastr.success(response.message, "Success");
            window.businessTypeTable.ajax.reload(null, false);
            window.pricetable.ajax.reload(null, false);
        
            $('#business_id option[value="' + businessId + '"]').text(response.name);
        },
        error: function (error) {
            console.error('Error updating business data:', error);
            alert('Error updating business data.');
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

    $.ajax({
        url: 'save-new-price-metrics',
        type: 'POST',
        data: $('#addPriceMetricsForm').serialize(),
        success: function (response) {

            if (response.error) {
                toastr.error(response.message, "Error");
            } else {
                toastr.success(response.message, "Success");
                modalClose(addPriceMetricsModal);
                window.pricetable.ajax.reload(null, false);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR)
            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                toastr.error(jqXHR.responseJSON.message, "Error");
            } else {
                toastr.error("An unexpected error occurred.", "Error");
            }
        }

    });
});

$(document).on('click', '.price-metrics-edit-btn', function () {

    let id = $(this).data('id');
    let url = $(this).data('url');

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            $('#updatePriceModal input[name="id"]').val(response.id);
            $('#business_label').text(response.business.name);
            $('#inventory_label').text(response.inventory.name);
            $('#metrics_label').text(response.metrics.name);
            $('#business_id').val(response.business_id);
            $('#inventory_id').val(response.inventory_id);
            $('#metrics_id').val(response.metrics_id);
            $('#updatePriceModal input[name="price"]').val(response.price);

            $('#updatePriceModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching data for edit:', error);
            alert('Error fetching edit data.');
        }
    });
});

$(document).on('click', '#update_price_metrics', function () {

    let formData = $('#updatePriceForm').serialize();
    let url = 'business-inventory-metric-prices-update';

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (response) {
            $('#updatePriceModal').modal('hide');
            toastr.success(response.message, "Success");
            window.pricetable.ajax.reload(null, false);
        },
        error: function (error) {
            console.error('Error updating price:', error);
            alert('Error updating price.');
        }
    });
});


$(document).on('click', '.view-invoice-items-btn', function () {
    let invoiceNumber = $(this).data('id');
    let url = $(this).data('url');
    let modal = $('#invoiceItemModal');
    let container = $('#invoice-items-container');
    let modalTitle = $('#invoiceItemModalLabel');
    let business_name = $('#business_name');

    container.empty(); 
    modalTitle.text(`Invoice Items for Invoice: ${invoiceNumber}`);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {

            console.log(data);
            if (data && data.length > 0) {
                business_name.text(`Business: ${data[0].business}`);

                let tableHtml = '<table class="table table-bordered">';
                tableHtml += '<thead><tr><th>Description</th><th>Rate</th><th>Qty</th><th>Line Total</th></tr></thead><tbody>';

                let total = 0;

                $.each(data, function (index, item) {
                    tableHtml += `<tr><td>${item.description}</td><td>${item.rate}</td><td>${item.qty}</td><td>${item.line_total}</td></tr>`;
                    total += parseFloat(item.line_total); 
                });

                tableHtml += '</tbody></table>';
                container.append(tableHtml);

                container.append(`<h4 class="mt-3">Total: LKR ${total.toFixed(2)}</h4>`);
            } else {
                container.append('<p>No items found for this invoice.</p>');
            }
            modal.modal('show');
        },
        error: function (xhr, status, error) {
            console.error("Error fetching invoice items:", error);
            container.append('<p class="text-danger">Error loading invoice items.</p>');
            modal.modal('show');
        }
    });
});