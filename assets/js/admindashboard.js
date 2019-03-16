
// $(window).on("load",initialize);


let clients = null;
function findClient(){
	let motif = $('input[name=motif]').val();
	let key = $('select[name=key]').val();
	let table = document.getElementById('Searchresult');
	let notfound = document.getElementById('notfound');
	let tbody = document.getElementById('tbsearch');

	$(table).css('display','none');
	$(notfound).css('display','none');

	$(tbody).empty();
	if(key !=""){
		// console.log(key);
		let array = {};
		array['key'] = key;
		array['motif'] = motif;
		let data = JSON.stringify({'data':array});
		$.ajax({
            type:'POST',
            url:'searchuser',
            data:data,
            contentType:'application/json',
            success:function(retour){
            	
            	var donne=JSON.parse(retour);
            	if(donne == false){
            		$(notfound).css('display','block');
            	}
            	else{
            		clients = donne;
            		$.each(donne,function(key,value){
	            		var tr = document.createElement('tr');
	                    var td1 = document.createElement('td');
	                    var td2 = document.createElement('td');
	                    var td3 = document.createElement('td');
	                    var td4 = document.createElement('td');
	                    var td5 = document.createElement('td');
	                    var btn = document.createElement('a');
	                    $(btn).attr('class','btn btn-info btn-sm');
	                    $(btn).attr('id',value['id']);
	                    $(btn).attr('href','#modification');
	                    $(btn).attr('onclick','editclient(this)');
	                    $(btn).text('editer');
	                    $(td1).text(value['name']);
	                    $(td2).text(value['username']);
	                    $(td3).text(value['email']);
	                    $(td4).text(value['phoneNum']);
	                    td5.appendChild(btn);
	                    tr.appendChild(td1);
	                    tr.appendChild(td2);
	                    tr.appendChild(td3);
	                    tr.appendChild(td4);
	                    tr.appendChild(td5);
	                    tbody.appendChild(tr);
	            	});
	            	$(table).css('display','block');
            	}

            },
            complete:function(retour){
            	// console.log(JSON.parse(retour));
            },
            error:function(retour){
            	console.log('an error occured');
            	console.log(retour);
            }
		});
	}
}

function editclient(btn){
	let edited = document.getElementById('modification');
	$(edited).css('display','none');
	// console.log('edition encours');
	if(clients == null){
		console.log('no client to modify');
		return;
	}

	let id = $(btn).attr('id'),cl=null;
	$.each(clients,function(key,value){
		if(value['id'] === id){
			cl = value;
			return false;
		}
	});
	
	if (cl != null) {
		$("#modification :input[name=name]").attr('value',cl['name']);
		$("#modification :input[name=username]").attr('value',cl['username']);
		$("#modification :input[name=email]").attr('value',cl['email']);
		$("#modification :input[name=phoneNum]").attr('value',cl['phoneNum']);
		// $("#modification :select[name=categorie]").attr('value',cl['cat_Ref']);
		$('select option[value='+cl['cat_Ref'] +']').attr("selected",true);

		$(edited).css('display','block');
	}
}

function saveClientData(){
	let passworderror = document.getElementById('passworderror');
	let nameerror = document.getElementById('nameerror');
	let usernameerror = document.getElementById('usernameerror');
	let emailerror = document.getElementById('emailerror');
	let phoneerror = document.getElementById('phoneerror');
	let saveSuccess = document.getElementById('saveSuccess');
	let saveError = document.getElementById('saveError');

	let erroccured = 0;
	$(passworderror).parent().css('display','none');
	$(nameerror).parent().css('display','none');
	$(usernameerror).parent().css('display','none');
	$(emailerror).parent().css('display','none');
	$(phoneerror).parent().css('display','none');
	$(saveSuccess).css('display','none');
	$(saveError).css('display','none');

	if ($("#modification :input[name=password]").val() != $("#modification :input[name=password_confirmation]").val()) {
		// console.log('Passwords not matching');
		$(passworderror).html('Passwords not matching');
		$(passworderror).parent().css('display','block');
		// console.log($(passworderror).parent());
		erroccured = 1;
	}

	if ($("#modification :input[name=username]").val() == "") {
		$(usernameerror).parent().css('display','block');
		erroccured = 1;
	}
	if ($("#modification :input[name=name]").val() == "") {
		$(nameerror).parent().css('display','block');
		erroccured = 1;
	}
	if ($("#modification :input[name=email]").val() == "") {
		$(emailerror).parent().css('display','block');
		erroccured = 1;
	}
	if ($("#modification :input[name=phoneNum]").val() == "") {
		$(phoneerror).parent().css('display','block');
		erroccured = 1;
	}

	if(erroccured == 1){
		return;
	}

	let data = {};
	data['name'] = $("#modification :input[name=name]").val();
	data['username'] = $("#modification :input[name=username]").val();
	data['email'] = $("#modification :input[name=email]").val();
	data['phoneNum'] = $("#modification :input[name=phoneNum]").val();
	data['cat_Ref'] = $('select[name=categorie]').val();
	if ($("#modification :input[name=password]").val() !=""){
		data['password'] = $("#modification :input[name=password]").val();
	}
	else{
		data['password'] = "false";
	}

	let update = JSON.stringify({'update':data});
	$.ajax({
		type:'POST',
        url:'saveModifiedRecord',
        data:update,
        contentType:'application/json',
        success:function(data){
        	var donne=JSON.parse(data);
        	if(donne == "1"){
        		// $(saveSuccess).css('display','block');
        		$(saveSuccess).fadeIn(2000);
                $(saveSuccess).fadeOut(10000);
        	}

        },
        complete:function(data){
        	console.log(data);
        },
        error:function(data){
        	var donne=JSON.parse(data);
        	if(donne == "0"){
        		$(saveError).css('display','block');
        	}

        }
	});
}

function initialize(){
    $.ajax({
        type:'GET',
        url:'initClients',
        success:function(data){
            var select = document.querySelector('#prod'),clients;
            clients = JSON.parse(data);
            // console.log(clients);
            $.each(clients,function(index,value){
                var option = document.createElement('option');
                $(option).attr('value',value['CL_Ref']);
                option.text = value['CL_Intitule'];
                select.add(option);
            });
            $('select').trigger("chosen:updated");
        }
    });
}

function getClientName(){
	$('#userinput').dialog({
        modal: true,
        height:300,
        width:420,
        title: "Nom du Client",
        show:{effect: 'fade', duration: 100},
        closeOnEscape: false,
        beforeClose:function(){
            
        },
        close:function(){
            
        },
        buttons: {
        'OK': function () {
          
         }
        },
        create: function( event, ui ) {
        	initialize();
        	var cu = $(this['#userinput']);
        	console.log(cu);
        },
        open: function( event, ui ) {
        	
        }
    });
}












