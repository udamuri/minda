function pos()
{
    this.baseUrl = '';
    this.type = "";
    this.total = 0;

    this.initialScript = function ()
    {
        PosObj.dinamicBtn();
    }

    this.dinamicBtn = function ()
    {
        $('#input-ajax').unbind('click');
        $('#input-ajax').on('click', function(){
            PosObj.create();
        });
    }
    
    //create ajax
    this.create = function ()
    {
        alert($('#code').val());
        var arrForm = [
            ['TransactionsForm[code]', $('#code').val()],
            ['TransactionsForm[qty]', $('#qty').val()],
        ];

        IndexObj.yiiAjaxForm(
                'pos/create',
                arrForm,
                'input-ajax', //btn id
                function (data) {
                    console.log(data);
                    if(typeof data == 'object' && data.user_id !== 'undefined') {
                        var total = (data.qty * data.price);
                        var html = '';
                            html += '<tr>';
                            html +=     '<td>'+data.code+'</td>';
                            html +=     '<td>'+data.name+'</td>';
                            html +=     '<td>'+data.qty+'</td>';
                            html +=     '<td>'+ total +' <input type="hidden" class="total" value="'+total+'" > </td>';
                            html +=     '<td><button class="btn btn-danger hapus" >Hapus</button></td>';
                            html += '</tr>';
                        $('#body-1').append(html);
                        PosObj.totalData();
                        var htmlTotal =  '<tr>';
                            htmlTotal +=    '<td colspan="3"></td>';
                            htmlTotal +=    '<td>'+PosObj.total+'</td>';
                            htmlTotal +=    '<td></td>';
                            htmlTotal += '</tr>';
                        $('#body-2').html(htmlTotal);

                        IndexObj.alertBox('Data berhasil buat', 'success', 1000, '');
                        PosObj.clearForm();
                    } else {
                        IndexObj.alertBox('terjadi kesalahan input', 'danger', 1000, '');
                        if(typeof data.code !== 'undefined') {
                            $('#c-code').addClass('has-error');
                            $('#e-code').text(data.code[0]);
                        }

                        if(typeof data.qty !== 'undefined') {
                            $('#c-qty').addClass('has-error');
                            $('#e-qty').text(data.qty[0]);
                        }
                    }
                }
        );
    }
    
    this.clearForm = function()
    {
        $('#c-code').removeClass('has-error')
        $('#e-code').text('');
        $('#code').val(''); 

        $('#c-qty').removeClass('has-error')
        $('#e-qty').text('');
        $('#qty').val('');  
    }
    
    this.totalData = function()
    {
        PosObj.total = 0;
        $('.total').each(function(){
            PosObj.total = parseInt(PosObj.total) + parseInt($(this).val());
        });
    }

    

}

var PosObj = new pos();