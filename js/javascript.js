var host_name = 'http://'+window.location.hostname;

$('.list-group-item[data-toggle="collapse"]').click(function () {
	if($(this).find('span').hasClass('glyphicon-plus-sign')){
		$(this).find('span').removeClass('glyphicon-plus-sign pull-right').addClass('glyphicon-minus-sign pull-right');
	}else{
		$(this).find('span').removeClass('glyphicon-minus-sign pull-right').addClass('glyphicon-plus-sign pull-right');
	}
});

$('.input-group.date').datepicker({
	format: 'dd/mm/yyyy',
	language: 'pt-BR',
	weekStart: 0,
	startDate:'0d',
	autoclose: true,
	todayHighlight: true
});

$('#bt-add-item-pedido').click(function () {
	
	/**
    var $tr = $('<tr>').append(
        $('<th>').text($('Produto').val()),
        $('<th>').text($('Quantidade').val()),
        $('<th>').text($('SituaÁ„o').val())
    ).appendTo('#tbl-resumo-pedido');    
	/**/
	
	/**
    var $tr = $('<tr>').append(
        $('<td>').text($('#item_produto').val()),
        $('<td>').text($('#item_quantidade').val()),
        $('<td>').text($('#item_situacao').val()),
        $('<td>').text('<button type="button" class="btn btn-primary glyphicon glyphicon-minus" id="bt-del-item-pedido" ></button>')
    ).appendTo('#tbl-resumo-pedido');
	
    $("#tbl-resumo-pedido").on('click','#bt-del-item-pedido',function(){
        $(this).parent().parent().remove();
    });
	/**/
	
	$('#tbl-resumo-pedido').append(
   								    '<tr>'+
										'<td>'+$('#item_produto').val()    +'</td>'+
										'<td>'+$('#item_quantidade').val() +'</td>'+
										'<td>'+$('#item_situacao').val()   +'</td>'+
										'<td><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="bt-del-item-pedido" ></button></td>'+
									'</tr>'
						          );	
	
	
    
    //$('#form-itens-pedido').find("input[type=text], textarea").val("");
    $('#form-itens-pedido')[0].reset();
        
});

$('#tbl-resumo-pedido').on('click', '#bt-del-item-pedido', function() {
    $(this).closest('tr').remove();
});


$(function() {
    
    /*Popula as combobox com os valores vindos do Banco de Dados*/
    $.ajax({
        type: "POST",
        url: host_name+'/minimundo/controller/produto/lista',
        data: {},
        dataType: "json",
        success: function(json){
            var sel = $("#item_produto");
            sel.empty();
            var options = "";
            
            /**
            $.each(json, function(i, obj){
                console.log('Codigo: '+obj.codigo + ' Descricao: '+obj.descricao);
            });
            /**/
            
			options += '<option value="0">Selecione</option>';
			
            $.each(json, function(key, value){
                options += '<option value="' + value.codigo + '">' + value.descricao + '</option>';
            });
            
            $("#item_produto").html(options);
        }
    });
    
    /*Popula as combobox com os valores vindos do Banco de Dados*/
    $.ajax({
        type: "POST",
        url: host_name+'/minimundo/controller/cliente/lista',
        data: {},
        dataType: "json",
        success: function(json){
            var sel = $("#pfk_cpf");
            sel.empty();
            var options = "";
			
			options += '<option value="0">Selecione</option>';
            
            $.each(json, function(key, value){
                options += '<option value="' + value.cpf + '">' + value.cpf + ' - ' + value.nome + '</option>';
            });
            
            $("#pfk_cpf").html(options);
        }
    });
    
	/*Popula as combobox com os valores vindos do Banco de Dados*/
    $.ajax({
        type: "POST",
        url: host_name+'/minimundo/controller/cliente/lista',
        data: {},
        dataType: "json",
        success: function(json){
            var sel = $("#cpf_pedido");
            sel.empty();
            var options = "";
			
			options += '<option value="0">Selecione</option>';
            
            $.each(json, function(key, value){
                options += '<option value="' + value.cpf + '">' + value.cpf + ' - ' + value.nome + '</option>';
            });
            
            $("#cpf_pedido").html(options);
        }
    });
    
    /*Popula as combobox com os valores vindos do Banco de Dados*/
    $.ajax({
        type: "POST",
        url: host_name+'/minimundo/controller/fornecedor/lista',
        data: {},
        dataType: "json",
        success: function(json){
            var sel = $("#pfk_cnpj");
            sel.empty();
            var options = "";
			
			options += '<option value="0">Selecione</option>';
            
            $.each(json, function(key, value){
                options += '<option value="' + value.cnpj + '">' + value.cnpj + ' - ' + value.nome + '</option>';
            });
            
            $("#pfk_cnpj").html(options);
        }
    });
    
    

});

function switchView(id_target, class_action)
//function switchView('form-clientes', 'cliente/lista')
{
    
    //Fecha todos os outros formul·rios
    $('#container-principal').find('form').hide()
    
    //N„o foi passada nenhuma aÁ„o. Logo, ser· exibido o formul·rio de Cadastro
    if(class_action.length == 0){
		
		if(id_target.toLowerCase().indexOf("div") >= 0){
			$('#'+id_target).show();
		}else{
			$('#container-principal').find('form').hide();
			$('#'+id_target).show();
		}
		
        
    }else{
        
        $.ajax({
            type: "POST",
            url: host_name+'/minimundo/controller/'+class_action,
            data: {},
            dataType: "json",
            success: function(json){
                if(json){

                    if(id_target.toLowerCase().localeCompare("form-lista-clientes") == 0){
                        
                        $('#tab-lista-clientes').html(
                                       '<tr>'+
                                        '<th>CPF</th>'+
                                        '<th>Nome</th>'+
                                        '<th>E-mail</th>'+
                                        '<th>Endere√ßo</th>'+
                                        '<th>CEP</th>'+
                                        '<th>Senha</th>'+
                                        '<th>A√ßao</th>'+
                                    '</tr>'
                                  );
                        
                        $.each(json, function(i, obj){
                            console.log(obj);
                            $('#tab-lista-clientes').append(
                                       '<tr>'+
                                        '<td>'+ obj.cpf    +'</td>'+
                                        '<td>'+ obj.nome +'</td>'+
                                        '<td>'+ obj.email   +'</td>'+
                                        '<td>'+ obj.endereco   +'</td>'+
                                        '<td>'+ obj.cep   +'</td>'+
                                        '<td>'+ obj.senha   +'</td>'+
                                        '<td><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="bt-del-cliente" onclick="deleteRecord(\'cliente/apaga\','+ obj.cpf +')" ></button></td>'+
                                    '</tr>'
                                  );    
                        });
                        
                        $('#form-lista-clientes').show();
                        $('#tab-lista-clientes').show();
                        
                    }else if(id_target.toLowerCase().localeCompare("form-lista-tel-clientes") == 0){
                        
                        $('#tab-lista-tel-clientes').html(
                                       '<tr>'+
                                        '<th>CPF</th>'+
                                        '<th>Numero</th>'+
                                        '<th>A√ßao</th>'+                                        
                                    '</tr>'
                                  );
                        
                        $.each(json, function(i, obj){
                            console.log(obj);
                            $('#tab-lista-tel-clientes').append(
                                       '<tr>'+
                                        '<td>'+ obj.cpf    +'</td>'+
                                        '<td>'+ obj.numero +'</td>'+
                                        '<td><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="bt-del-cliente" onclick="deleteRecord(\'telCliente/apaga\', '+ '\'' + obj.cpf + '#' + obj.numero + '\''  +')" ></button></td>'+
                                    '</tr>'
                                  );    
                        });
                        
                        $('#form-lista-tel-clientes').show();
                        $('#tab-lista-tel-clientes').show();
                        
                    }else if(id_target.toLowerCase().localeCompare("form-lista-fornecedores") == 0){
                        
                        $('#tab-lista-fornecedores').html(
                                       '<tr>'+
                                        '<th>CNPJ</th>'+
                                        '<th>Endere√ßo</th>'+
                                        '<th>Nome</th>'+
                                        '<th>A√ßao</th>'+                                        
                                    '</tr>'
                                  );
                        
                        $.each(json, function(i, obj){
                            console.log(obj);
                            $('#tab-lista-fornecedores').append(
                                       '<tr>'+
                                        '<td>'+ obj.cnpj    +'</td>'+
                                        '<td>'+ obj.endereco +'</td>'+
                                        '<td>'+ obj.nome +'</td>'+
                                        '<td><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="bt-del-cliente" onclick="deleteRecord(\'fornecedor/apaga\', '+ '\'' + obj.cnpj  + '\''  +')" ></button></td>'+
                                    '</tr>'
                                  );    
                        });
                        
                        $('#form-lista-fornecedores').show();
                        $('#tab-lista-fornecedores').show();
                    }else if(id_target.toLowerCase().localeCompare("form-lista-tel-fornecedores") == 0){
                        
                        $('#tab-lista-tel-fornecedores').html(
                                       '<tr>'+
                                        '<th>CNPJ</th>'+
                                        '<th>Numero</th>'+
                                        '<th>A√ßao</th>'+                                        
                                    '</tr>'
                                  );
                        
                        $.each(json, function(i, obj){
                            console.log(obj);
                            $('#tab-lista-tel-fornecedores').append(
                                       '<tr>'+
                                        '<td>'+ obj.cnpj    +'</td>'+
                                        '<td>'+ obj.numero +'</td>'+
                                        '<td><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="bt-del-cliente" onclick="deleteRecord(\'telFornecedor/apaga\', '+ '\'' + obj.cnpj + '#' + obj.numero + '\''  +')" ></button></td>'+
                                    '</tr>'
                                  );    
                        });
                        
                        $('#form-lista-tel-fornecedores').show();
                        $('#tab-lista-tel-fornecedores').show();
                        
                    }else if(id_target.toLowerCase().localeCompare("form-lista-produtos") == 0){
                        
                        $('#tab-lista-produtos').html(
                                       '<tr>'+
                                        '<th>Codigo</th>'+
                                        '<th>Descri√ßao</th>'+
                                        '<th>Unidade</th>'+
                                        '<th>Disponibilidade</th>'+                                        
                                        '<th>Pre√ßo de Venda</th>'+                                        
                                        '<th>A√ßao</th>'+
                                    '</tr>'
                                  );
                        
                        $.each(json, function(i, obj){
                            console.log(obj);
                            $('#tab-lista-produtos').append(
                                       '<tr>'+
                                        '<td>'+ obj.codigo    +'</td>'+
                                        '<td>'+ obj.descricao +'</td>'+
                                        '<td>'+ obj.unidade +'</td>'+
                                        '<td>'+ obj.Disponibilidade +'</td>'+
                                        '<td>'+ obj.precovenda +'</td>'+
                                        '<td><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="bt-del-cliente" onclick="deleteRecord(\'produto/apaga\', '+ '\'' + obj.codigo  + '\''  +')" ></button></td>'+
                                    '</tr>'
                                  );    
                        });
                        
                        $('#form-lista-produtos').show();
                        $('#tab-lista-produtos').show();
                    }
                    
                    
                    
                }
            }
        });  
    }
}

function deleteRecord(class_action, pk)
{
    var classAction = class_action.replace("/", "");
    
    if(classAction.toLowerCase().localeCompare("clienteapaga") == 0){
        
        $.ajax({
            type: "POST",
            url: host_name+'/minimundo/controller/'+class_action,
            data:{cpf: pk},
            dataType: "json",
            success: function(json){
                if(json){
                    $('#hid-modal-success').modal('show');
                    $(this)[0].reset();
                }else{
                    $('#hid-modal-error').modal('show')
                }
            }
        });
            
    }else if(classAction.toLowerCase().localeCompare("telclienteapaga") == 0){
        
        var arrStr = pk.split("#");
        
        $.ajax({
            type: "POST",
            url: host_name+'/minimundo/controller/'+class_action,
            data:{cpf: arrStr[0], numero: arrStr[1]},
            dataType: "json",
            success: function(json){
                if(json){
                    $('#hid-modal-success').modal('show');
                    $(this)[0].reset();
                }else{
                    $('#hid-modal-error').modal('show')
                }
            }
        });
            
    }else if(classAction.toLowerCase().localeCompare("fornecedorapaga") == 0){
        
        $.ajax({
            type: "POST",
            url: host_name+'/minimundo/controller/'+class_action,
            data:{cnpj: pk},
            dataType: "json",
            success: function(json){
                if(json){
                    $('#hid-modal-success').modal('show');
                    $(this)[0].reset();
                }else{
                    $('#hid-modal-error').modal('show')
                }
            }
        });
            
    }else if(classAction.toLowerCase().localeCompare("telfornecedorapaga") == 0){
        
        var arrStr = pk.split("#");
        
        $.ajax({
            type: "POST",
            url: host_name+'/minimundo/controller/'+class_action,
            data:{cnpj: arrStr[0], numero: arrStr[1]},
            dataType: "json",
            success: function(json){
                if(json){
                    $('#hid-modal-success').modal('show');
                    $(this)[0].reset();
                }else{
                    $('#hid-modal-error').modal('show')
                }
            }
        });
            
    }else if(classAction.toLowerCase().localeCompare("produtoapaga") == 0){
        
        $.ajax({
            type: "POST",
            url: host_name+'/minimundo/controller/'+class_action,
            data:{codigo: pk},
            dataType: "json",
            success: function(json){
                if(json){
                    $('#hid-modal-success').modal('show');
                    $(this)[0].reset();
                }else{
                    $('#hid-modal-error').modal('show')
                }
            }
        });
            
    }
}

/*
function submitForm(idForm)
{
    alert($('#'+idForm).find('input').length);
    alert($('#'+idForm).serialize());
    
    console.log('Form:' + $('#'+idForm).serialize() );
    
}
*/

$( "form" ).on( "submit", function( event ) {
    event.preventDefault();

    var form = $(this);
    var name = $("[name='acao']", form).val();
  
    $.ajax({
        type: "POST",
        url: host_name+'/minimundo/controller/'+name,
        data: $(this).serialize(),
        dataType: "json",
        success: function(json){
            if(json){
                $('#hid-modal-success').modal('show');
                $(this)[0].reset();
            }else{
                $('#hid-modal-error').modal('show')
            }
        }
    });  
  
    console.log( $( this ).serialize() );
});

$('#bt-salvar-pedido').click(function () {
	alert('bot„o pedido');
	
    var form = $('#form-pedidos');
    var name = $("[name='acao']", form).val();
  
    $.ajax({
        type: "POST",
        url: host_name+'/minimundo/controller/'+name,
        data: $('#form-pedidos').serialize(),
        dataType: "json",
        success: function(json){
            if(json.length > 0){
                $('#hid-modal-success').modal('show');
                
				$('#form-itens-pedidos').show();
				$('#fpk_pedido').val(json.numero);
				
				console.log('pedido: '+json.numero);
				
                $('#form-pedidos')[0].reset();
            }else{
                $('#hid-modal-error').modal('show')
            }
        }
    });  
  
    console.log( $('#form-pedidos').serialize() );	
	
});