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

    });
    window.pricetable=table;
}