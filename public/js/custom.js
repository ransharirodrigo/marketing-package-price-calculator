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
        url: "/calculate-price",
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

                let resultHtml ="";
                if (priceDetails.length > 0) {
                    console.log("prices are there");
                    resultHtml = '<h5>Calculated Prices</h5>';
                    resultHtml += '<ul>';
                    priceDetails.forEach(detail => {
                        resultHtml += `<li>${detail.inventory_name} - ${detail.metrics_name}: ${detail.price} x ${detail.value} = ${detail.subtotal}</li>`;
                    });
                    resultHtml += '</ul>';
                    resultHtml += `<h3><strong>Total: ${totalPrice}</strong></h3>`;
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

                if (priceDetails.length>0) {
                    $("#downloadPdfBtn").prop("disabled", false);
                } else {
                    $("#downloadPdfBtn").prop("disabled", true);
                }

                $('#totalResult').html(resultHtml);
            }
        },
        error: function (error) {
            console.error('Error updating price:', error);
            alert('Error updating price.');
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
