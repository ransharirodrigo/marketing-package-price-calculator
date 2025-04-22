toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right"
};

function isValidSriLankanMobile(mobileNumber) {
    const sriLankanMobileRegex = /^(0|\+94)(7\d|11|2\d|3\d|4\d|5\d|6\d|81|91)\d{7}$/;
    return sriLankanMobileRegex.test(mobileNumber);
}

function validateDoubleValues(input) {
    let value = input.value;

    if (value.startsWith('.')) {
        input.value = "";
        return false;
    }

    input.value = value.replace(/[^0-9.]/g, '');

    const dotCount = (value.match(/\./g) || []).length;

    if (dotCount > 1) {
        input.value = value.slice(0, value.length - 1);
        return false;
    }

    if (isNaN(parseFloat(value)) && value !== "" && value !== ".") {
        input.value = "";
        return false;
    }

    return true;
}

function calculateTotal() {
    let formData = $('#price-calculate-form').serialize();

    $.ajax({
        url: "calculate-price",
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.error) {
                toastr.error(response.message, "Error");
                return;
            } else {
                let result = response.data;
                let totalPrice = result.total_price;
                let missingPrices = result.missing_prices;
                let priceDetails = result.price_details;
                let business_id = result.business_id;

                let resultHtml = "";
                if (priceDetails.length > 0) {
                    // console.log("prices are there");

                    resultHtml += `<input type="hidden" id="business_id" class="business_id" value="${business_id}"/>`;
                    resultHtml += '<h5 style="font-size: 1em;">Calculated Prices</h5>';
                    resultHtml += '<table class="items-table" style="width: 100%;">';
                    resultHtml += '<thead>';
                    resultHtml += '<tr>';
                    resultHtml += '<th style="border: 1px solid #ddd; padding: 6px; text-align: left; font-size:14px;">Description</th>';
                    resultHtml += '<th style="border: 1px solid #ddd; padding: 6px; text-align: left;  font-size:14px;">Rate</th>';
                    resultHtml += '<th style="border: 1px solid #ddd; padding: 6px; text-align: left;  font-size:14px;">Qty</th>';
                    resultHtml += '<th style="border: 1px solid #ddd; padding: 6px; text-align: right;  font-size:14px;">Line Total</th>';
                    resultHtml += '</tr>';
                    resultHtml += '</thead>';
                    resultHtml += '<tbody>';

                    priceDetails.forEach(detail => {
                        resultHtml += '<tr>';
                        resultHtml += `<td style="border: 1px solid #ddd; padding: 6px;  font-size:14px;">${detail.inventory_name} - ${detail.metrics_name}</td>`;
                        resultHtml += `<td style="border: 1px solid #ddd; padding: 6px; font-size:14px;">${detail.price}</td>`;
                        resultHtml += `<td style="border: 1px solid #ddd; padding: 6px;  font-size:14px;">${detail.value}</td>`;
                        resultHtml += `<td style="border: 1px solid #ddd; padding: 6px; text-align: right;  font-size:14px;">${detail.subtotal}</td>`;
                        resultHtml += '</tr>';
                    });

                    resultHtml += '</tbody>';
                    resultHtml += '</table>';
                    resultHtml += `<h3 style="font-size: 1.1em;"><strong>Total: ${totalPrice}</strong></h3>`;
                }
                if (missingPrices.length > 0) {
                    console.log("prices are not there");
                    resultHtml += '<h5>Missing Prices</h5>';
                    resultHtml += '<ul>';
                    missingPrices.forEach(missing => {
                        resultHtml += `<li>${missing.inventory_name} - ${missing.metrics_name}</li>`;
                    });
                    resultHtml += '</ul>';
                }

                if (priceDetails.length > 0) {
                    $("#downloadPdfBtn").prop("disabled", false);
                } else {
                    $("#downloadPdfBtn").prop("disabled", true);
                }

                $('#totalResult').html(resultHtml);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error', jqXHR.responseJSON);
            console.error('Error', jqXHR.responseJSON);
            let errorMessage = 'Error calculating price.';
        
            // Try to parse the JSON response if the content type indicates it
            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                errorMessage += ' ' + jqXHR.responseJSON.message;
            } else if (errorThrown) {
                errorMessage += ' ' + errorThrown; // Default error message from jQuery
            } else if (textStatus) {
                errorMessage += ' ' + textStatus; // Status such as 'timeout', 'abort', 'error'
            }
        
            toastr.error(errorMessage, "Error"); // Use Toastr to display the error
        }
    });
}

//BUSINESS SELECT - LOAD APPROPRIATE INVENTORIES TO THE RELATED BUSINESS
$("#business_id").on("change", function () {
    const selected_value = $(this).val();
    const inventoryDropdown = $("#inventory_id");

    if (selected_value && selected_value !== "") {
        $.ajax({
            url: 'business-related-inventory',
            method: 'GET',
            data: { businessId: selected_value },
            success: function (data) {
                inventoryDropdown.empty();
                inventoryDropdown.append('<option value="">Select Inventory</option>');

                if (data.error === false && data.message && Array.isArray(data.message)) {
                    data.message.forEach(inventory => {
                        inventoryDropdown.append(`<option value="${inventory.id}">${inventory.name}</option>`);
                    });
                } else {
                    console.error("Invalid data format received:", data);
                }
            },
            error: function (error) {
                console.error("AJAX error:", error);
            }
        });

    } else {
        inventoryDropdown.empty();
        inventoryDropdown.append('<option value="">Select Inventory</option>');
    }
});


// SORT TYPE CHANGE
$("#sortType").on("change", function () {
    var selectedType = $(this).val();

    $("#sortValue").prop("disabled", false);
    $("#sortValue").empty().append('<option value="">Select Value</option>');

    if (selectedType) {
        $.ajax({
            url: 'get-sort-values',
            type: 'GET',
            data: { sortType: selectedType },
            dataType: 'json',
            success: function (data) {
               
                if (data && Object.keys(data).length > 0) {
                
                    $.each(data, function (key, value) {
                     
                        $("#sortValue").append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", status, error);
            }
        });
    } else {
        $("#sortValue").prop("disabled", true);
        $("#sortValue").empty().append('<option value="">Select Value</option>');
    }
});

$("#logout-btn").on("click",function(){
    $.ajax({
        url: 'logout',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
                        window.location.href = '/'; 
        },
        error: function(xhr, status, error) {
            console.error('Logout failed:', error);
        }
    });
});