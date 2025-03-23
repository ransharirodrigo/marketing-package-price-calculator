window.formatActionButtons = function (data, type, row) {
    console.log(row)
    return '<button class="edit-btn" data-id="' + row.id + '">Edit</button>' +
        '<button class="delete-btn" data-id="' + row.id + '">Delete</button>';
};
