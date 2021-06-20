/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

function catChange(admin = false) {
    $('#user_category_id').val($('#category').val());
    if ($('#category').val() === "5") {
        $('#licence_number_div').removeClass('d-none');
        $('#s_name_div').removeClass('d-none');
        $('#commercial_name_div').removeClass('d-none');
        if (admin) {
            $('#company_div').addClass('d-none');
            $('#agent_div').addClass('d-none');
        }
    } else if ($('#category').val() === "1") {
        $('#licence_number_div').addClass('d-none');
        $('#s_name_div').addClass('d-none');
        $('#commercial_name_div').addClass('d-none');
        if (admin) {
            $('#company_div').addClass('d-none');
            $('#agent_div').addClass('d-none');
        }
    } else {
        $('#licence_number_div').addClass('d-none');
        $('#s_name_div').removeClass('d-none');
        $('#commercial_name_div').removeClass('d-none');
        if (admin) {
            $('#company_div').addClass('d-none');
            $('#agent_div').addClass('d-none');
            if ($('#category').val() === "2")
                $('#company_div').removeClass('d-none');
            if ($('#category').val() === "3")
                $('#agent_div').removeClass('d-none');
        }
    }

}
// $('#category').on('change', function() {
//   $('#user_category_id').val(this.value);
//   if(this.value === "5")
//     {
//       $('#licence_number_div').removeClass('d-none');
//       $('#s_name_div').removeClass('d-none');
//     }
//   else if(this.value === "1")
//     {
//       $('#licence_number_div').addClass('d-none');
//       $('#s_name_div').addClass('d-none');
//     }
//   else
//     {
//       $('#licence_number_div').addClass('d-none');
//       $('#s_name_div').removeClass('d-none');
//     }

// });

$('#country').on('change', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var country = this.value;

    $('#city').find('option').remove();

    $.ajax({
        type: 'POST',
        url: '/ajaxCountryRequest',
        data: { country: country },
        success: function(data) {
            $.each(data, function(key) {
                var o = new Option(data[key].ar_name, data[key].id);
                /// jquerify the DOM object 'o' so we can use the html method
                $(o).html(data[key].ar_name);
                $("#city").append(o);
            });
        }
    });
});

// function itemsOfferAjax() {
//     $.ajaxSetup({
//           headers: {
//               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//           }
//     });

//     $('#item_id').find('option').remove();
//     $('#free_item').find('option').remove();

//     $.ajax({
//          type:'POST',
//          url:'/ajaxItemRequest',
//          data:{},
//          success:function(data){
//            console.log(data);
//           $.each(data, function(key) {
//             var o = new Option(data[key].name + " " + data[key].item_type_id + " " + data[key].titer, data[key].id);
//             /// jquerify the DOM object 'o' so we can use the html method
//             $(o).html(data[key].name + " " + data[key].item_type_id + " " + data[key].titer);
//             $("#item_id").append(o);
//           });
//           $.each(data, function(key) {
//             var o = new Option(data[key].name + " " + data[key].item_type_id + " " + data[key].titer, data[key].id);
//             /// jquerify the DOM object 'o' so we can use the html method
//             $(o).html(data[key].name + " " + data[key].item_type_id + " " + data[key].titer);
//             $("#free_item").append(o);
//           });
//          }
//     });
// }

function addChildAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/userRelations/child',
        data: { id: id },
        success: function(data) {
            $('#addBtn' + id).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function addParentAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/userRelations/parent',
        data: { id: id },
        success: function(data) {
            $('#addBtn' + id).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function freezeRelAjax(id, freezed) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'PUT',
        url: '/userRelations/freeze',
        data: { id: id, freezed: freezed },
        success: function(data) {
            $('#freezeBtn' + id).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function verifyRelAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'PUT',
        url: '/userRelations/verify',
        data: { id: id },
        success: function(data) {
            console.log(data);
            location.reload();
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function reqRelAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/userRelations/requestAg',
        data: { id: id },
        success: function(data) {
            console.log(data);
            location.reload();
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function postItemAjax(id, name, isBasket = null) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/cart/postItem',
        data: { id: id },
        success: function(data) {
            $("#cartFormModal").find('#reciever_id').find('option').remove();
            $.each(data, function(key) {
                var o = new Option(data[key].f_name, data[key].id);
                /// jquerify the DOM object 'o' so we can use the html method
                $(o).html(data[key].f_name + " " + data[key].s_name);
                $("#cartFormModal").find("#reciever_id").append(o);
            });
            $("#cartFormModal").find("#item").val(name);
            $("#cartFormModal").find("#item_id").val(id);
            $("#cartFormModal").find("#isBasket").val(isBasket);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function postFormAjax(formId, modalId = null) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log($('#' + formId).serialize());
    $.ajax({
        type: 'POST',
        url: $('#' + formId).attr("action"),
        data: $('#' + formId).serialize(),
        success: function(data) {
            if (modalId !== null)
                $('#' + modalId).modal('hide');
            console.log(data);
            // location.reload();
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function verUsrAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: '/user/verify',
        data: { id: id },
        success: function(data) {
            $('#verBtn' + id).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function frzUsrAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: '/user/freeze',
        data: { id: id },
        success: function(data) {
            $('#frzUsrBtn' + id).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function unfrzUsrAjax(id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: '/user/unfreeze',
        data: { id: id },
        success: function(data) {
            $('#unfrzUsrBtn' + id).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function verItemInOrder(order = null, item = null) {
    if (order == null && item == null) {
        var order = $('#order_item_id').val();
        var item = $('#item_id').val();
    }
    var remark = $('#reciever_remark_item_txt').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: '/orders/verifyItem',
        data: { order: order, item: item, remark: remark },
        success: function(data) {
            $('#verOrdItmBtn' + order + item).addClass('disabled');
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function toLocalTime(timeString) {
    var d = new Date();
    var n = d.getTimezoneOffset() * 60;
    time = timeString.split(/:/);
    sTime = time[0] * 3600 + time[1] * 60 + time[2] * 1 - n;
    var strHr = Math.floor(sTime / 3600);
    if (strHr > 23) strHr -= 24;
    strHr.toString();
    var strMn = Math.floor((sTime % 3600) / 60).toString();
    var strSc = ((sTime % 3600) % 60).toString();
    if (strHr.length < 2) strHr = "0" + strHr;
    if (strMn.length < 2) strMn = "0" + strMn;
    if (strSc.length < 2) strSc = "0" + strSc;
    strTime = strHr + ":" + strMn + ":" + strSc;
    return strTime;
}

function tablesFunc(table) {
    $('#' + table + '_filter').addClass('float-right');
    $('#' + table + '_filter').find('input').addClass('ml-2');
    $('#' + table + '_previous').find('a').html('<i class="fas fa-forward"></i>');
    $('#' + table + '_next').find('a').html('<i class="fas fa-backward"></i>');
}
//   function filterFunction(listName,input) {
//   var input, filter, ul, li, a, i;
//   input = $("#"+input);
//   filter = input.value.toUpperCase();
//   div = $("#"+listName);
//   options = div.find("option");
//   for (i = 0; i < options.length; i++) {
//     txtValue = options[i].textContent || options[i].innerText;
//     if (txtValue.toUpperCase().indexOf(filter) > -1) {
//       options[i].style.display = "";
//     } else {
//       options[i].style.display = "none";
//     }
//   }
// }