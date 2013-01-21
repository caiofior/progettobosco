/**
 * Profile functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#user").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "user.id"},
            { "sName": "username"},
            { "sName": "first_name" },
            { "sName": "phone" },
            { "sName": "address_city"},
            { "sName": "organization" },
            { "sName": "creation_datetime" },
            { "sName": "actions" }

        ],
        "bJQueryUI": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user.php"
});


