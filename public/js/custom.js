toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right"
};

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
