function loadBusinessTypeTableData() {
    var table = $('#business_type_table').DataTable({
        ajax: {
            url: businessListUrl,
            type: 'GET',
            dataSrc: '',
        },
        columns: [
            { data: 'no', orderable: false },
            { data: 'business', orderable: false },
            { data: "action", orderable: false }
        ],
        searching: false,

    });
    window.businessTypeTable = table;
}

function loadPriceMetricsTable() {
    var table = $('#price_metric_table').DataTable({
        ajax: {
            url: priceListUrl,
            type: 'GET',
            dataSrc: '',
        },
        columns: [
            { data: 'no', orderable: false },
            { data: 'business', orderable: false },
            { data: "inventory", orderable: false },
            { data: "metric", orderable: false },
            { data: "price", orderable: false },
            { data: "action", orderable: false }
        ],
        searching: false,

    });
    window.pricetable=table;
}

var orderTable;

function loadOrderTable(){
    orderTable  = $('#order_table').DataTable({
        ajax: {
            url: orderListUrl,
            type: 'GET',
            dataSrc: '',
            data: function (d) {
                d.type = $('#sortType').val();
                d.value = $('#sortValue').val();
            }
        },
        columns: [
            { data: 'no', orderable: false },
            { data: 'customer_name', orderable: false },
            { data: "customer_mobile", orderable: false },
            { data: "customer_email", orderable: false },
            { data: "customer_address", orderable: false },
            { data: "invoice_number", orderable: false },
            { data: "action", orderable: false }
        ],
        searching: false,

    });
    window.orderTable=orderTable;
}

$('#applySort').click(function() {
    orderTable.ajax.reload(); 
});