function master()
{
    this.baseUrl = '';
    this.type = "";

    this.initialScript = function ()
    {
        MasterObj.dinamicBtn();
    }

    this.dinamicBtn = function ()
    {
        $('.status').unbind('click');
        $('.status').on('click', function () {
            var id = $(this).data('id');
            MasterObj.setStatus(id);
        });

        $('#create-update-form').unbind('click');
        $('#create-update-form').on('click', function () {
            var type = $('#id-produk').val();
            if(type == 'create') {
                MasterObj.create();
            } else { 
                var id = parseInt(type);
                MasterObj.updateData(id);
            }
            
        });

        $('#myModal').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            MasterObj.clearForm();
            $('#id-produk').val('create');
            if(typeof id == 'number') {
                MasterObj.getData(id);
                $('#id-produk').val(id);
            } 
        });
    }

    //create ajax
    this.create = function ()
    {
        var arrForm = [
            ['ProductsForm[code]', $('#productsform-code').val()],
            ['ProductsForm[name]', $('#productsform-name').val()],
            ['ProductsForm[price]', $('#productsform-price').val()],
        ];

        IndexObj.yiiAjaxForm(
                'product/create-ajax',
                arrForm,
                'create-update-form', //btn id
                function (data) {
                    console.log(data);
                    if(data == 'success') {
                        IndexObj.alertBox('Data berhasil buat', 'success', 1000, 'product/index');
                        MasterObj.clearForm();
                    } else {
                        IndexObj.alertBox('terjadi kesalahan input', 'danger', 1000, '');
                        if(typeof data.code !== 'undefined') {
                            $('#c-code').addClass('has-error');
                            $('#e-code').text(data.code[0]);
                        }

                        if(typeof data.name !== 'undefined') {
                            $('#c-name').addClass('has-error');
                            $('#e-name').text(data.name[0]);
                        }

                        if(typeof data.price !== 'undefined') {
                            $('#c-price').addClass('has-error');
                            $('#e-price').text(data.price[0]);
                        }
                    }
                }
        );
    }

    //update ajax
    this.updateData = function (id)
    {
        var arrForm = [
            ['id', id],
            ['ProductsForm[code]', $('#productsform-code').val()],
            ['ProductsForm[name]', $('#productsform-name').val()],
            ['ProductsForm[price]', $('#productsform-price').val()],
        ];

        IndexObj.yiiAjaxForm(
                'product/update-ajax',
                arrForm,
                'create-update-form', //btn id
                function (data) {
                    console.log(data);
                    if(data == 'success') {
                        IndexObj.alertBox('Data berhasil diubah', 'success', 1000, 'product/index');
                        MasterObj.clearForm();
                    } else {
                        IndexObj.alertBox('terjadi kesalahan input', 'danger', 1000, '');
                        if(typeof data.code !== 'undefined') {
                            $('#c-code').addClass('has-error');
                            $('#e-code').text(data.code[0]);
                        }

                        if(typeof data.name !== 'undefined') {
                            $('#c-name').addClass('has-error');
                            $('#e-name').text(data.name[0]);
                        }

                        if(typeof data.price !== 'undefined') {
                            $('#c-price').addClass('has-error');
                            $('#e-price').text(data.price[0]);
                        }
                    }
                }
        );
    }

    //Set Status
    this.setStatus = function (id)
    {
        var arrForm = [
            ['id', id],
        ];
        IndexObj.yiiAjaxForm(
                'product/set-status',
                arrForm,
                '', //btn id
                function (data) {
                    $('#btn_status_' + id).removeClass('btn-warning');
                    $('#btn_status_' + id).removeClass('btn-primary');

                    if (data == '1')
                    {
                        $('#btn_status_' + id).addClass('btn-primary');
                        $('#btn_status_' + id).text('ON');
                        IndexObj.alertBox('Status ON', 'success', 1000, '');
                    } else
                    {
                        $('#btn_status_' + id).addClass('btn-warning');
                        $('#btn_status_' + id).text('OFF');
                        IndexObj.alertBox('Status OFF', 'success', 1000, '');
                    }
                }
        );
    }

    //get data
    this.getData = function (id)
    {
        var arrForm = [
            ['id', id],
        ];
        IndexObj.yiiAjaxForm(
                'product/get-data',
                arrForm,
                '', //btn id
                function (data) {
                    console.log(data);
                    if(typeof data.code != 'undefined') {
                       $('#productsform-code').val(data.code); 
                    }
                    
                    if(typeof data.name != 'undefined') {
                       $('#productsform-name').val(data.name); 
                    }

                    if(typeof data.price != 'undefined') {
                       $('#productsform-price').val(data.price); 
                    }
                }
        );
    }

    this.clearForm = function()
    {
        $('#c-code').removeClass('has-error')
        $('#e-code').text('');
        $('#productsform-code').val(''); 

        $('#c-name').removeClass('has-error')
        $('#e-name').text('');
        $('#productsform-name').val(''); 

        $('#c-price').removeClass('has-error')
        $('#e-price').text('');
        $('#productsform-price').val(''); 
    }

}

var MasterObj = new master();