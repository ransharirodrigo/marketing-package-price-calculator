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