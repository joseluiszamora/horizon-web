//baseUrl = "http://localhost/horizon/index.php/"
baseUrl = "http://www.ruizmier.com/systems/horizon/"
function datatables_transactions() {
    var colTransactions=[ 0, 1, 2, 3, 4 ];
    $('.table_transactions').dataTable( {
        "sPaginationType": "full_numbers",
        "sDom": '<"H"Tfr>t<"F"ip>',
        "iDisplayLength": 20,
        "bFilter": false,
        "oTableTools": {
            "aButtons": [
            {
                "sExtends": "pdf",
                "sButtonText": "PDF",
                "mColumns": colTransactions
            }
            ]
        }
    } );
}
function datatables_clients() {
    var colClients=[ 0, 1, 2, 3, 4 ];
    $('.table_clients').dataTable( {
        "sPaginationType": "full_numbers",
        "sDom": '<"H"Tfr>t<"F"ip>',
        "iDisplayLength": 20,
        "bFilter": false,
        "oTableTools": {
            "aButtons": [
            {
                "sExtends": "pdf",
                "sButtonText": "PDF",
                "mColumns": colClients
            }
            ]
        }
    } );
}

$(document).ready( function () {
    count_transactions=0;
    count_clients=0;


    $(".tab_transactions").click(function(e) {
        if(count_transactions==0) {
            datatables_transactions();
            count_transactions++;
        }
    });

    $(".tab_clients").click(function(e) {
        if(count_transactions==0) {
            datatables_clients();
            count_clients++;
        }
    });

    $("#search_transaction .search").click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: baseUrl+"report/get_transactions/",
          data: $('#search_transaction').serialize(),
          //dataType: 'json',
          success: function(products) {
            //products = "nada";
            $('.table_transactions_container').html(products);
            datatables_transactions();
          }
        });
    });


    $("#search_client .search").click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: baseUrl+"report/get_clients/",
          data: $('#search_client').serialize(),
          //dataType: 'json',
          success: function(products) {
            //products = "nada";
            $('.table_clients_container').html(products);
            datatables_clients();
          }
        });
    });
    /*

    //tabla de lista de usuarios
    var colUser=[ 0, 1, 2, 3, 4, 5 ];
    $('.table_user').dataTable( {
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"Tfr>t<"F"ip>',
        "oTableTools": {
            "aButtons": [
            {
                "sExtends": "copy",
                "sButtonText": "Copiar al portapapeles",
                "mColumns": colUser
            },
            {
                "sExtends": "csv",
                "sButtonText": "CSV",
                "mColumns": colUser
            },
            {
                "sExtends": "xls",
                "sButtonText": "Excel",
                "mColumns": colUser
            },
            {
                "sExtends": "pdf",
                "sButtonText": "PDF",
                "mColumns": colUser
            },
            {
                "sExtends":    "collection",
                "sButtonText": "Guardar",
                "aButtons":    [
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "mColumns": colUser
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
                    "mColumns": colUser
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "mColumns": colUser
                }
                ]
            }
            ]
        }
    } );

    //tabla de lista de proveedores
    var colProvider=[ 0, 1, 2, 3, 4, 5 ];
    $('.table_provider').dataTable( {
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"Tfr>t<"F"ip>',
        "oTableTools": {
            "aButtons": [
            {
                "sExtends": "copy",
                "sButtonText": "Copiar al portapapeles",
                "mColumns": colProvider
            },
            {
                "sExtends": "csv",
                "sButtonText": "CSV",
                "mColumns": colProvider
            },
            {
                "sExtends": "xls",
                "sButtonText": "Excel",
                "mColumns": colProvider
            },
            {
                "sExtends": "pdf",
                "sButtonText": "PDF",
                "mColumns": colProvider
            },
            {
                "sExtends":    "collection",
                "sButtonText": "Guardar",
                "aButtons":    [
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "mColumns": colProvider
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
                    "mColumns": colProvider
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "mColumns": colProvider
                }
                ]
            }
            ]
        }
    } );

    //tabla de historial de login de usuarios
    var colLogin=[ 0, 1, 2, 3 ];
    $('.table_user_history').dataTable( {
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"Tfr>t<"F"ip>',
        "oTableTools": {
            "aButtons": [
            {
                "sExtends": "copy",
                "sButtonText": "Copiar al portapapeles",
                "mColumns": colLogin
            },
            {
                "sExtends": "csv",
                "sButtonText": "CSV",
                "mColumns": colLogin
            },
            {
                "sExtends": "xls",
                "sButtonText": "Excel",
                "mColumns": colLogin
            },
            {
                "sExtends": "pdf",
                "sButtonText": "PDF",
                "mColumns": colLogin
            },
            {
                "sExtends":    "collection",
                "sButtonText": "Guardar",
                "aButtons":    [
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "mColumns": colLogin
                },
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
                    "mColumns": colLogin
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "mColumns": colLogin
                }
                ]
            }
            ]
        }
    } );
*/

} );
